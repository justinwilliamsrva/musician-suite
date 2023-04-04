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
        $name = $request->input('name');

        $request->validate([
            'email' => Rule::exists('emails')->where('email', $email),
        ],
        [
            'email.exists' => 'This email could not be found in CRRVA\'s database. Please try registering with a different email address or contact <a class="underline text-blue-500"href="'.$this->getEmailString($email, $name).'">info@classicalconnectionrva.com</a> to add this email address to the database.',
        ]);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
                // Rule::unique('users')->where(function ($query) {
                //     $query->whereNotNull('email_verified_at');
                // }),
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone_number' => [
                'nullable',
                'regex:/^\(?([0-9]{3})\)?[ -]?([0-9]{3})[ -]?([0-9]{4})$/',
                'unique:users',
                // Rule::unique('users')->where(function ($query) {
                //     $query->whereNotNull('email_verified_at');
                // }),
            ],
            'instruments' => ['required', 'array', 'min:1', 'max:10'],
            'can_book' => ['required', 'boolean'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'instruments' => json_encode($request->instruments),
            'admin' => 0,
            'can_book' => $request->can_book,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    public function getEmailString($email, $name) {

        $subject = '?subject=Add my email to CRRVA\'s Database';

        $lines[0] = 'Please answer the following three questions to confirm your membership with CRRVA and allow us to add your email to the database.';
        $lines[1] = '';
        $lines[2] = '1. Please provide your name: '.$name;
        $lines[3] = '2. Please provide the email you would like at add: '.$email;
        $lines[4] = '3. When was the last time you performed for CRRVA? EX: Incarnations in Spring of 2022.';

        $body = '&body='.implode('%0D%0A', $lines);

        return 'mailto:'.$email.$subject.$body;
    }
}
