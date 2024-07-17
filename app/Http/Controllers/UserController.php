<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function getPage()
    {
        return Inertia::render('Users');
    }

    public function index()
    {
        $users = User::orderBy('name', 'asc')->get(['name', 'email', 'admin']);

        return $users;
    }
}
