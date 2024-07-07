<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
class CustomerCredit extends Model
{
    use HasFactory;

    protected $fillable = [
        'assign_customer_id', 'status', 'credit_amount',
    ];

    protected $casts = [
        'id'=>'string',
        'assign_customer_id'=>'string',
        'credit_amount'=>'string',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function assignCustomer()
    {
        return $this->belongsTo(AssignCustomer::class, 'assign_customer_id');
    }
}
