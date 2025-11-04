<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Transaksi - Perpustakaan</title>
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
        
        .soft-pink-bg { background-color: var(--soft-pink) !important; }
        
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
        
        .table-hover tbody tr:hover {
            background-color: var(--pink-100);
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
        
        .card {
            border: 1px solid var(--pink-100);
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            background: var(--white);
        }
        
        .text-gray-custom {
            color: var(--gray-600) !important;
        }
        
        h1, h2, h3, h4, h5, h6 {
            color: var(--gray-800);
            font-weight: 600;
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
                <a class="nav-link" href="/books">📖 Buku</a>
                <a class="nav-link active" href="/transactions">🔄 Transaksi</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="text-center mb-4">🔄 Riwayat <span class="text-pink-gradient">Transaksi Peminjaman</span></h1>
        
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead style="background: linear-gradient(135deg, var(--pink-200), var(--rose-200)); color: var(--gray-800);">
                            <tr>
                                <th>#</th>
                                <th>👤 Peminjam</th>
                                <th>📚 Buku</th>
                                <th>📅 Pinjam</th>
                                <th>📅 Kembali</th>
                                <th>📊 Status</th>
                                <th>💰 Denda</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                            <tr>
                                <td class="fw-bold">{{ $loop->iteration }}</td>
                                <td>
                                    <strong>{{ $transaction->user->name }}</strong><br>
                                    <small class="text-gray-custom">{{ $transaction->user->email }}</small>
                                </td>
                                <td>
                                    <strong>{{ $transaction->book->title }}</strong><br>
                                    <small class="text-gray-custom">✍️ {{ $transaction->book->author }}</small>
                                </td>
                                <td>{{ $transaction->borrow_date->format('d M Y') }}</td>
                                <td>{{ $transaction->return_date->format('d M Y') }}</td>
                                <td>
                                    @if($transaction->status == 'borrowed')
                                        <span class="badge bg-warning text-dark">📥 Dipinjam</span>
                                    @elseif($transaction->status == 'returned')
                                        <span class="badge bg-success">📤 Dikembalikan</span>
                                    @else
                                        <span class="badge bg-danger">⏰ Terlambat</span>
                                    @endif
                                </td>
                                <td>
                                    @if($transaction->fine > 0)
                                        <span class="text-danger fw-bold">Rp {{ number_format($transaction->fine, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-gray-custom">-</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <a href="/dashboard" class="btn btn-custom mt-3">← Kembali ke Dashboard</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>