<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DateTimeInterface;

class Customer extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'name',
        'phone_number',
        'email',
        'address',
        'status',
    ];

    protected $casts = [
        'id' =>'string',
        'phone_number'=>'string',
        'status'=>'string',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    protected function user()
    {
        return $this->hasOne(User::class, 'customer_id');
    }

    protected function customerAssign()
    {
        return $this->hasMany(AssignCustomer::class, 'customer_id');
    }
}
