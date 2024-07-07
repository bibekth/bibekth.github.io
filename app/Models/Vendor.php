<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DateTimeInterface;

class Vendor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'firm_name', 'address', 'contact', 'pan_vat', 'email', 'status',
    ];

    protected $casts = [
        'id' =>'string',
        'contact'=>'string',
        'pan_vat'=>'string',
        'status'=>'string',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'vendor_id');
    }
    public function vendorAssign()
    {
        return $this->hasMany(AssignCustomer::class, 'vendor_id');
    }

    public function productPrice()
    {
        return $this->hasMany(ProductPrice::class, 'vendor_id');
    }

    public function cashTransaction(){
        return $this->hasMany(CashTransaction::class,'vendor_id');
    }

    public function vendorFile(){
        return $this->hasMany(VendorFiles::class,'vendor_id');
    }
}
