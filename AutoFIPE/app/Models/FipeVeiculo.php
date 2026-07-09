<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FipeVeiculo extends Model
{
    protected $fillable = [
        'codigo_fipe',
        'tipo',
        'marca',
        'modelo',
        'ano_modelo',
        'combustivel',
        'referencia',
    ];

    public function veiculos()
    {
        return $this->hasMany(Veiculo::class);
    }
}
