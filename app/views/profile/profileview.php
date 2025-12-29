<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/assets/css/profileview.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/assets/js/connect.js"></script>
    <title>Profile View</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<main>
    <?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($_SESSION['success']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($_SESSION['error']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

    <section class="profile-view ">
        <section class="profile-header">
            <div class="profile-photod">
                <img src="/uploads/<?= $profileview['profile_photo'] ?>" class="profile-photo">
            </div>

            <div class="profile-basic">
                <h1><?= htmlspecialchars($profileview['fullname']) ?></h1>
                <h4>Profile-ID : <?= $profileview['id'] ?></h4>
                

                <p class="meta">
                    <?= date_diff(date_create($profileview['dob']), date_create())->y ?> yrs |
                    <?= $gender[$profileview['gender']] ?? 'N/A' ?> |
                    <?= $height[$profileview['height_id']] ?? 'N/A' ?>
                </p>

                <p class="location"><?= htmlspecialchars($profileview['city']) ?></p>
            </div>
            <div class="edit">
                <?php if($profileview['user_id']!=$_SESSION['user_id']): ?>
                <button type="button" class="editprofile" data-bs-toggle="modal"data-bs-target="#reportModal">Report Profile</button>
                <?php else:?>
                     <a class="editprofile" href="/user/profileedit">Edit Profile</a>
                    <?php endif;?>
            </div>
        </section>

        <section class="profile-actions">
              <?php if($profileview['user_id']!=$_SESSION['user_id']) :?>
            <?php if ($_SESSION['profile_complete'] == 1): ?>
                <?php if ($profileview['status'] === null): ?>
                    <button class="connect-btn btn" data-receiver-id="<?= $profileview['user_id'] ?>">Connect</button>
                <?php elseif ($profileview['status'] === 0 && $profileview['sender_id'] == $_SESSION['user_id']): ?>
                    <button class="btnd disabled" disabled>Interest Sent</button>
                <?php elseif ($profileview['status'] === 0 && $profileview['receiver_id'] == $_SESSION['user_id']): ?>
                    <button class="btnd disabled" disabled>Interest Received</button>
                <?php elseif ($profileview['status'] === 1): ?>
                                <form method="POST" action="/user/matches/disconnect">
                                    <input type="hidden" name="user_id" value="<?= $profileview['user_id'] ?>">
                                    <button class="disconnect" type="submit" >Disconnect</button>
                                </form>
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
            <?php  else:?>
                <a class="editprofile" href="/user/shortlists">View Shortlists Profiles</a>
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
        <div class="modal fade" id="reportModal" tabindex="-1">
  <div class="modal-dialog">
   <form method="POST" action="/user/report">
    <input type="hidden" name="reported_id" value="<?= $profileview['user_id'] ?>">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Report User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Reason</label>
            <select name="reason" class="form-select" required>
              <option value="">Select reason</option>
              <option value="Spam">Spam</option>
              <option value="Fake Profile">Fake Profile</option>
              <option value="Inappropriate">Inappropriate</option>
              <option value="Harassment">Harassment</option>
              <option value="Other">Other</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea   name="description"  class="form-control"  rows="4"  placeholder="Please describe the issue..."  maxlength="255"></textarea>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Report</button>
        </div>

      </div>
    </form>
  </div>
</div>

    </section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</main>