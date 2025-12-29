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
        <div class="form">
            <form id="filterForm" class="filter-form">

                <input type="text" name="city" placeholder="City">

                <select name="age_from">
                    <option value="">Age From</option>
                    <?php for ($i = 18; $i <= 60; $i++): ?>
                        <option value="<?= $i ?>"><?= $i ?></option>
                    <?php endfor; ?>
                </select>

                <select name="age_to">
                    <option value="">Age To</option>
                    <?php for ($i = 18; $i <= 60; $i++): ?>
                        <option value="<?= $i ?>"><?= $i ?></option>
                    <?php endfor; ?>
                </select>

                <select name="height_id">
                    <option value="">Height</option>
                    <?php foreach ($constants['heights'] as $id => $label): ?>
                        <option value="<?= $id ?>"><?= $label ?></option>
                    <?php endforeach; ?>
                </select>

                <select name="religion_id">
                    <option value="">Religion</option>
                    <?php foreach ($constants['religions'] as $id => $name): ?>
                        <option value="<?= $id ?>"><?= $name ?></option>
                    <?php endforeach; ?>
                </select>

                <select name="education_id">
                    <option value="">Education</option>
                    <?php foreach ($constants['educations'] as $id => $name): ?>
                        <option value="<?= $id ?>"><?= $name ?></option>
                    <?php endforeach; ?>
                </select>

                <select name="profession_id">
                    <option value="">Profession</option>
                    <?php foreach ($constants['professions'] as $id => $name): ?>
                        <option value="<?= $id ?>"><?= $name ?></option>
                    <?php endforeach; ?>
                </select>

                <button type="submit" class="search">Search</button>
                <button type="button" id="resetFilters">Reset</button>

            </form>

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

        <div class="profiles" id="profilesContainer">
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
                            <div class="view">
                            <a href="/user/profileview?id=<?= $profile['user_id'] ?>">View Profile</a>

                            <?php if ($profile['status'] === null || $profile['status']==3): ?>
                                <button class="connect-btn btn" data-receiver-id="<?= $profile['user_id'] ?>">Connect</button>
                            <?php elseif ($profile['status'] === 0 && $profile['sender_id'] == $_SESSION['user_id']): ?>
                                <button class="btnd disabled" disabled>Interest Sent</button>
                            <?php elseif ($profile['status'] === 0 && $profile['receiver_id'] == $_SESSION['user_id']): ?>
                                <button class="btnd disabled" disabled>Interest Received</button>
                            <?php elseif ($profile['status'] === 1): ?>
                                <form method="POST" action="/user/matches/disconnect">
                                    <input type="hidden" name="user_id" value="<?= $profile['user_id'] ?>">
                                    <button type="submit" >Disconnect</button>
                                </form>
                            <?php elseif ($profile['status'] === 2): ?>
                                <button class="btnd disabled" disabled>Request Rejected</button>
                            <?php endif; ?>
                            </div>
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
        <?php if (empty($_POST)): ?>
    <?php include __DIR__ . '/../layouts/pagination.php'; ?>
<?php endif; ?>
    </section>

</main>