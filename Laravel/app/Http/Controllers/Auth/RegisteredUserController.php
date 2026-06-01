<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'role' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];

        // Adicionar validações para campos de endereço se for gerente
        if ($request->role === 'manager') {
            $rules['city'] = ['required', 'string', 'max:255'];
            $rules['cep'] = ['required', 'string', 'max:9'];
            $rules['rua'] = ['required', 'string', 'max:255'];
            $rules['numero'] = ['required', 'string', 'max:10'];
            $rules['bairro'] = ['required', 'string', 'max:255'];
        }

        $request->validate($rules);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ];

        // Adicionar dados de endereço se for gerente
        if ($request->role === 'manager') {
            $userData['city'] = $request->city;
            $userData['cep'] = $request->cep;
            $userData['rua'] = $request->rua;
            $userData['numero'] = $request->numero;
            $userData['bairro'] = $request->bairro;
        }

        $user = User::create($userData);

        event(new Registered($user));

        Auth::login($user);

        //return padrão do breeze:
        //return redirect(route('dashboard', absolute: false));

        //git config --global --unset credential.helperAtualização para redirecionar para diferentes páginas:
        $user = $request->user();

        if ($user->role === 'manager') {
            return redirect()->intended('/manager/dashboard');
        }

        if ($user->role === 'user') {
            return redirect()->intended('/user/dashboard');
        }

        return redirect()->intended('/dashboard');
    }
}
