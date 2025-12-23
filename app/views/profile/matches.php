<?php
include '../app/views/layouts/header.php';

$heights = $constants['heights'] ?? [];
$religions = $constants['religions'] ?? [];
?>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/assets/css/matches.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<main>
    <section>
        <div>
             <?php if ($_SESSION['profile_complete'] != 1) { ?>
            <h2>All Profiles</h2>
            <?php } else{?>
                 <h2>Matches for You</h2>
                <?php }?>
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
                         <div class="shortlist-icon">
        <i class="fa-regular fa-star"></i>
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
                <a href="/connect/send/<?= $profile['user_id'] ?>">Connect</a>
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
    </section>
</main>
<script>
document.querySelectorAll('.shortlist-icon').forEach(icon => {
    icon.addEventListener('click', () => {
        const i = icon.querySelector('i');
        i.classList.toggle('fa-regular');
        i.classList.toggle('fa-solid');
    });
});
</script>