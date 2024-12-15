<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">
    <style>

    </style>
</head>
<body>
    <div class="container">
        <div class="image-section"></div>
        <div class="form-section">
            <div class="logo">
                <img src="/logo_upn.png" alt="Logo">
                <h1>UPT Pusat Bahasa</h1>
                <p>UPN Veteran Jawa Timur</p>
            </div>
            <form action="/login" method="POST">
                @csrf
                <input type="email" name="email" placeholder="Enter your email" required>
                <input type="password" name="password" placeholder="Enter password" required>
                <a href="#">Forget your password?</a>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
