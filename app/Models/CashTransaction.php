<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
use Illuminate\Database\Eloquent\SoftDeletes;

class CashTransaction extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'amount','status','vendor_id'
    ];

    protected $casts = [
        'id'=>'string',
        'amount'=>'string',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function vendor(){
        return $this->belongsTo(Vendor::class,'vendor_id');
    }

    public function activity(){
        return $this->hasMany(Activity::class,'cash_transaction_id');
    }
}
