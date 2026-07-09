<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    protected $fillable = [
        'fipe_veiculo_id',
        'placa',
        'renavam',
        'chassi',
        'cor',
        'quilometragem',
        'ano_fabricacao',
        'valor_compra',
        'valor_venda',
        'ativo',
        'observacoes',
    ];

    public function fipe()
    {
        return $this->belongsTo(FipeVeiculo::class, 'fipe_veiculo_id');
    }
}
