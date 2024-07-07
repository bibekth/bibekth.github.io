<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
use Illuminate\Database\Eloquent\SoftDeletes;

class Draft extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'assign_customer_id','product_price_id','status','quantity',
    ];

    protected $casts = [
        'id'=>'string',
        'assign_customer_id'=>'string',
        'product_price_id'=>'string',
        'quantity'=>'string',
        'status'=>'string',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function assignCustomer(){
        return $this->belongsTo(AssignCustomer::class,'assign_customer_id');
    }

    public function productPrice(){
        return $this->belongsTo(ProductPrice::class,'product_price_id');
    }
}
