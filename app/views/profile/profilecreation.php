<?php
include '../app/views/layouts/head.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/profilecreate.css">
    <title>Document</title>
</head>

<body>
    <main>
        <section>
    <div class="formsection">
    <h3>Welcome, <?= $_SESSION['fullname']; ?>! Complete your profile Details</h3>

    <?php if (!empty($errors)) { ?>
        <?php foreach ($errors as $error) { ?>
            <p style="color: red;"><?= $error ?></p>
        <?php } ?>
    <?php } ?>
    <form method="post" action="/user/profilecreate/profile" enctype="multipart/form-data">
        <label>Add profile photo</label>
        <input type="file" name="profile_photo">
        <label>Mobile Number</label>
        <input type="text" name="number" maxlength="10" pattern="[6-9]\d{9}" title="Enter valid 10-digit mobile number starting with 6-9" required>
        <label for="date">Date of Birth (Format:M/D/Y)</label>
        <input type="date" name="dob" min="1900-01-01" max="<?php echo date('Y-m-d'); ?>"  required>
        <label>Gender</label>
        <select name="gender_id" required>
            <option value="">Select Gender</option>
            <?php foreach ($genders as $id => $name): ?>
                <option value="<?= $id ?>"><?= $name ?></option>
            <?php endforeach; ?>
        </select>
        <label>Religion</label>
        <select name="religion_id" required>
            <option value="">Select Religion</option>
            <?php foreach ($religions as $id => $name): ?>
                <option value="<?= $id ?>"><?= $name ?></option>
            <?php endforeach; ?>
        </select>
        <label>Height</label>
        <select name="height_id" required>
            <option value="">Select Height</option>
            <?php foreach ($heights as $id => $name): ?>
                <option value="<?= $id ?>"><?= $name ?></option>
            <?php endforeach; ?>
        </select>
        <label>Education</label>
        <select name="education_id" required>
            <option value="">Select Education</option>
            <?php foreach ($educations as $id => $name): ?>
                <option value="<?= $id ?>"><?= $name ?></option>
            <?php endforeach; ?>
            </select>
        <label>Profession</label>
        <select name="profession_id" required>
            <option value="">Select Profession</option>
            <?php foreach ($professions as $id => $name): ?>
                <option value="<?= $id ?>"><?= $name ?></option>
            <?php endforeach; ?>
        </select>
        <label>City</label>
        <input type="text" name="city" required>
        <label>About Me</label>
        <textarea name="about_me"></textarea>
        <div class="skip">
        <a href="/user/matches">Skip</a>
        <button type="submit">Save Profile</button>
         </div>
    </form>
    </div>
</section>
    </main>
</body>

</html>