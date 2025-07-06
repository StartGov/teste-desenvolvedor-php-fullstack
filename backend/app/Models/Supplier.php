<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Supplier extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'phone',
        'address',
        'house_number',
        'neighborhood',
        'city',
        'uf',
        'document_type',
        'document_number',
    ];
}
