<?php
include '../app/views/layouts/header.php';
?>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/assets/css/profileview.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile View</title>
</head>

<main>
    <section class="profile-view ">
        <section class="profile-header">
            <div class="profile-photod">
                <img src="/uploads/<?= $profileview['profile_photo'] ?>" class="profile-photo">
            </div>

            <div class="profile-basic">
                <h1><?= htmlspecialchars($profileview['fullname']) ?></h1>

                <p class="meta">
                    <?= date_diff(date_create($profileview['dob']), date_create())->y ?> yrs |
                    <?= $gender[$profileview['gender']] ?? 'N/A' ?> |
                    <?= $height[$profileview['height_id']] ?? 'N/A' ?>
                </p>

                <p class="location"><?= htmlspecialchars($profileview['city']) ?></p>
            </div>
        </section>

        <section class="profile-actions">
            <?php if ($_SESSION['profile_complete'] == 1): ?>
                <a href="/connect/send/<?= $profileview['user_id'] ?>" class="btn connect-btn">Connect</a>
                <button class="btn shortlist-btn"><i class="fa-solid fa-star"></i> Shortlist</button>
            <?php else: ?>
                <button class="btn connect-btn" onclick="alert('Complete your profile to connect')">Connect</button>
            <?php endif; ?>
        </section>

        <section class="profile-section about">
            <h2>About Me</h2>
            <p><?= nl2br(htmlspecialchars($profileview['about_me'])) ?></p>
        </section>

        <section class="profile-section details">
            <h2>Basic Details</h2>
            <ul>
                <li><strong>Height:</strong> <?= $height[$profileview['height_id']] ?? 'N/A' ?></li>
                <li><strong>Religion:</strong> <?= $religions[$profileview['religion_id']] ?? 'N/A' ?></li>
                <li><strong>Education:</strong> <?= $education[$profileview['education_id']] ?? 'N/A' ?></li>
                <li><strong>Profession:</strong> <?= $profession[$profileview['profession_id']] ?? 'N/A' ?></li>
                <li><strong>City:</strong> <?= htmlspecialchars($profileview['city']) ?></li>
            </ul>
        </section><br>
<div class="back">
        <a href="/user/matches"> < Back</a></div>
    </section>

</main>