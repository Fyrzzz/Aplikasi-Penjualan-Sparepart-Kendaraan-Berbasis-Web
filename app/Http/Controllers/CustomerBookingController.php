<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CustomerBookingController extends Controller
{
    public function show(Request $request, string $id): View
    {
        $tenant = Tenant::query()->findOrFail($id);
        abort_unless($tenant->isActive(), 404);

        $services = $tenant->run(fn () => DB::table('service_catalog')
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'description', 'price']));

        $vehicles = DB::table('customer_vehicles')
            ->where('user_id', $request->user()->id)
            ->orderBy('id')
            ->get();

        return view('bengkel.detail', compact('tenant', 'services', 'vehicles'));
    }

    public function store(Request $request, string $id): RedirectResponse
    {
        $tenant = Tenant::query()->findOrFail($id);
        abort_unless($tenant->isActive(), 404);

        $validated = $request->validate([
            'vehicle_id' => [
                'nullable',
                'integer',
                Rule::exists('customer_vehicles', 'id')->where('user_id', $request->user()->id),
            ],
            'license_plate' => ['required', 'string', 'max:20'],
            'brand' => ['required', 'string', 'max:100'],
            'model' => ['required', 'string', 'max:100'],
            'year' => ['nullable', 'integer', 'between:1900,'.(now()->year + 1)],
            'odometer' => ['nullable', 'integer', 'min:0'],
            'scheduled_date' => ['required', 'date', 'after_or_equal:today'],
            'scheduled_time' => ['required', 'date_format:H:i'],
            'complaint' => ['nullable', 'string', 'max:2000'],
            'service_id' => ['nullable', 'integer'],
        ], [
            'vehicle_id.exists' => 'Kendaraan yang dipilih tidak ditemukan.',
            'scheduled_date.after_or_equal' => 'Tanggal booking tidak boleh sebelum hari ini.',
        ]);

        $vehicleDetails = $validated;
        if (! empty($validated['vehicle_id'])) {
            $savedVehicle = DB::table('customer_vehicles')
                ->where('id', $validated['vehicle_id'])
                ->where('user_id', $request->user()->id)
                ->first();

            $vehicleDetails = [
                ...$validated,
                'license_plate' => $savedVehicle->license_plate,
                'brand' => $savedVehicle->brand,
                'model' => $savedVehicle->model,
                'year' => $savedVehicle->year,
                'odometer' => $savedVehicle->odometer,
            ];
        }

        $tenant->run(function () use ($validated, $request, $vehicleDetails): void {
            DB::transaction(function () use ($validated, $request, $vehicleDetails): void {
                $service = null;
                if (! empty($validated['service_id'])) {
                    $service = DB::table('service_catalog')
                        ->where('id', $validated['service_id'])
                        ->where('is_active', true)
                        ->first();

                    if ($service === null) {
                        throw ValidationException::withMessages([
                            'service_id' => 'Layanan yang dipilih sudah tidak tersedia.',
                        ]);
                    }
                }

                $customer = DB::table('customers')
                    ->where('central_user_id', $request->user()->id)
                    ->first();

                $customerData = [
                    'name' => $request->user()->name,
                    'phone' => $request->user()->phone,
                    'email' => str_ends_with((string) $request->user()->email, '@accounts.amahay.invalid')
                        ? null
                        : $request->user()->email,
                    'updated_at' => now(),
                ];

                if ($customer === null) {
                    $customerId = DB::table('customers')->insertGetId([
                        ...$customerData,
                        'central_user_id' => $request->user()->id,
                        'created_at' => now(),
                    ]);
                } else {
                    $customerId = $customer->id;
                    DB::table('customers')->where('id', $customerId)->update($customerData);
                }

                $licensePlate = Str::upper($vehicleDetails['license_plate']);
                $vehicle = DB::table('vehicles')->where('license_plate', $licensePlate)->first();
                if ($vehicle !== null && $vehicle->customer_id !== $customerId) {
                    throw ValidationException::withMessages([
                        'license_plate' => 'Nomor plat kendaraan sudah terdaftar pada akun lain di bengkel ini.',
                    ]);
                }

                $tenantVehicle = [
                    'license_plate' => $licensePlate,
                    'brand' => $vehicleDetails['brand'],
                    'model' => $vehicleDetails['model'],
                    'year' => $vehicleDetails['year'] ?? null,
                    'odometer' => $vehicleDetails['odometer'] ?? 0,
                    'updated_at' => now(),
                ];

                if ($vehicle === null) {
                    $vehicleId = DB::table('vehicles')->insertGetId([
                        ...$tenantVehicle,
                        'customer_id' => $customerId,
                        'created_at' => now(),
                    ]);
                } else {
                    $vehicleId = $vehicle->id;
                    DB::table('vehicles')->where('id', $vehicleId)->update($tenantVehicle);
                }

                $workOrderId = DB::table('work_orders')->insertGetId([
                    'work_order_number' => 'WO-'.Str::upper((string) Str::ulid()),
                    'customer_id' => $customerId,
                    'vehicle_id' => $vehicleId,
                    'status' => 'waiting',
                    'complaint' => $validated['complaint'] ?? null,
                    'odometer' => $vehicleDetails['odometer'] ?? 0,
                    'scheduled_at' => $validated['scheduled_date'].' '.$validated['scheduled_time'].':00',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                if ($service !== null) {
                    DB::table('work_order_services')->insert([
                        'work_order_id' => $workOrderId,
                        'service_id' => $service->id,
                        'service_name' => $service->name,
                        'quantity' => 1,
                        'unit_price' => $service->price,
                        'subtotal' => $service->price,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

            });
        });

        $licensePlate = Str::upper($vehicleDetails['license_plate']);
        DB::table('customer_vehicles')->updateOrInsert(
            [
                'user_id' => $request->user()->id,
                'license_plate' => $licensePlate,
            ],
            [
                'brand' => $vehicleDetails['brand'],
                'model' => $vehicleDetails['model'],
                'year' => $vehicleDetails['year'] ?? null,
                'odometer' => $vehicleDetails['odometer'] ?? 0,
                'updated_at' => now(),
                'created_at' => now(),
            ],
        );

        return redirect()->route('user.riwayat')->with('success', 'Booking berhasil dibuat. Silakan lihat antrean pada riwayat servis.');
    }
}
