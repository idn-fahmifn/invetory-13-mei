<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\User;


class PetugasController extends Controller
{
    public function index()
    {
        $users = User::where('isAdmin', false)->get();
        return view('petugas.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'namaPetugas' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
        ]);

        $simpan = [
            'name' => $request->input('namaPetugas'),
            'email' => $request->input('email'),
            'password' => Hash::make('Password'),
            'uuid' => Str::uuid7()
        ];

        User::create($simpan);
        return redirect()->route('petugas.index')->with('success','Petugas Berhasil Ditambahkan');

    }

    public function show($param)
    {
        $user = User::where('uuid', $param)->firstOrFail();
        return view('petugas.detail', compact('user'));
    }


}
