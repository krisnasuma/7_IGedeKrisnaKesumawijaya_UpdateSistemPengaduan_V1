<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sistem Layanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-brand { font-weight: bold; }
        .card { margin-bottom: 20px; }
        .status-menunggu { color: #ffc107; }
        .status-diproses { color: #0d6efd; }
        .status-selesai { color: #198754; }
        .status-ditolak { color: #dc3545; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="/">Sistem Layanan</a>
            <div class="navbar-nav ms-auto">

                @auth('masyarakat')
                    <span class="navbar-text me-3">Selamat datang, {{ Auth::guard('masyarakat')->user()->nama }}</span>
                    <div class="navbar-nav">
                        <a class="nav-link" href="{{ route('masyarakat.dashboard') }}">Dashboard</a>
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Profil</a>
                            <ul class="dropdown-menu">

                                <li><a class="dropdown-item" href="{{ route('masyarakat.profil') }}">Profil Saya</a></li>
                                
                                <li><a class="dropdown-item" href="{{ route('pengajuan.index') }}">Pengajuan Saya</a></li>

                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('masyarakat.logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endauth
 
                @auth('admin')
                    <span class="navbar-text me-3">Admin: {{ Auth::guard('admin')->user()->nama }}</span>
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link">Logout</button>
                    </form>
                @endauth
                
                @guest
                    <a class="nav-link" href="{{ route('masyarakat.login') }}">Login Masyarakat</a>
                    <a class="nav-link" href="{{ route('admin.login') }}">Login Admin</a>
                @endguest
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>