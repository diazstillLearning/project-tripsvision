<div>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <section class="login-container">
        <div class="register-overlay">
            <form method="POST" action="{{ url('/register') }}" class="register-form">
                @csrf
                <h2 class="register-title">Register</h2>

                {{-- Pesan error --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-group">
                    <label for="username">username:</label>
                    <input type="text" name="username" value="{{ old('username') }}" required class="register-input" placeholder="Username">
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="register-input" placeholder="Email">
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" required class="register-input" placeholder="Password">
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password:</label>
                    <input type="password" name="password_confirmation" required class="register-input" placeholder="Konfirmasi Password">
                </div>

                <button type="submit" class="register-button">Register</button>
            </form>
            <p>Sudah punya akun? <a href="{{ url('/login') }}">Login di sini</a></p>
        </div>
    </section>
</body>
</html>

</div>
