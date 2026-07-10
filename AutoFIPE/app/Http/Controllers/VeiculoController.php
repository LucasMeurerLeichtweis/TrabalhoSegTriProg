<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VeiculoController extends Controller
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
        $request->validate([
            'tipo' => 'required|string',
            'marca' => 'required',
            'modelo' => 'required',
            'ano' => 'required',
        ]);

        // Futuramente:
        // Veiculo::create($request->all());

        return redirect()
            ->route('cadastro')
            ->with('success', 'Veículo cadastrado com sucesso!');
    }
}
