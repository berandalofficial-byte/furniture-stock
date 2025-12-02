<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Furniture Stock')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #4f46e5, #ec4899);
            --card-radius: 18px;
        }

        * {
            font-family: 'Poppins', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        body {
            min-height: 100vh;
            background: radial-gradient(circle at top, #e0f2fe 0, #f9fafb 40%, #e5e7eb 100%);
        }

        .navbar {
            background-image: var(--primary-gradient);
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.3);
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: .04em;
        }

        .card-premium {
            border: none;
            border-radius: var(--card-radius);
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.12);
            overflow: hidden;
            backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, 0.9);
            transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
        }

        .card-premium:hover {
            transform: translateY(-4px);
            box-shadow: 0 22px 60px rgba(15, 23, 42, 0.18);
            background: rgba(255, 255, 255, 0.98);
        }

        .badge-low-stock {
            background: #fee2e2;
            color: #b91c1c;
            font-weight: 600;
            border-radius: 999px;
            font-size: 0.7rem;
            padding: 0.15rem 0.6rem;
        }

        .btn-primary {
            background-image: var(--primary-gradient);
            border: none;
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.4);
        }

        .btn-primary:hover {
            filter: brightness(1.08);
            box-shadow: 0 14px 35px rgba(79, 70, 229, 0.55);
        }

        .btn-outline-primary {
            border-radius: 999px;
        }

        .table > :not(caption) > * > * {
            padding-top: 0.9rem;
            padding-bottom: 0.9rem;
        }

        .product-thumb {
            width: 70px;
            height: 70px;
            border-radius: 14px;
            object-fit: cover;
            box-shadow: 0 5px 15px rgba(15, 23, 42, 0.25);
        }

        .product-thumb-sm {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            object-fit: cover;
        }

        .page-header-title {
            font-weight: 700;
        }

        .page-header-subtitle {
            font-size: 0.9rem;
        }

        .pill {
            border-radius: 999px;
            padding: 0.15rem 0.75rem;
            font-size: 0.75rem;
        }

        .fade-in {
            animation: fadeIn .4s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(4px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark mb-4">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('products.index') }}">
            <span class="me-2">🛋️</span> FurniStock
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a href="{{ route('products.index') }}" class="nav-link">Produk</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('stock-transactions.index') }}" class="nav-link">Transaksi Stok</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mb-5 fade-in">
    @if(session('success'))
        <div class="alert alert-success shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
