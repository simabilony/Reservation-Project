<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\User;
use App\Models\UserInvitation;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    public function create(Request $request)
    {
        $email = null;

        if ($request->has('invitation_token')) {
            $token = $request->input('invitation_token');

            session()->put('invitation_token', $token);

            $invitation = UserInvitation::where('token', $token)
                ->whereNull('registered_at')
                ->firstOrFail();

            $email = $invitation->email;
        }

        return view('auth.register', compact('email'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($request->session()->get('invitation_token')) {
            $invitation = UserInvitation::where('token', $request->session()->get('invitation_token'))
                ->where('email', $request->email)
                ->whereNull('registered_at')
                ->firstOr(fn() => throw ValidationException::withMessages(['invitation' => 'Invitation link does not match the email']));

            $role = $invitation->role_id;
            $company = $invitation->company_id;

            $invitation->update(['registered_at' => now()]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
//            'role_id' => Role::CUSTOMER->value,
            'role_id' => $role ?? Role::CUSTOMER->value,
            'company_id' => $company ?? null,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
