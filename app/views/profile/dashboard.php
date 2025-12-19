<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Dashboard</h2>

<p>Login Successful ✅</p>

<p>Welcome, <?= $_SESSION['fullname']; ?></p>

<a href="/logout">Logout</a>

</body>
</html>