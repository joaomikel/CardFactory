<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
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
     * @throws \Illuminate\Validation\ValidationException
     */

    public function store(Request $request)
    {
        // 1. Validar
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 2. Crear el Usuario (Solo datos de acceso y nombre principal)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 3. Crear el Perfil asociado a ese usuario
        Profile::create([
            'user_id' => $user->id,
            'surname' => $request->last_name,
            'phone' => $request->phone,
        ]);

        event(new Registered($user));
        Auth::login($user);

        // 4. RESPUESTA JSON
        return response()->json([
            'status' => 'success',
            'user_name' => $user->name,
            'visual_token' => 'sesion_activa_' . time(), 
            'redirect_url' => route('dashboard', absolute: false)
        ]);
    }
}