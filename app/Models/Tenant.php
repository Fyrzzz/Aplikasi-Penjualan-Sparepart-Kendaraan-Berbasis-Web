<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;

    public function isActive(): bool
    {
        return ($this->getAttribute('status') ?? 'active') === 'active';
    }

    public function owner(): HasOne
    {
        return $this->hasOne(User::class, 'tenant_id', 'id')
            ->where('role', 'Owner');
    }
}
