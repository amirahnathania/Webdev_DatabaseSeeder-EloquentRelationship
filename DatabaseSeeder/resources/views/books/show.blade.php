<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $book->title }} - Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --soft-pink: #fdf2f8;
            --pink-100: #fce7f3;
            --pink-200: #fbcfe8;
            --pink-500: #ec4899;
            --pink-600: #db2777;
            --rose-200: #fecdd3;
            --gray-600: #6b7280;
            --gray-800: #1f2937;
            --white: #ffffff;
        }
        
        .soft-pink-bg {
            background-color: var(--soft-pink) !important;
        }
        
        .text-pink-gradient {
            background: linear-gradient(135deg, var(--pink-500), var(--pink-600));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .btn-custom {
            background: linear-gradient(135deg, var(--pink-500), var(--pink-600));
            border: none;
            color: var(--white);
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(236, 72, 153, 0.3);
            color: var(--white);
            background: linear-gradient(135deg, var(--pink-600), var(--pink-500));
        }
        
        .btn-outline-custom {
            background: transparent;
            border: 2px solid var(--pink-500);
            color: var(--pink-500);
            border-radius: 8px;
            padding: 8px 20px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-outline-custom:hover {
            background: var(--pink-500);
            color: var(--white);
            transform: translateY(-2px);
        }
        
        .card {
            border: 1px solid var(--pink-100);
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            background: var(--white);
        }
        
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 20px rgba(0, 0, 0, 0.1);
        }
        
        .badge-custom {
            background-color: var(--pink-100);
            color: var(--pink-600);
            font-weight: 500;
            border-radius: 6px;
            padding: 6px 12px;
        }
        
        body {
            background-color: var(--soft-pink);
            min-height: 100vh;
            color: var(--gray-800);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .nav-link {
            color: var(--gray-800) !important;
            font-weight: 500;
            transition: all 0.3s;
            border-radius: 6px;
            margin: 0 4px;
            padding: 8px 16px !important;
        }
        
        .nav-link:hover, .nav-link.active {
            color: var(--pink-600) !important;
            background-color: var(--pink-100);
        }
        
        .navbar {
            background: var(--white) !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            border-bottom: 1px solid var(--pink-100);
        }
        
        .navbar-brand {
            color: var(--gray-800) !important;
            font-weight: 600;
            font-size: 1.4rem;
        }
        
        .text-gray-custom {
            color: var(--gray-600) !important;
        }
        
        h1, h2, h3, h4, h5, h6 {
            color: var(--gray-800);
            font-weight: 600;
        }
        
        .table-custom {
            border: 1px solid var(--pink-100);
            border-radius: 8px;
            overflow: hidden;
        }
        
        .table-custom th {
            background: linear-gradient(135deg, var(--pink-200), var(--rose-200));
            color: var(--gray-800);
            font-weight: 600;
            border: none;
            padding: 12px 16px;
        }
        
        .table-custom td {
            border-color: var(--pink-100);
            padding: 12px 16px;
            vertical-align: middle;
        }
        
        .table-custom tr:nth-child(even) {
            background-color: var(--soft-pink);
        }
        
        .info-card {
            background: linear-gradient(135deg, var(--pink-200), var(--rose-200));
            border: none;
            border-radius: 12px;
        }
        
        .stats-card {
            background: var(--white);
            border: 1px solid var(--pink-100);
            border-radius: 12px;
        }
    </style>
</head>
<body class="soft-pink-bg">
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="/dashboard">
                📚 Perpustakaan Digital
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="/dashboard">🏠 Dashboard</a>
                <a class="nav-link active" href="/books">📖 Buku</a>
                <a class="nav-link" href="/transactions">🔄 Transaksi</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <a href="/books" class="btn btn-outline-custom mb-3">← Kembali ke Daftar Buku</a>
        
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h1 class="card-title">{{ $book->title }}</h1>
                        <h4 class="text-gray-custom">✍️ Oleh: {{ $book->author }}</h4>
                        
                        <div class="mt-4">
                            <h5 class="text-pink-gradient">📋 Informasi Buku</h5>
                            <table class="table table-custom">
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
                                        <span class="badge badge-custom">{{ $book->category->name }}</span>
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
                            <h5 class="text-pink-gradient">📝 Deskripsi</h5>
                            <div class="p-4 info-card">
                                <p class="card-text mb-0">{{ $book->description }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card stats-card">
                            <div class="card-body text-center">
                                <h5 class="text-pink-gradient">📊 Statistik</h5>
                                <p class="mb-2">
                                    <strong>Total Dipinjam:</strong><br>
                                    <span class="h4 text-pink-gradient">{{ $book->transactions->count() }} kali</span>
                                </p>
                                <p class="mb-0">
                                    <strong>Sedang Dipinjam:</strong><br>
                                    <span class="h4 text-pink-gradient">
                                        {{ $book->transactions->where('status', 'borrowed')->count() }} buku
                                    </span>
                                </p>
                            </div>
                        </div>

                        @if($book->transactions->count() > 0)
                        <div class="card stats-card mt-3">
                            <div class="card-body">
                                <h6 class="text-pink-gradient">📥 Riwayat Peminjaman Terbaru</h6>
                                @foreach($book->transactions->take(3) as $transaction)
                                <div class="border-bottom pb-2 mb-2">
                                    <small>
                                        <strong>{{ $transaction->user->name }}</strong><br>
                                        {{ $transaction->borrow_date->format('d M Y') }} - 
                                        {{ $transaction->return_date->format('d M Y') }}<br>
                                        <span class="badge 
                                            @if($transaction->status == 'borrowed') bg-warning text-dark
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>