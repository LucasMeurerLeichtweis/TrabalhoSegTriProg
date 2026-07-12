<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cloudinary\Cloudinary;


class ImagemVeiculoController extends Controller
{
     public function create()
    {
        return view('cadastraAuto');
    }

    /**
     * Salva um veículo cadastrado.
     */
    public function store(Request $request)
    {
        $cloudinary = new Cloudinary([
        'cloud' => [
            'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
            'api_key' => env('CLOUDINARY_API_KEY'),
            'api_secret' => env('CLOUDINARY_API_SECRET'),
        ],
    ]);

        return redirect()
            ->route('cadastro')
            ->with('success', 'Veículo cadastrado com sucesso!');
    }
}
