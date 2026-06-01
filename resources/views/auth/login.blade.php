<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accesso — Food &amp; Tech Gestionale</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background: #1a1f2e; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { width: 380px; border: none; border-radius: 12px; box-shadow: 0 8px 32px rgba(0,0,0,.3); }
        .login-brand { background: #2d3450; border-radius: 12px 12px 0 0; padding: 2rem; text-align: center; }
    </style>
</head>
<body>
<div class="login-card card">
    <div class="login-brand">
        <i class="bi bi-box-seam text-primary fs-1"></i>
        <h5 class="text-white mt-2 mb-0">Food &amp; Tech</h5>
        <small class="text-secondary">Gestionale Clienti</small>
    </div>
    <div class="card-body p-4">
        @if($errors->any())
            <div class="alert alert-danger py-2 small">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label small fw-semibold">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" autofocus required>
            </div>
            <div class="mb-3">
                <label class="form-label small fw-semibold">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                <label class="form-check-label small" for="remember">Ricordami</label>
            </div>
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-box-arrow-in-right me-1"></i>Accedi
            </button>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
