<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $this->removeSessionMessages();
        return view('auth.register', ['emailVerified' => false]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $task = request()->input('task');
        $this->removeSessionMessages();

        if ($task == 'register-email') {
            $email = $request->input('email');
            $request->validate([
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    'unique:users',
                    Rule::exists('emails')->where('email', $email),
                ]
            ]);

            $message = 'Congratulations! Your Email Was Registered';

            session()->flash('success', $message);

            return view('auth.register', ['emailVerified' => true, 'email' => $email]);
        } elseif ($task == 'send-to-CCRVA') {
            $validator = Validator::make($request->all(),[
                'email' => 'required|email|max:255|',
                'name' =>  'required|string|max:255',
                'recent_performance' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                $message = 'Attempted to Submit Invalid Data';

                return redirect()->route('register')->with('warning', $message);
            }

            $name = $request->input('name');
            $email = $request->input('email');
            $recent_performance = $request->input('recent_performance');

            $lines[1] = $name;
            $lines[2] = $email;
            $lines[3] = $recent_performance;
            $message_body = implode(' ', $lines);

            Mail::raw($message_body, function ($message) use ($name) {
                $message->to('info@classicalconnectionrva.com');
                $message->subject($name.' Wants to be added to CCRVA Database.');
            });

            $message = 'Your request was sent. You will be emailed when your email has been added to the database';

            session()->flash('success', $message);

            return view('auth.register', ['emailVerified' => false]);

        } elseif($task == 'store') {

            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    'unique:users',
                    Rule::exists('emails')->where('email', $request->input('email')),
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
    }

    public function getEmailString($email, $name)
    {
        $subject = '?subject=Add my email to CRRVA\'s Database';

        $lines[0] = 'Please answer the following three questions to confirm your membership with CRRVA and allow us to add your email to the database.';
        $lines[1] = '';
        $lines[2] = '1. Please provide your name: '.$name;
        $lines[3] = '2. Please provide the email you would like to use: '.$email;
        $lines[4] = '3. When was the last time you performed for CRRVA? EX: Incarnations in Spring of 2022.';

        $body = '&body='.implode('%0D%0A', $lines);

        return 'mailto:info@classicalconnectionrva.com'.$subject.$body;
    }

    public function removeSessionMessages() {
        if (session()->has('success')) {
            session()->forget('success');
        }

        if (session()->has('warning')) {
            session()->forget('warning');
        }
    }
}
