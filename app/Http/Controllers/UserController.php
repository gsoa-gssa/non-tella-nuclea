<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('users.index', [
            'users' => User::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => '',
            'role' => 'required',
            'configurations' => 'required|array'
        ]);
        if (!$validated['password']) {
            $validated['password'] = bcrypt(Str::random(42));
            $mustchange = true;
        } else {
            $validated['password'] = bcrypt($validated['password']);
            $mustchange = false;
        }
        $user = User::create($validated);
        if ($user->role != 'admin') {
            if (isset($validated['configurations'])) {
                $user->configurations()->attach($validated['configurations']);
            } else {
                return redirect()->route('users.create')->withErrors(['configurations' => __('The configurations field is required for users.')]);
            }
        }
        if ($mustchange) {
            $token = Password::getRepository()->create($user);
            $user->sendPasswordResetNotification($token);
        }
        $user->email_verified_at = now();
        $user->save();
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
