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
        // 1. AÑADIR VALIDACIONES PARA APELLIDO Y TELÉFONO
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'], // <--- NUEVO
            'phone' => ['required', 'string', 'max:20'],      // <--- NUEVO
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 2. AÑADIR LOS CAMPOS A LA CREACIÓN DEL USUARIO
        $user = User::create([
            'name' => $request->name,
            'surname' => $request->last_name, // <--- NUEVO
            'phone' => $request->phone,         // <--- NUEVO
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Lógica JSON para API (App Móvil o SPA)
        if ($request->wantsJson()) {
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'token' => $token,
                'user' => $user,
            ]);
        }

        return redirect(route('dashboard', absolute: false));
    }
}