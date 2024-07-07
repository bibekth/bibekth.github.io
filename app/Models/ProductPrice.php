<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DateTimeInterface;

class ProductPrice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'variant_id',
        'vendor_id',
        'quantity',
        'price',
        'status',
    ];

    protected $casts = [
        'id' =>'string',
        'product_id' =>'string',
        'variant_id' =>'string',
        'vendor_id' =>'string',
        'quantity' =>'string',
        'price' =>'string',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function variant()
    {
        return $this->belongsTo(Variant::class, 'variant_id');
    }
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
    public function activities(){
        return $this->hasMany(Activity::class,'product_price_id');
    }

    public function draft(){
        return $this->hasMany(Draft::class,'product_price_id');
    }

}
