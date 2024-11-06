<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Menampilkan semua pengguna
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create'); // Halaman untuk menambahkan user baru
    }

    public function store(Request $request)
    {
        // Validasi dan simpan pengguna baru
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'level' => 'required|in:user,admin'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'level' => $request->level,
        ]);

        return redirect()->route('users.index'); // Kembali ke daftar pengguna
    }

   
}  
