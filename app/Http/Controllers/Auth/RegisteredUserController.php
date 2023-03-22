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
                Rule::unique('users')->where(function ($query) {
                    $query->whereNotNull('email_verified_at');
                }),
                Rule::exists('emails')->where(function ($query) use ($email) {
                    $query->where('email', $email);
                })],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone_number' => [
                'required',
                'regex:/^\(?([0-9]{3})\)?[ -]?([0-9]{3})[ -]?([0-9]{4})$/',
                Rule::unique('users')->where(function ($query) {
                    $query->whereNotNull('email_verified_at');
                }),
            ],
            'instruments' => ['required', 'array', 'min:1', 'max:10'],
        ], [
            'email.exists' => 'This email could not be found in CRRVA\'s database. Please try registering with a different email address or contact justinwdev@gmail.com to add this email address to the database.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'instruments' => json_encode($request->instruments),
            'admin' => 0,
        ]);

        $user->sendEmailVerificationNotification();

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
