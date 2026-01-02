<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/homepage.css" />
    <title>Matrimony Website</title>
</head>
<body>
    <header class="header">
    <div class="logo">
        <a href ="/"><h1>Soul<span>Mates</span></h1></a>
    </div>

    <div class="auth-buttons">
       <?php if (isset($_SESSION['user_id'])): ?>
    <h4>Welcome <?= $_SESSION['fullname'] ?>!</h4>
<?php else: ?>
    <a href="/login" class="btn login-btn">Login</a>
    <a href="/register" class="btn register-btn">Register</a>
<?php endif; ?>
    </div>
</header>
</body>
</html>