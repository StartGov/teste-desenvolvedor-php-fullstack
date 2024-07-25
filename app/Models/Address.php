<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'street',
        'city',
        'number',
        'state',
        'zip_code',
        'country',
        'neighborhood',
    ];

    /**
     * Get the providers associated with the address.
     */
    public function providers()
    {
        return $this->hasMany(Provider::class);
    }
}
