<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Perpustakaan</title>
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
        
        .bg-pink-gradient {
            background: linear-gradient(135deg, var(--pink-200), var(--rose-200)) !important;
        }
        
        .text-pink-gradient {
            background: linear-gradient(135deg, var(--pink-500), var(--pink-600));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .stat-card {
            transition: transform 0.3s, box-shadow 0.3s;
            border: none;
            border-radius: 12px;
            color: var(--gray-800);
            background: var(--white);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--pink-100);
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px rgba(0, 0, 0, 0.1);
        }
        
        .navbar {
            background: var(--white) !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            border-bottom: 1px solid var(--pink-100);
        }
        
        .btn-custom {
            background: linear-gradient(135deg, var(--pink-500), var(--pink-600));
            border: none;
            color: var(--white);
            border-radius: 8px;
            padding: 10px 24px;
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
            padding: 8px 22px;
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
        
        .card-header {
            border-radius: 12px 12px 0 0 !important;
            border: none;
            font-weight: 600;
            color: var(--gray-800);
            background: var(--pink-100) !important;
        }
        
        body {
            background-color: var(--soft-pink);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--gray-800);
        }
        
        .badge-custom {
            background-color: var(--pink-100);
            color: var(--pink-600);
            font-weight: 500;
            border-radius: 6px;
            padding: 6px 12px;
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
        
        .navbar-brand {
            color: var(--gray-800) !important;
            font-weight: 600;
            font-size: 1.4rem;
        }
        
        .table-hover tbody tr:hover {
            background-color: var(--pink-100);
        }
        
        h1, h2, h3, h4, h5, h6 {
            color: var(--gray-800);
            font-weight: 600;
        }
        
        .text-gray-custom {
            color: var(--gray-600) !important;
        }
        
        footer {
            background: var(--white) !important;
            color: var(--gray-800) !important;
            border-top: 1px solid var(--pink-100);
        }
        
        .hover-lift {
            transition: all 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body class="soft-pink-bg">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="/">
                📚 Perpustakaan Digital
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link active" href="/dashboard">🏠 Dashboard</a>
                <a class="nav-link" href="/books">📖 Buku</a>
                <a class="nav-link" href="/transactions">🔄 Transaksi</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="text-center mb-4">Dashboard <span class="text-pink-gradient">Perpustakaan Digital</span></h1>
        
        <!-- Statistics Cards -->
        <div class="row mb-5">
            <div class="col-md-2 mb-3">
                <div class="card stat-card hover-lift">
                    <div class="card-body text-center py-4">
                        <h5>📖 Total Buku</h5>
                        <h1 class="fw-bold">{{ $stats['total_books'] }}</h1>
                        <small class="text-gray-custom">Judul buku tersedia</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2 mb-3">
                <div class="card stat-card hover-lift">
                    <div class="card-body text-center py-4">
                        <h5>👥 Pengguna</h5>
                        <h1 class="fw-bold">{{ $stats['total_users'] }}</h1>
                        <small class="text-gray-custom">User terdaftar</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2 mb-3">
                <div class="card stat-card hover-lift">
                    <div class="card-body text-center py-4">
                        <h5>📑 Kategori</h5>
                        <h1 class="fw-bold">{{ $stats['total_categories'] }}</h1>
                        <small class="text-gray-custom">Jenis kategori</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2 mb-3">
                <div class="card stat-card hover-lift">
                    <div class="card-body text-center py-4">
                        <h5>🔄 Transaksi</h5>
                        <h1 class="fw-bold">{{ $stats['total_transactions'] }}</h1>
                        <small class="text-gray-custom">Total peminjaman</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2 mb-3">
                <div class="card stat-card hover-lift">
                    <div class="card-body text-center py-4">
                        <h5>📥 Dipinjam</h5>
                        <h1 class="fw-bold">{{ $stats['borrowed_books'] }}</h1>
                        <small class="text-gray-custom">Sedang dipinjam</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2 mb-3">
                <div class="card stat-card hover-lift">
                    <div class="card-body text-center py-4">
                        <h5>📤 Dikembalikan</h5>
                        <h1 class="fw-bold">{{ $stats['returned_books'] }}</h1>
                        <small class="text-gray-custom">Sudah dikembali</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Recent Books -->
            <div class="col-md-6 mb-4">
                <div class="card hover-lift">
                    <div class="card-header">
                        <h5 class="mb-0">📚 Buku Terbaru</h5>
                    </div>
                    <div class="card-body">
                        @foreach($recent_books as $book)
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-bold">{{ $book->title }}</h6>
                                <small class="text-gray-custom">Oleh: {{ $book->author }}</small>
                                <br>
                                <span class="badge badge-custom mt-1">{{ $book->category->name }}</span>
                            </div>
                            <div class="text-end">
                                <small class="text-gray-custom d-block">Stok: {{ $book->stock }}</small>
                            </div>
                        </div>
                        @endforeach
                        <a href="/books" class="btn btn-custom w-100 mt-3">Lihat Semua Buku</a>
                    </div>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="col-md-6 mb-4">
                <div class="card hover-lift">
                    <div class="card-header">
                        <h5 class="mb-0">🔄 Transaksi Terbaru</h5>
                    </div>
                    <div class="card-body">
                        @foreach($recent_transactions as $transaction)
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-bold">{{ $transaction->book->title }}</h6>
                                <small class="text-gray-custom">Oleh: {{ $transaction->user->name }}</small>
                                <br>
                                <small class="text-gray-custom">
                                    {{ $transaction->borrow_date->format('d M Y') }} - 
                                    {{ $transaction->return_date->format('d M Y') }}
                                </small>
                            </div>
                            <div class="text-end">
                                <span class="badge 
                                    @if($transaction->status == 'borrowed') bg-warning text-dark
                                    @elseif($transaction->status == 'returned') bg-success
                                    @else bg-danger @endif">
                                    {{ $transaction->status }}
                                </span>
                                <br>
                                @if($transaction->fine > 0)
                                <small class="text-danger fw-bold">Rp {{ number_format($transaction->fine, 0, ',', '.') }}</small>
                                @endif
                            </div>
                        </div>
                        @endforeach
                        <a href="/transactions" class="btn btn-custom w-100 mt-3">Lihat Semua Transaksi</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card hover-lift">
                    <div class="card-header">
                        <h5 class="mb-0">⚡ Akses Cepat</h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <a href="/books" class="btn btn-custom btn-lg w-100 py-3">
                                    📚 Kelola Buku
                                </a>
                            </div>
                            <div class="col-md-4 mb-3">
                                <a href="/transactions" class="btn btn-custom btn-lg w-100 py-3">
                                    🔄 Kelola Transaksi
                                </a>
                            </div>
                            <div class="col-md-4 mb-3">
                                <a href="/dashboard" class="btn btn-outline-custom btn-lg w-100 py-3">
                                    📊 Lihat Statistik
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center py-4 mt-5">
        <div class="container">
            <p class="mb-0 fw-bold">📚 Sistem Manajemen Perpustakaan Digital &copy; 2024</p>
            <small class="text-gray-custom">Dibuat dengan ❤️ untuk dunia literasi yang lebih baik</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>