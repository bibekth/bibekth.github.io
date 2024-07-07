<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Variant extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name','variant_code','description','status',
    ];

    protected $casts = [
        'id' =>'string',
        'status'=>'string',
    ];

    protected function productPrice(){
        return $this->hasMany(ProductPrice::class,'variant_id');
    }
}
