<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provider extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_name',
        'description',
        'email',
        'phone',
        'document_type',
        'address_id',
        'document_number',
    ];

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
