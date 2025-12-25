<?php
$heights = $constants['heights'] ?? [];
$religions = $constants['religions'] ?? [];
?>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/assets/css/matches.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/assets/js/connect.js"></script> 
    <title>Document</title>
</head>

<main>
    <section>
        <div>
            <?php if ($_SESSION['profile_complete'] != 1) { ?>
                <h2>All Profiles</h2>
            <?php } else { ?>
                <h2>Matches for You</h2>
            <?php } ?>
        </div>
        <?php if ($_SESSION['profile_complete'] != 1) { ?>
            <div class="incomplete">
                <div>
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div class="unlock">
                    <h3>Your Profile is Incomplete !</h3>
                    <h3>Unlock Matches Now</h3>
                </div>
            </div><br>
            <div class="complete">
                <a href="/user/profilecreate">Complete Profile To view Matches</a>
            </div>
        <?php } ?>

        <div class="profiles">
            <?php if (!empty($profiles)) { ?>
                <?php foreach ($profiles as $profile) { ?>
                    <div class="card">
                        <div class="shortlist-icon" data-profile-id="<?= $profile['user_id'] ?>">
                           <i class="<?= !empty($profile['is_shortlist']) ? 'fa-solid' : 'fa-regular' ?> fa-star"></i>
                        </div>

                        <img src="/uploads/<?= $profile['profile_photo'] ?? 'default.png' ?>" width="120">

                        <h4><?= htmlspecialchars($profile['fullname']) ?></h4>

                        <p class="meta">
                            <?= $profile['age'] ?> yrs |
                            <?= $heights[$profile['height_id']] ?? 'Height N/A' ?> |
                            <?= $religions[$profile['religion_id']] ?? 'Religion N/A' ?>
                        </p>
                        <p><?= htmlspecialchars($profile['city']) ?></p>

                        <?php if ($profile_complete): ?>
                            <a href="/user/profileview?id=<?= $profile['user_id'] ?>">View Profile</a>
                             <?php
                            $status = $profile['requeststatus'] ?? null;
                            ?>
                            <?php if ($status === null): ?>
                                <button class="connect-btn btn" data-receiver-id="<?= $profile['user_id'] ?>">Connect</button>
                            <?php elseif ($status === 0): ?>
                                <button class="btnd disabled" disabled>Request Sent</button>
                            <?php elseif ($status === 1): ?>
                                <button class="contact">Contact Now</button>
                            <?php elseif ($status === 2): ?>
                                <button class="btnd disabled" disabled>Request Rejected</button>
                            <?php endif; ?>
                        <?php else: ?>
                            <button disabled>View Profile </button>
                            <button onclick="alert('Please complete your profile first')"> Connect</button>
                        <?php endif; ?>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p>No matching record Found</p>
            <?php } ?>

        </div>
       <?php include __DIR__ . '/../layouts/pagination.php'; ?>
    </section>
    
</main>
