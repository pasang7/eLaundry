<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesEntry extends Model
{
    use HasFactory;

    protected $fillable=[
        'is_complete',
        'bank_name',
        'bank_code',
        'new_delivery_date'

    ];
}
