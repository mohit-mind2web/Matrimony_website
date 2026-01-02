<?php
include '../app/views/layouts/head.php';
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/login.css" />
    <title>Login page</title>
</head>
<body>
    <main>
        <section>
    <div>
        <h3>Welcome Login here!</h3>

        <?php if(!empty($errors)){?>
            <?php foreach($errors as $error) {?>
            <p style="color: red;"><?= $error ?></p>
            <?php }?>
            <?php }?><br>
        <form method="POST">
            <label>Email</label><br>
            <input type="email" name="email" placeholder=" Enter your Email" required><br>
            <label>Password</label><br>
            <input type="password" name="password" placeholder=" Enter password" required><br>
            <p>New User ? <a href="/register">Register here</a></p><br>
            <button type="submit">Login</button>
    </form>
    </section>
    </main>
   <?php include '../app/views/layouts/footer.php'; ?>

</div>
</body>
