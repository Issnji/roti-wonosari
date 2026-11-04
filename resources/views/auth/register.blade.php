<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar - Roti Wonosari</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Roti Wonosari CSS -->
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card card-roti-wonosari border-0">
                    <div class="card-body p-4 p-md-5">
                        
                        <!-- Header Logo & Title -->
                        <div class="text-center mb-4">
                            <h3 class="brand-title mb-1">Roti Wonosari</h3>
                            <p class="brand-subtitle">Buat akun baru untuk mulai memesan</p>
                        </div>

                        <!-- Validation Errors -->
                        @if ($errors->any())
                            <div class="alert alert-roti mb-4">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Form Registrasi -->
                        <form method="POST" action="{{ url('/register') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" id="name" name="name"
                                    class="form-control"
                                    placeholder="Masukkan nama lengkap"
                                    value="{{ old('name') }}" required autofocus>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email"
                                    class="form-control"
                                    placeholder="nama@email.com"
                                    value="{{ old('email') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" name="password" 
                                    class="form-control"
                                    placeholder="Minimal 8 karakter" required>
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="form-control"
                                    placeholder="Ulangi password Anda" required>
                            </div>

                            <button type="submit" class="btn btn-roti-primary w-100">
                                Daftar Sekarang
                            </button>
                        </form>

                        <!-- Footer Link -->
                        <p class="mt-4 mb-0 text-center text-muted small">
                            Sudah punya akun?
                            <a href="{{ url('/login') }}" class="link-roti">Masuk di sini</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>