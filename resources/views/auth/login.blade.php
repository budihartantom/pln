<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SPK TOPSIS Jaringan PLN</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #00549b 0%, #00a4e4 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 1.5rem;
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175);
            width: 100%;
            max-width: 450px;
            padding: 2.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-header img {
            width: 80px;
            margin-bottom: 1rem;
        }
        .login-header h4 {
            font-weight: 700;
            color: #004d8c;
            margin-bottom: 0.5rem;
        }
        .login-header p {
            color: #6c757d;
            font-size: 0.9rem;
        }
        .form-control {
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            border: 1px solid #dee2e6;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(0, 84, 155, 0.15);
            border-color: #00549b;
        }
        .btn-pln {
            background-color: #00549b;
            color: white;
            border-radius: 0.75rem;
            padding: 0.75rem;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
        }
        .btn-pln:hover {
            background-color: #003d70;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0, 84, 155, 0.2);
        }
        .input-group-text {
            border-radius: 0 0.75rem 0.75rem 0;
            background-color: transparent;
            cursor: pointer;
            border-left: none;
        }
        .password-field {
            border-right: none;
            border-radius: 0.75rem 0 0 0.75rem;
        }
        .pln-logo-text {
            color: #ffcc00;
            font-weight: 800;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="login-header">
        <h4 class="mb-1">SPK <span class="pln-logo-text">TOPSIS</span></h4>
        <p>Pemeliharaan Jaringan Distribusi Listrik</p>
        <div class="mt-2 small text-muted">UP3 Tanjung Karang</div>
    </div>

    @if (session('status'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label small fw-bold text-muted">Email</label>
            <div class="input-group">
                <span class="input-group-text bg-light"><i class="fas fa-envelope text-muted"></i></span>
                <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="name@pln.id">
            </div>
            @error('email')
                <div class="invalid-feedback d-block mt-1 small">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label small fw-bold text-muted">Password</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                <input id="password" type="password" name="password" class="form-control password-field @error('password') is-invalid @enderror" required autocomplete="current-password" placeholder="••••••••">
                <span class="input-group-text bg-light border-start-0" id="togglePassword">
                    <i class="fas fa-eye text-muted"></i>
                </span>
            </div>
            @error('password')
                <div class="invalid-feedback d-block mt-1 small">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <div class="form-check">
                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                <label for="remember_me" class="form-check-label small text-muted">Ingat Sesi</label>
            </div>
            @if (Route::has('password.request'))
                <a class="small text-decoration-none" href="{{ route('password.request') }}">
                    Lupa Password?
                </a>
            @endif
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-pln">
                Buka Dashboard <i class="fas fa-arrow-right ms-2"></i>
            </button>
        </div>
    </form>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#togglePassword').on('click', function() {
            const passwordInput = $('#password');
            const icon = $(this).find('i');
            
            if (passwordInput.attr('type') === 'password') {
                passwordInput.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                passwordInput.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
    });
</script>

</body>
</html>
