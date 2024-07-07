<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'assign_customer_id', 'total_credit', 'status',
    ];

    protected $casts = [
        'id'=>'string',
        'total_credit'=>'string',
        'assign_customer_id'=>'string',
        'status'=>'string',
    ];

    public function activity()
    {
        return $this->hasMany(Activity::class, 'credit_transaction_id');
    }
}
