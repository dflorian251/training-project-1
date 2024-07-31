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
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;



class UserController extends Controller
{
    public function getPage()
    {
        return Inertia::render('Users', [
            'name' => Auth::user()->name,
            'role' => Auth::user()->role,
        ]);
    }

    public function index()
    {
        if (! Gate::allows('is-admin')) {
            $users = User::orderBy('name', 'asc')->where('role', 'public')->get(['id', 'name', 'email', 'role']);
        } else {
            $users = User::orderBy('name', 'asc')->get(['id', 'name', 'email', 'role']);
        }

        return $users;
    }

    public function getUser($id)
    {
        $user = User::findOrFail($id);
        return $user;
    }

    public function getCreateUserPage() {
        if (! Gate::allows('is-admin')) {
            abort(403);
        }
        return Inertia::render('CreateUser');
    }

    public function getEditUserPage(string $id)
    {
        if (Gate::allows('is-admin') || strval(Auth::user()->id) === $id) {
            return Inertia::render('EditUser', [
                'id' => $id,
                'role' => Auth::user()->role,
            ]);
        } else {
            abort(403);
        }
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'role' => 'required',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Find the user by ID
            $user = User::findOrFail($id);

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
            if ($request->filled('user_role')) {
                $user->role = $request->user_role;
            }
            // Save the user
            $user->update();

            return response()->json(['success' => true, 'redirect_url' => route('users')]);
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
        if (! Gate::allows('is-admin')) {
            abort(403);
        }
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users');
    }
}
