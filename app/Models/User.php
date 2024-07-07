<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use DateTimeInterface;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'otp_code',
        'otp_registered',
        'mpin',
        'role',
        'token',
        'device_id',
        'status',
        'fcm_id',
        'vendor_id',
        'customer_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'id'=>'string',
        'phone_number'=>'string',
        'otp_code'=>'string',
        'mpin'=>'string',
        'vendor_id'=>'string',
        'customer_id'=>'string',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    protected function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    protected function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
