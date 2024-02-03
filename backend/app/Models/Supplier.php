<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'cpf_cnpj',
        'nome_fantasia',
        'razao_social',
        'contato',
        'endereco',
        'numero',
    ];
}
