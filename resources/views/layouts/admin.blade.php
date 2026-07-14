<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'SPK Pemeliharaan Jaringan - PLN UP3 Tanjung Karang' }}</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    
    @stack('styles')
</head>
<body>

    <div id="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h5 class="mb-0 text-pln-yellow font-weight-bold">PLN TOPSIS-SPK</h5>
                <small class="text-white-50">UP3 Tanjung Karang</small>
            </div>

            <ul class="list-unstyled components">
                <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                </li>
                
                @if(auth()->user()->isAdmin())
                <li class="header-menu px-4 py-2 text-uppercase small text-white-50 mt-3">Master Data</li>
                <li class="{{ request()->is('kriteria*') ? 'active' : '' }}">
                    <a href="{{ route('kriteria.index') }}"><i class="fas fa-list-check"></i> Kriteria TOPSIS</a>
                </li>
                <li class="{{ request()->is('users*') ? 'active' : '' }}">
                    <a href="{{ route('users.index') }}"><i class="fas fa-users-cog"></i> Kelola User</a>
                </li>
                @endif

                <li class="header-menu px-4 py-2 text-uppercase small text-white-50 mt-3">Operasional</li>
                <li class="{{ request()->is('gardu*') ? 'active' : '' }}">
                    <a href="{{ route('gardu.index') }}"><i class="fas fa-bolt"></i> Data Gardu</a>
                </li>
                <li class="{{ request()->is('pengukuran*') ? 'active' : '' }}">
                    <a href="{{ route('pengukuran.index') }}"><i class="fas fa-gauge-high"></i> Pengukuran</a>
                </li>

                <li class="header-menu px-4 py-2 text-uppercase small text-white-50 mt-3">Metode TOPSIS</li>
                <li class="{{ request()->is('perhitungan*') ? 'active' : '' }}">
                    <a href="{{ route('topsis.index') }}"><i class="fas fa-calculator"></i> Hitung TOPSIS</a>
                </li>
                <li class="{{ request()->is('riwayat*') ? 'active' : '' }}">
                    <a href="{{ route('topsis.history') }}"><i class="fas fa-history"></i> Riwayat</a>
                </li>

                <li class="header-menu px-4 py-2 text-uppercase small text-white-50 mt-3">Laporan</li>
                <li class="{{ request()->routeIs('topsis.ranking.index') ? 'active' : '' }}">
                    <a href="{{ route('topsis.ranking.index') }}"><i class="fas fa-ranking-star"></i> Ranking Prioritas</a>
                </li>
                <li class="{{ request()->routeIs('topsis.laporan.index') ? 'active' : '' }}">
                    <a href="{{ route('topsis.laporan.index') }}"><i class="fas fa-file-alt"></i> Laporan</a>
                </li>
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <!-- Topbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-link link-dark">
                        <i class="fas fa-bars"></i>
                    </button>

                    <div class="ms-auto d-flex align-items-center">
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                <span class="d-none d-md-inline me-2">{{ auth()->user()->name }}</span>
                                <span class="badge bg-pln-blue">{{ strtoupper(auth()->user()->role) }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user me-2"></i> Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item text-danger" type="submit">
                                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content Area -->
            <div class="main-content">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-4">
                        @yield('breadcrumbs')
                    </ol>
                </nav>

                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-4">
                    <h1 class="h3 mb-0">{{ $title ?? 'Dashboard' }}</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        @yield('actions')
                    </div>
                </div>

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
