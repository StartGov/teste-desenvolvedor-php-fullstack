<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'document_number',
        'company_name',
        'email',
        'phone',
        'zipcode',
        'address',
        'address_number',
        'address_complement',
        'neighborhood',
        'city',
        'state',
    ];
}
