<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    protected $fillable = [
        'fipe_veiculo_id',
        'placa',
        'renavam',
        'cor',
        'quilometragem',
        'cambio',
        'valor_compra',
        'valor_venda',
        'valor_fipe',
        'mes_referencia',
        'descricao',
        'ativo',
    ];

    public function imagens()
        {
            return $this->hasMany(ImagemVeiculo::class);
        }

    public function fipe()
    {
        return $this->belongsTo(FipeVeiculo::class, 'fipe_veiculo_id');
    }
}
