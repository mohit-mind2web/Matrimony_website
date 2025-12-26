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

                        <?php if ($_SESSION['profile_complete']): ?>
                            <a href="/user/profileview?id=<?= $profile['user_id'] ?>">View Profile</a>

                            <?php if ($profile['status'] === null): ?>
                                <button class="connect-btn btn" data-receiver-id="<?= $profile['user_id'] ?>">Connect</button>
                            <?php elseif ($profile['status'] === 0 && $profile['sender_id'] == $_SESSION['user_id']): ?>
                                <button class="btnd disabled" disabled>Request Sent</button>
                            <?php elseif ($profile['status'] === 0 && $profile['receiver_id'] == $_SESSION['user_id']): ?>
                                <button class="btnd disabled" disabled>Request Received</button>
                            <?php elseif ($profile['status'] === 1): ?>
                                <button class="contact">Contact Now</button>
                            <?php elseif ($profile['status'] === 2): ?>
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
           