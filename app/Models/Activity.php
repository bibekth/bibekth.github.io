<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DateTimeInterface;

class Activity extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cash_transaction_id', 'credit_transaction_id', 'product_price_id', 'credit_amount', 'payment_type', 'status',
    ];

    protected $casts = [
        'id' => 'string',
        'cash_transaction_id' => 'string',
        'credit_transaction_id' => 'string',
        'product_price_id' => 'string',
        'credit_amount' => 'string',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    // public function assignCustomer()
    // {
    //     return $this->belongsTo(AssignCustomer::class, 'assign_customer_id');
    // }

    public function productPrice()
    {
        return $this->belongsTo(ProductPrice::class, 'product_price_id');
    }

    public function cashTransaction(){
        return $this->belongsTo(CashTransaction::class, 'cash_transcation_id');
    }

    public function creditTransaction(){
        return $this->belongsTo(CreditTransaction::class, 'credit_transcation_id');
    }
}
