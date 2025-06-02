<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TripVision</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<section class="login-container">
    <div class="login-overlay">
        <form action="{{ route('login') }}" method="POST" class="login-form">
            @csrf
            <h2 class="login-title">Login</h2>

            @if(session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required class="login-input" placeholder="Enter your username">
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required class="login-input" placeholder="Enter your password">
            </div>

            <button type="submit" class="login-button">Login</button>

            <p class="login-footer">Don't have an account? <a href="{{ url('/register') }}">Sign up here</a></p>
        </form>
    </div>
</section>

</body>
</html>
