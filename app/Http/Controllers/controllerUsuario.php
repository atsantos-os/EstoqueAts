<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\modelUsuario;
use Illuminate\Support\Facades\Session;

class ControllerUsuario extends Controller
{
  public function showLoginForm()
{
    // Se já estiver logado, redireciona para dashboard
    if (session()->has('user_id')) {
        return redirect()->route('dashboard');
    }

    // Senão, mostra a página de login
    return view('login');
}


    public function login(Request $request)
    {
        $request->validate([
            'cpfUsuario' => 'required',
            'senha' => 'required',
        ]);

        $usuario = ModelUsuario::where('cpf', $request->cpfUsuario)->first();
        if ($usuario && \Illuminate\Support\Facades\Hash::check($request->senha, $usuario->senha)) {
            Session::put('user_id', $usuario->id);
            return redirect()->route('dashboard');
        }
        return back()->withErrors(['msg' => 'CPF ou senha incorretos']);
    }

    public function logout()
    {
        Session::forget('user_id');
        return redirect()->route('login');
    }
}
