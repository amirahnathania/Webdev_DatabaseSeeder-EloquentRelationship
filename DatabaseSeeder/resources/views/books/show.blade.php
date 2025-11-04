<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $book->title }} - Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/dashboard">📚 Perpustakaan Digital</a>
            <div class="navbar-nav">
                <a class="nav-link" href="/dashboard">Dashboard</a>
                <a class="nav-link active" href="/books">Buku</a>
                <a class="nav-link" href="/transactions">Transaksi</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <a href="/books" class="btn btn-secondary mb-3">← Kembali ke Daftar Buku</a>
        
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h1 class="card-title">{{ $book->title }}</h1>
                        <h4 class="text-muted">Oleh: {{ $book->author }}</h4>
                        
                        <div class="mt-4">
                            <h5>📋 Informasi Buku</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Penerbit</th>
                                    <td>{{ $book->publisher }}</td>
                                </tr>
                                <tr>
                                    <th>Tahun Terbit</th>
                                    <td>{{ $book->published_year }}</td>
                                </tr>
                                <tr>
                                    <th>ISBN</th>
                                    <td>{{ $book->isbn }}</td>
                                </tr>
                                <tr>
                                    <th>Kategori</th>
                                    <td>
                                        <span class="badge bg-info">{{ $book->category->name }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Stok Tersedia</th>
                                    <td>
                                        @if($book->stock > 0)
                                            <span class="badge bg-success">{{ $book->stock }} buku tersedia</span>
                                        @else
                                            <span class="badge bg-danger">Stok habis</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>

                        @if($book->description)
                        <div class="mt-4">
                            <h5>📝 Deskripsi</h5>
                            <p class="card-text">{{ $book->description }}</p>
                        </div>
                        @endif
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h5>📊 Statistik</h5>
                                <p class="mb-1">Total Dipinjam: {{ $book->transactions->count() }} kali</p>
                                <p class="mb-0">
                                    Sedang Dipinjam: 
                                    {{ $book->transactions->where('status', 'borrowed')->count() }} buku
                                </p>
                            </div>
                        </div>

                        @if($book->transactions->count() > 0)
                        <div class="card mt-3">
                            <div class="card-body">
                                <h6>📥 Riwayat Peminjaman Terbaru</h6>
                                @foreach($book->transactions->take(3) as $transaction)
                                <div class="border-bottom pb-2 mb-2">
                                    <small>
                                        <strong>{{ $transaction->user->name }}</strong><br>
                                        {{ $transaction->borrow_date->format('d M Y') }} - 
                                        {{ $transaction->return_date->format('d M Y') }}<br>
                                        <span class="badge 
                                            @if($transaction->status == 'borrowed') bg-warning
                                            @elseif($transaction->status == 'returned') bg-success
                                            @else bg-danger @endif">
                                            {{ $transaction->status }}
                                        </span>
                                    </small>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>