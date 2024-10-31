<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\User;
use App\Notifications\RegisteredToActivityNotification;
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
    public function create(Request $request): View
    {

        if ($request->has('activity')) {
            session()->put('activity', $request->input('activity'));
        }
        $email = 0;
        return view('auth.register', compact('email'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id' => Role::CUSTOMER->value,
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));
        Auth::login($user);
        $activity = Activity::find($request->session()->get('activity'));
        if ($request->session()->get('activity') && $activity) {
            $user->activities()->attach($request->session()->get('activity'));
            $user->notify(new RegisteredToActivityNotification($activity));
            return redirect()->route('my-activity.show')->with('success', 'You have successfully registered.');
        }
        return redirect(route('home', absolute: false));
    }
}
