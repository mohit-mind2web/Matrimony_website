<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/assets/css/profileview.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/assets/js/connect.js"></script>
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
                <h3>ID - <?= $profileview['id'] ?></h3>
                

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
                <?php if ($profileview['status'] === null): ?>
                    <button class="connect-btn btn" data-receiver-id="<?= $profileview['user_id'] ?>">Connect</button>
                <?php elseif ($profileview['status'] === 0 && $profileview['sender_id'] == $_SESSION['user_id']): ?>
                    <button class="btnd disabled" disabled>Request Sent</button>
                <?php elseif ($profileview['status'] === 0 && $profileview['receiver_id'] == $_SESSION['user_id']): ?>
                    <button class="btnd disabled" disabled>Request Received</button>
                <?php elseif ($profileview['status'] === 1): ?>
                    <button class="btn">Connected</button>
                <?php elseif ($profileview['status'] === 2): ?>
                    <button class="btnd disabled" disabled>Request Rejected</button>
                <?php endif; ?>
                <button type="button" class="shortlist-icon" data-profile-id="<?= $profileview['user_id'] ?>">
                    <i class="<?= $profileview['is_shortlist'] ? 'fa-solid' : 'fa-regular' ?> fa-star"></i>
                    <span class="shortlist-text">
                        <?= $profileview['is_shortlist'] ? 'Shortlisted' : 'Shortlist' ?>
                    </span>
                </button>



            <?php else: ?>
                <button class="btn connect-btn" onclick="alert('Complete your profile to connect')">Connect</button>
            <?php endif; ?>
        </section>

        <section class="profile-section about">
            <h2>About Me</h2>
            <p><?= nl2br(htmlspecialchars($profileview['about_me'])) ?></p>
        </section>
        <?php if ($profileview['status'] === 1) { ?>
            <section class="profile-section details">
                <h2>Contact Details</h2>
                <ul>
                    <li><strong>Mobile Number:</strong> <?= htmlspecialchars($profileview['mobileno']) ?? 'N/A' ?> (Contact here)</li>
                    <li><strong>Email:</strong> <?= htmlspecialchars($profileview['email']) ?? 'N/A' ?></li>
                    <li><strong>City:</strong> <?= htmlspecialchars($profileview['city']) ?></li>
                </ul>
            </section><br>
        <?php } ?>

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
            <a href="/user/matches">Back</a>
        </div>
    </section>

</main>