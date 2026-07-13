<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImagemVeiculo extends Model
{
    protected $table = 'imagens_veiculo';

    protected $fillable = [
        'veiculo_id',
        'url',
        'public_id',
        'principal'
    ];

    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class);
    }
}
