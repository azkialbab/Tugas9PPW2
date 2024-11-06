<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pencarian Buku</title>
   
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
<div class="container my-4">
    <h1 class="text-center">Hasil Pencarian Buku</h1>


    @if(Session::has('pesan'))
        <div class="alert alert-success">{{ Session::get('pesan') }}</div>
    @endif

    @if(count($data_buku) > 0)
        <div class="alert alert-success">
            Ditemukan <strong>{{ count($data_buku) }}</strong> data dengan kata: <strong>{{ $cari }}</strong>
        </div>

        <a href="{{ route('buku.index') }}" class="btn btn-secondary mb-3">Kembali</a>

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

        <div class="pagination justify-content-center mb-3">{{ $data_buku->links() }}</div>
        <div class="stats">
            <div><strong>Jumlah Buku:</strong> {{ $jumlah_buku }}</div>
            <div><strong>Total Harga Buku:</strong> Rp. {{ number_format($total_harga, 2, ',', '.') }}</div>
        </div>
    @else
        <div class="alert alert-danger">Tidak ada data ditemukan dengan kata: <strong>{{ $cari }}</strong></div>
        <a href="{{ route('buku.index') }}" class="btn btn-secondary mb-3">Kembali</a>
    @endif
</div>

</body>
</html>
