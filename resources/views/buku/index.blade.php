<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
<div class="container my-4">
    <h1 class="text-center">DAFTAR BUKU</h1>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <form action="{{ route('buku.search') }}" method="get" class="d-inline">
            <input type="text" name="kata" class="form-control" placeholder="Cari...">
        </form>
        @if(Auth::check() && Auth::user()->level === 'admin')
            <a href="{{ route('buku.create') }}" class="btn btn-primary">Tambah Buku</a>
        @endif
    </div>

    @if(Session::has('pesan'))
        <div class="alert alert-success">{{ Session::get('pesan') }}</div>
    @endif

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
                    @if(Auth::check() && Auth::user()->level === 'admin')
                        <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Yakin mau dihapus?')" type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                        <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center mb-3">
        {{ $data_buku->links() }}
    </div>

    <div class="stats">
        <div><strong>Jumlah Buku:</strong> {{ $jumlah_buku }}</div>
        <div><strong>Total Harga Buku:</strong> Rp. {{ number_format($total_harga, 2, ',', '.') }}</div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>