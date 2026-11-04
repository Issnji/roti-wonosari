<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dashboard</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>
<body class="bg-light">

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                Aplikasi Saya
            </a>

            <div class="ms-auto">
                <form method="POST" action="{{ url('/logout') }}">
                    @csrf

                    <button type="submit" class="btn btn-outline-light">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    {{-- Konten Dashboard --}}
    <main class="container py-5">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h1 class="h3 mb-3">Dashboard</h1>

                <div class="alert alert-success">
                    Selamat datang, {{ auth()->user()->name }}!
                    Kamu berhasil login.
                </div>

                <h2 class="h5 mt-4">Informasi Pengguna</h2>

                <table class="table table-bordered mt-3">
                    <tbody>
                        <tr>
                            <th style="width: 150px;">Nama</th>
                            <td>{{ auth()->user()->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ auth()->user()->email }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</body>
</html>