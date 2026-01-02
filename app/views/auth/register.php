<?php
include '../app/views/layouts/head.php';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/register.css" />
    <title>Register</title>
</head>

<body>
    <main>
    <section>
        <h3>Welcome Register Here!</h3>
        <?php if (!empty($errors)) { ?>
            <?php foreach ($errors as $error) { ?>
                <p class="error"><?= $error ?></p>
            <?php }?>
        <?php }  elseif(!empty($success)){?>
                 <p class="success"><?= $success ?></p>
                 <?php }?>
        <form method="POST">
            <label>Profile Created for</label>
            <select name="profile_for">
                <option value="1">Myself</option>
                <option value="2">Son</option>
                <option value="3">Daughter</option>
                <option value="4">Relative</option>
            </select>
            <label>Full Name</label>
            <input type="text" name="fullname" pattern="[A-Za-z\s]{3,50}" title="Only letters and spaces,3-50 characters" required>
            <label>Email</label>
            <input type="email" name="email" placeholder=" Enter your Email" required>
            <label>Password</label>
            <input type="password" name="password" placeholder=" Enter password" pattern=".{6,255}" title="Minimum 6 characters" required>
            <p>Already have an account ? <a href="/login">Login here</a></p>
            <button type="submit">Register</button>
        </form>

    </section>
</main>
 <?php include '../app/views/layouts/footer.php'; ?>
</body>