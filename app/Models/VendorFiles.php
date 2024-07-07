<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DateTimeInterface;

class VendorFiles extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'vendor_id','name','file_path','status',
    ];

    protected $casts = [
        'id'=>'string',
        'vendor_id'=>'string',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function vendor(){
        return $this->belongsTo(Vendor::class,'vendor_id');
    }

}
