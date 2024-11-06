<?php
namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BooksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $batas = 5;
        $data_buku = Buku::orderBy('id', 'desc')->paginate($batas);
        $no = $batas * ($data_buku->currentPage() - 1);
        $jumlah_buku = $data_buku->total();
        $total_harga = Buku::sum('harga') ?? 0;

        return view('buku.index', compact('data_buku', 'jumlah_buku', 'total_harga', 'no'));
    }

    public function create()
{
    // Hanya admin yang dapat mengakses
    if (Auth::user()->level !== 'admin') {
        return redirect()->route('home')->with('error', 'Anda tidak memiliki akses untuk menambah buku.');
    }
    return view('buku.create');
}

public function store(Request $request)
{
    // Hanya admin yang dapat mengakses
    if (Auth::user()->level !== 'admin') {
        return redirect()->route('home')->with('error', 'Anda tidak memiliki akses untuk menambah buku.');
    }

    $request->validate([
        'judul' => 'required|string',
        'penulis' => 'required|string|max:30',
        'harga' => 'required|numeric',
        'tgl_terbit' => 'required|date'
    ]);

    Buku::create($request->all());

    return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan');
}

public function edit(Buku $buku)
{
  
    if (Auth::user()->level !== 'admin') {
        return redirect()->route('home')->with('error', 'Anda tidak memiliki akses untuk mengedit buku.');
    }
    return view('buku.edit', compact('buku'));
}

public function update(Request $request, Buku $buku)
{
    
    if (Auth::user()->level !== 'admin') {
        return redirect()->route('home')->with('error', 'Anda tidak memiliki akses untuk mengedit buku.');
    }

    $request->validate([
        'judul' => 'required|string',
        'penulis' => 'required|string|max:30',
        'harga' => 'required|numeric',
        'tgl_terbit' => 'required|date'
    ]);

    $buku->update($request->all());

    return redirect()->route('buku.index')->with('success', 'Buku berhasil diupdate');
}

public function destroy(Buku $buku)
{
    
    if (Auth::user()->level !== 'admin') {
        return redirect()->route('home')->with('error', 'Anda tidak memiliki akses untuk menghapus buku.');
    }

    $buku->delete();

    return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus');
}
    /**
     * Search for a specific book.
     */
    public function search(Request $request)
    {
        $batas = 5;
        $cari = $request->input('kata', ''); 
        $data_buku = Buku::where('judul', 'like', "%{$cari}%")
                         ->orWhere('penulis', 'like', "%{$cari}%")
                         ->paginate($batas);
                         
        $jumlah_buku = $data_buku->total();
        $no = $batas * ($data_buku->currentPage() - 1);
        $total_harga = Buku::sum('harga') ?? 0; 

        return view('buku.search', compact('jumlah_buku', 'data_buku', 'no', 'cari', 'total_harga'));
    }
}
