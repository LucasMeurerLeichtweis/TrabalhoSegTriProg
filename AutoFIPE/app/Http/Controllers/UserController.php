<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::with('roles')
            ->paginate(10);

        return view('usuarios.index', compact('usuarios'));
    }

    public function updateRole(Request $request, User $usuario)
    {
        $request->validate([
            'role' => ['required', 'string', 'exists:roles,name'],
        ]);

        $usuario->syncRoles([$request->role]);

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Função do usuário atualizada com sucesso.');
    }

    public function destroy(User $usuario)
    {
        $usuario->delete();

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuário excluído com sucesso.');
    }
}
