<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku - Perpustakaan</title>
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
        
        .card {
            border: 1px solid var(--pink-100);
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            background: var(--white);
        }
        
        .card:hover {
            transform: translateY(-5px);
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
        
        .hover-lift {
            transition: all 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-5px);
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
                <a class="nav-link active" href="/books">📖 Buku</a>
                <a class="nav-link" href="/transactions">🔄 Transaksi</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="text-center mb-4">📖 Koleksi <span class="text-pink-gradient">Buku Perpustakaan</span></h1>
        
        <div class="row">
            @foreach($books as $book)
            <div class="col-md-4 mb-4">
                <div class="card h-100 hover-lift">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">{{ $book->title }}</h5>
                        <h6 class="card-subtitle mb-2 text-gray-custom">✍️ Oleh: {{ $book->author }}</h6>
                        <p class="card-text">
                            <strong>🏢 Penerbit:</strong> {{ $book->publisher }}<br>
                            <strong>📅 Tahun:</strong> {{ $book->published_year }}<br>
                            <strong>🔖 ISBN:</strong> {{ $book->isbn }}<br>
                            <strong>📦 Stok:</strong> 
                            @if($book->stock > 0)
                                <span class="badge bg-success">{{ $book->stock }} tersedia</span>
                            @else
                                <span class="badge bg-danger">Stok habis</span>
                            @endif
                        </p>
                        <span class="badge badge-custom">{{ $book->category->name }}</span>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a href="/books/{{ $book->id }}" class="btn btn-custom btn-sm w-100">🔍 Lihat Detail</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <a href="/dashboard" class="btn btn-custom mt-3">← Kembali ke Dashboard</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>