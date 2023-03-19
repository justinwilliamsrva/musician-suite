<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
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
    public function store(Request $request): RedirectResponse
    {
        $email = $request->input('email');

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:'.User::class,
                Rule::exists('emails')->where(function ($query) use ($email) {
                    $query->where('email', $email);
                })],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone_number' => ['required', 'regex:/^\(?([0-9]{3})\)?[ -]?([0-9]{3})[ -]?([0-9]{4})$/', 'unique:'.User::class],
            'instruments' => ['required', 'array', 'min:1', 'max:10'],
        ], [
            'email.exists' => 'This email is not in CRRVA\'s database. Please contact info@classicalrevolutionrva.com to add this email address or register under a different email address.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'instruments' => json_encode($request->instruments),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
