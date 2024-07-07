<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DateTimeInterface;

class Product extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name','description','status',
    ];

    protected $casts = [
        'id' =>'string',
        'status'=>'string',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    protected function productPrice(){
        return $this->hasMany(ProductPrice::class,'product_id');
    }
}
