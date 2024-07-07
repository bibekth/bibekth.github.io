<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasFactory, HasDatabase, HasDomains, SoftDeletes;
    protected $table = 'tenants';
    protected $fillable = [
        'id', 'name', 'email', 'tenant_logo', 'password',
    ];

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'name',
            'email',
            'tenant_logo',
            'password',
            'created_at',
            'updated_at',
            'deleted_at'
        ];
    }
}
