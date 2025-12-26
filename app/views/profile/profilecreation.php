<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/profilecreate.css" />
    <title>Document</title>
</head>

<body>
    <p>Welcome, <?= $_SESSION['fullname']; ?>! Complete your profile Details</p>

    <?php if (!empty($errors)) { ?>
        <?php foreach ($errors as $error) { ?>
            <p style="color: red;"><?= $error ?></p>
        <?php } ?>
    <?php } ?>
    <form method="post" action="/user/profilecreate" enctype="multipart/form-data">
        <label>Add profile photo</label><br>
        <input type="file" name="profile_photo"><br><br>
        <label>Mobile Number</label>
        <input type="text" name="number" maxlength="10" required><br><br>
        <label for="date">date</label><br>
        <input type="date" name="dob" required><br><br>
        <label>Gender</label><br>
        <select name="gender_id" required>
            <option value="">Select Gender</option>
            <?php foreach ($genders as $id => $name): ?>
                <option value="<?= $id ?>"><?= $name ?></option>
            <?php endforeach; ?>
        </select><br><br>
        <label>Religion</label><br>
        <select name="religion_id" required>
            <option value="">Select Religion</option>
            <?php foreach ($religions as $id => $name): ?>
                <option value="<?= $id ?>"><?= $name ?></option>
            <?php endforeach; ?>
        </select><br><br>
        <label>Height</label><br>
        <select name="height_id" required>
            <option value="">Select Height</option>
            <?php foreach ($heights as $id => $name): ?>
                <option value="<?= $id ?>"><?= $name ?></option>
            <?php endforeach; ?>
        </select><br><br>
        <label>Education</label><br>
        <select name="education_id" required>
            <option value="">Select Education</option>
            <?php foreach ($educations as $id => $name): ?>
                <option value="<?= $id ?>"><?= $name ?></option>
            <?php endforeach; ?>
        </select><br><br>
        <label>Profession</label><br>
        <select name="profession_id" required>
            <option value="">Select Profession</option>
            <?php foreach ($professions as $id => $name): ?>
                <option value="<?= $id ?>"><?= $name ?></option>
            <?php endforeach; ?>
        </select><br><br>
        <label>City</label><br>
        <input type="text" name="city" required><br><br>
        <label>About Me</label><br>
        <textarea name="about_me"></textarea><br><br>
        <a href="/user/matches">Skip</a>
        <button type="submit">Save Profile</button>
    </form>

</body>

</html>