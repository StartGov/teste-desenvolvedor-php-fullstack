<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'supplier';
    protected $primaryKey = 'id';
    public $timetamps = true;

    protected $fillable = [
        'social_reason',
        'fantasy_name',
        'contact',
        'cnpj',
        'addres_id',
    ];
}
