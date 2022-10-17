<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        $countries = Country::all();
        return Inertia::render('Auth/Register', [
            'countries' => $countries,
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();
        // $request->validate([
        //     'email' => 'required|string|email|max:255|unique:users',
        // ]);
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'birthdate' => $request->birthdate,
            'countries' => $request->countries,
            'phone' => $request->phone,
            'role' => $request->role
        ]);
        event(new Registered($user));
        Auth::login($user);
        return redirect(RouteServiceProvider::HOME);
    }

    public function editUser()
    {
        $userId = Auth::id();
        $user = User::find($userId);
        $countries = Country::all();

        return Inertia::render('Auth/UserProfile', [
            'user' => $user,
            'countries' => $countries,
        ]);
    }
    
    public function editSaveUser(StoreUserRequest $request)
    {
        $validated = $request->validated();

        $userId = Auth::id();
        $user = User::find($userId);
    
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->password = $request->input('password');
        $user->birthdate = $request->input('birthdate');
        $user->countries = $request->input('countries');
        $user->phone = $request->input('phone');
        $user->role = $request->input('role');
        $user->save();

        Auth::login($user);
        return redirect(RouteServiceProvider::HOME);
    }
}
