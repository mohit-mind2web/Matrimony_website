<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/register.css" />
    <title>Register</title>
</head>

<body>
    <section>
        <h3>Welcome Register Here!</h3>
        <?php if (!empty($errors)) { ?>
            <?php foreach ($errors as $error) { ?>
                <p style="color: red;"><?= $error ?></p>
            <?php } ?>
        <?php } ?>
        <form method="POST">
            <label>Profile Created for</label><br>
            <select name="profile_for">
                <option value="1">Myself</option>
                <option value="2">Son</option>
                <option value="3">Daughter</option>
                <option value="4">Relative</option>
            </select><br><br>
            <label>Full Name</label><br>
            <input type="text" name="fullname" pattern="[A-Za-z\s]{3,50}" title="Only letters and spaces,3-50 characters" required><br><br>
            <label>Email</label><br>
            <input type="text" name="email" placeholder=" Enter your Email" required><br><br>
            <label>Password</label><br>
            <input type="text" name="password" placeholder=" Enter password" pattern=".{6,255}" title="Minimum 6 characters"><br>
            <p>Already have an account?<a href="/login">Login here</a></p>
            <button type="submit">Register</button>
        </form>

    </section>

</body>

</html>