<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
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

    public function getCreateUserPage() {
        return Inertia::render('CreateUser');
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users');
    }
}
