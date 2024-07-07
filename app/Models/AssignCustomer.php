<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class AssignCustomer extends Model
{
    use HasFactory;
    protected $table = 'assigncustomers';
    protected $fillable = [
        'vendor_id', 'customer_id',
    ];

    protected $casts = [
        'id' => 'string',
        'vendor_id' => 'string',
        'customer_id' => 'string',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function assignVendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function assignCustomer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class, 'assign_customer_id');
    }

    public function creditAmount()
    {
        return $this->hasOne(CustomerCredit::class, 'assign_customer_id');
    }

    public function payment()
    {
        return $this->hasMany(Payment::class, 'assign_customer_id');
    }

    public function draft()
    {
        return $this->hasMany(Draft::class, 'assign_customer_id');
    }
}
