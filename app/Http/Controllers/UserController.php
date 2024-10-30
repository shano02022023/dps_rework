<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index() {
        
        $users = User::All();; 
        return Inertia::render('User/Index', [
            'User' => $users, 
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);
    
        // Create the user
       User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    
    
        return Redirect::route('user.index')->with('message', 'User registered successfully.');
    }

    public function destroy(User $user) {
        $user->delete();
        return Redirect::back()->with('message', 'User Deleted Successfully');
    }

    public function edit(User $user) {
        
        return Inertia::render('User/Edit', [
            'user' => $user,
        ]);
        
    }

    public function update(Request $request, User $user)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'password' => 'required|string|min:8', // Password is optional
    ]);

    $user->name = $validated['name'];
    $user->email = $validated['email'];

    if ($request->filled('password')) {
        $user->password = Hash::make($validated['password']);
    }

    $user->save();

    return redirect()->route('user.index')->with('message', 'User updated successfully.');
}
}
