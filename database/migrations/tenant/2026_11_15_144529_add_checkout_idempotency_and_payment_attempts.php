<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->uuid('checkout_idempotency_key')->nullable()->unique();
            $table->string('checkout_payload_hash', 64)->nullable();
        });

        Schema::create('payment_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('attempt_number');
            $table->string('payment_reference')->unique();
            $table->string('idempotency_key')->unique();
            $table->string('provider')->default('fake_qris');
            $table->string('provider_reference')->nullable()->unique();
            $table->string('status')->default('creating')->index();
            $table->decimal('amount', 15, 2);
            $table->text('qris_payload')->nullable();
            $table->timestamp('expires_at')->nullable()->index();
            $table->json('response_metadata')->nullable();
            $table->timestamps();
            $table->unique(['payment_id', 'attempt_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_attempts');

        Schema::table('sales', function (Blueprint $table) {
            $table->dropUnique('sales_checkout_idempotency_key_unique');
            $table->dropColumn(['checkout_idempotency_key', 'checkout_payload_hash']);
        });
    }
};
