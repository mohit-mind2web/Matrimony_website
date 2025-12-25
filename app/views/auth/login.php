
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page</title>
</head>
<body>
    <div>
        <h3>Welcome Login here!</h3>

        <?php if(!empty($errors)){?>
            <?php foreach($errors as $error) {?>
            <p style="color: red;"><?= $error ?></p>
            <?php }?>
            <?php }?>
        <form method="POST">
            <label>Email</label><br>
            <input type="text" name="email" placeholder=" Enter your Email" required><br><br>
            <label>Password</label><br>
            <input type="text" name="password" placeholder=" Enter password" required><br>
            <p>New User?<a href="/register">Register here</a></p>
            <button type="submit">Login</button>
    </form>

</div>
