<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory;
    use SoftDeletes;

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

    public function address(): HasOne {
        return $this->hasOne(Address::class, 'id', 'addres_id');
    }
}
