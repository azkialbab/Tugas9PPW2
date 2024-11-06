@extends('auth.layouts')


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

@section('content')

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="text-center">DAFTAR BUKU</h1>

       
        @if(Auth::check())
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        @endif
    </div>

    <form action="{{ route('buku.search') }}" method="get" class="d-flex justify-content-end my-3">
        @csrf
        <input type="text" name="kata" class="form-control me-2" placeholder="Cari..." style="width: 30%;">
    </form>

    @if(Session::has('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif

    <a href="{{ route('buku.create') }}" class="btn btn-primary float-end mb-3">Tambah Buku</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Harga</th>
                <th>Tanggal Terbit</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data_buku as $index => $buku)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $buku->judul }}</td>
                <td>{{ $buku->penulis }}</td>
                <td>{{ "Rp. ".number_format($buku->harga, 0, ',', '.') }}</td>
                <td>{{ \Carbon\Carbon::parse($buku->tgl_terbit)->format('d/m/Y') }}</td>
                <td>
                    <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Yakin mau dihapus?')" type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                    <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-warning btn-sm">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $data_buku->links() }}
    </div>

    <div class="stats mt-3">
        <strong>Jumlah Buku:</strong> {{ $jumlah_buku }}<br>
        <strong>Total Harga Buku:</strong> Rp. {{ number_format($total_harga, 2, ',', '.') }}
    </div>
</div>

@endsection
