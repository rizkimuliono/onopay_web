<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'OnoPay Admin')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-dark: #003d7a;
            --primary-blue: #0066cc;
            --light-blue: #e6f2ff;
            --white: #ffffff;
        }

        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-blue) 100%);
            min-height: 100vh;
            position: fixed;
            width: 250px;
            left: 0;
            top: 0;
            padding: 20px 0;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar .brand {
            text-align: center;
            margin-bottom: 30px;
            padding: 0 15px;
        }

        .sidebar .brand h5 {
            color: var(--white);
            font-weight: 700;
            margin-bottom: 5px;
        }

        .sidebar .brand small {
            color: var(--light-blue);
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: var(--white);
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 3px solid var(--white);
        }

        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
        }

        .main-content {
            margin-left: 250px;
            padding: 25px 30px;
            width: calc(100% - 250px);
            min-height: 100vh;
        }

        .navbar-admin {
            background-color: var(--white);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border-bottom: 1px solid #e0e0e0;
        }

        .navbar-admin .user-menu {
            color: var(--primary-dark);
        }

        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            border-radius: 8px;
            margin-bottom: 25px;
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-blue) 100%);
            color: var(--white);
            border: none;
            padding: 18px 25px;
            border-radius: 8px 8px 0 0;
            font-weight: 600;
            font-size: 1rem;
        }

        .card-body {
            padding: 25px;
        }

        .stat-card {
            background: var(--white);
            border-left: 4px solid var(--primary-blue);
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 0;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .stat-card h6 {
            color: #666;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-card .value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 8px;
        }

        .stat-card small {
            display: block;
            margin-top: 8px;
        }

        .btn-primary {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .badge-success {
            background-color: #28a745 !important;
        }

        .badge-warning {
            background-color: #ffc107 !important;
            color: #000 !important;
        }

        .badge-danger {
            background-color: #dc3545 !important;
        }

        .badge-secondary {
            background-color: #6c757d !important;
        }

        table thead th {
            background-color: var(--light-blue);
            color: var(--primary-dark);
            font-weight: 600;
            border: none;
        }

        table tbody tr:hover {
            background-color: var(--light-blue);
        }

        .form-control, .form-select {
            border-color: #ddd;
            border-radius: 6px;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.2rem rgba(0, 102, 204, 0.25);
        }

        .content h1 {
            color: var(--primary-dark);
            font-weight: 600;
            margin-bottom: 25px;
            font-size: 2rem;
        }

        .content {
            width: 100%;
        }

        .row {
            margin-right: 0;
            margin-left: 0;
        }

        [class*="col-"] {
            padding-right: 12px;
            padding-left: 12px;
        }

        .row {
            margin-bottom: 0;
        }

        .row > [class*="col-"] {
            margin-bottom: 24px;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                min-height: auto;
                position: relative;
                margin-bottom: 20px;
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="brand">
                <h5><i class="bi bi-wallet2"></i> OnoPay</h5>
                <small>Admin Panel</small>
            </div>
            <nav class="nav flex-column">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a class="nav-link {{ request()->routeIs('user.*') ? 'active' : '' }}" href="{{ route('user.index') }}">
                    <i class="bi bi-people"></i> Data User
                </a>
                <a class="nav-link {{ request()->routeIs('transaction.*') ? 'active' : '' }}" href="{{ route('transaction.index') }}">
                    <i class="bi bi-arrow-left-right"></i> Transaksi
                </a>
                <a class="nav-link {{ request()->routeIs('api-docs') ? 'active' : '' }}" href="{{ route('api-docs') }}" target="_blank">
                    <i class="bi bi-book"></i> API Documentation
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content flex-grow-1">
            <!-- Navbar -->
            <nav class="navbar navbar-admin mb-4">
                <div class="container-fluid">
                    <div class="ms-auto d-flex align-items-center gap-3">
                        <span class="user-menu">
                            <i class="bi bi-person-circle"></i> {{ session('admin_name', 'Admin') }}
                        </span>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </navbar>

            <!-- Alerts -->
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i> {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle"></i> Terdapat kesalahan:
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Content -->
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
