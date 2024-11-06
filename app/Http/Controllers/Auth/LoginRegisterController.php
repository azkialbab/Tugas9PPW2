<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Buku;

class LoginRegisterController extends Controller
{
    public function __construct()
{
    $this->middleware('auth')->only('dashboard');
}
    public function dashboard()
    {
    
        if (Auth::check()) {
            $batas = 5;
            $data_buku = Buku::orderBy('id', 'desc')->paginate($batas);
            $jumlah_buku = Buku::count();
            $total_harga = Buku::sum('harga');
            $no = $batas * ($data_buku->currentPage() - 1);
            return view('auth.dashboard', compact('data_buku', 'no', 'jumlah_buku', 'total_harga'));
        }
        
        
        return redirect()->route('login')
            ->withErrors([
                'email' => 'Please login to access the dashboard.',
            ])->onlyInput('email');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|string|min:8|confirmed'  
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();  
        return redirect()->route('dashboard')
            ->withSuccess('You have successfully registered & logged in!');
    }


    public function login()
    {
     
        return view('auth.login');
    }

    public function register()
    {
        
        return view('auth.register');
    }

    public function authenticate(Request $request)
    {
        
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

       
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')->withSuccess('You have successfully logged in!');
        }

        
        return back()->withErrors([
            'email' => 'Your provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
       
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->withSuccess('You have logged out successfully!');
    }
}