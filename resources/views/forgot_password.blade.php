<!DOCTYPE html>
<html lang="id">
<head>
    <title>Lupa Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center py-4 bg-body-tertiary" style="height: 100vh;">

<main class="form-signin w-100 m-auto" style="max-width: 330px; padding: 15px;">

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf <h1 class="h3 mb-3 fw-normal">Reset Password</h1>
        <p class="text-muted">Masukkan email Anda untuk menerima Email Reset.</p>

        <div class="form-floating mb-3">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="floatingInput" placeholder="name@example.com" required>
            <label for="floatingInput">Email address</label>

            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button class="btn btn-primary w-100 py-2" type="submit">Kirim OTP</button>
        <p class="mt-3 text-center"><a href="/login">Kembali ke Login</a></p>
    </form>
</main>

</body>
</html>
