<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class UserController extends Controller
{
    public function getPage()
    {
        return Inertia::render('Users', [
            'admin' => Auth::user()->admin,
        ]);
    }

    public function index()
    {

        if (! Gate::allows('is-admin')) {
            $users = User::orderBy('name', 'asc')->where('admin', 0)->get(['name', 'email', 'admin']);
        } else {
            $users = User::orderBy('name', 'asc')->get(['name', 'email', 'admin']);
        }

        return $users;
    }
}
