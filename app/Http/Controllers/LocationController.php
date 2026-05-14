<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\{Location, User};

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::all();
        $users = User::where('isAdmin', false)->get();
        return view('locations.index', compact('locations', 'users'));
    }
}
