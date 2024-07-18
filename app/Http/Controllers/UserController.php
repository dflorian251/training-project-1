<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;



class UserController extends Controller
{
    public function getPage()
    {
        return Inertia::render('Users', [
            'name' => Auth::user()->name,
            'admin' => Auth::user()->admin,
        ]);
    }

    public function index()
    {
        if (! Gate::allows('is-admin')) {
            $users = User::orderBy('name', 'asc')->where('admin', 0)->get(['name', 'email', 'admin']);
        } else {
            $users = User::orderBy('name', 'asc')->get(['id', 'name', 'email', 'admin']);
        }

        return $users;
    }

    public function getUser($id)
    {
        $user = User::findOrFail($id);
        return $user;
    }

    public function getCreateUserPage() {
        return Inertia::render('CreateUser');
    }

    public function getEditUserPage(string $id)
    {
        return Inertia::render('EditUser', [
            'id' => $id,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'role' => 'required',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($request->role === 'admin') {
            $role = 1;
        } else {
            $role = 0;
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'admin' => $role,
        ]);

        return redirect()->route('users');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Log the request data
            Log::info('Update request data:', $request->all());

            // Find the user by ID
            $user = User::findOrFail($id);

            // Log the user data before update
            Log::info('User before update:', $user->toArray());

            // Update fields if they are provided
            if ($request->filled('name')) {
                $user->name = $request->name;
            }
            if ($request->filled('email')) {
                $user->email = $request->email;
            }
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            if ($request->filled('role')) {
                $user->admin = $request->role === 'admin' ? 1 : 0;
            }

            // Save the user
            $user->save();

            // Log the user data after update
            Log::info('User after update:', $user->toArray());

            return redirect()->route('edit-user')->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Error updating user:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->route('edit-user')->with('error', 'Failed to update user.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users');
    }
}
