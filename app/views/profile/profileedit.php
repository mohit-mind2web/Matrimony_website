
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="/assets/css/profileedit.css">
</head>
<main>
    <section>
<div class="edit">
    <?php if($_SESSION['profile_complete']==1):?>
<h2>Edit Profile</h2>
<hr class="line">
<?php if (!empty($errors)): ?>
    <?php foreach ($errors as $error): ?>
        <p style="color:red"><?= $error ?></p>
    <?php endforeach; ?>
<?php endif; ?>

<form method="post" action="/user/profileedit" enctype="multipart/form-data">

    <input type="hidden" name="old_photo" value="<?= $profile['profile_photo'] ?>">

    <label>Profile Photo</label>
    <input type="file" name="profile_photo">
    <img src="/uploads/<?= $profile['profile_photo'] ?>" width="100">

    <label>Mobile Number</label>
    <input type="text" name="number" maxlength="10" value="<?= $profile['mobileno']  ?>" required>

    <label>Date of Birth</label>
    <input type="date" name="dob" value="<?= $profile['dob'] ?>" required>

    <label>Gender</label>
    <select name="gender_id" required>
        <?php foreach ($genders as $id => $name): ?>
            <option value="<?= $id ?>" <?= $profile['gender'] ?? '' == $id ? 'selected' : '' ?>>
                <?= $name ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Religion</label>
    <select name="religion_id" required>
        <?php foreach ($religions as $id => $name): ?>
            <option value="<?= $id ?>" <?= $profile['religion_id'] ?? '' == $id ? 'selected' : '' ?>>
                <?= $name ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Height</label>
    <select name="height_id" required>
        <?php foreach ($heights as $id => $name): ?>
            <option value="<?= $id ?>" <?= $profile['height_id'] ?? '' == $id ? 'selected' : '' ?>>
                <?= $name ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Education</label>
    <select name="education_id" required>
        <?php foreach ($educations as $id => $name): ?>
            <option value="<?= $id ?>" <?= $profile['education_id'] ?? ''== $id ? 'selected' : '' ?>>
                <?= $name ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Profession</label>
    <select name="profession_id" required>
        <?php foreach ($professions as $id => $name): ?>
            <option value="<?= $id ?>" <?= $profile['profession_id'] ?? '' == $id ? 'selected' : '' ?>>
                <?= $name ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>City</label>
    <input type="text" name="city" value="<?= $profile['city'] ?? '' ?>" required>

    <label>About Me</label>
    <textarea name="about_me"><?= $profile['about_me'] ?? '' ?></textarea>
<div class="update">
    <a class="bk" href="/user/profileview?id=<?= $_SESSION['user_id'] ?>">Back</a>
    <button class="edit" type="submit">Update Profile</button>
    </div>

</form>
<?php else: ?>
    <h2>First Complete Your profile!</h2>
    <a href="/user/profilecreate">Complete your profile</a>
    <?php endif; ?>
</div>
    </section>
<main>
