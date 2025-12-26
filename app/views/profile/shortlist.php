
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/assets/css/interest.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/assets/js/connect.js"></script> 
    <title>Shortlist</title>
</head>
<main>
    <section>
      <div class="head"><h2>Shortlisted Profiles</h2></div>
         <div class="container">
        <?php if (!empty($shortlistprofiles)) { ?>
            <?php foreach ($shortlistprofiles as $shortlist) { ?>
                <div class="card">
                    <div class="photo">
                        <img src="/uploads/<?= $shortlist['profile_photo'] ?? 'default.png' ?>" width="120">
                        <div class="name">
                        <h4><?= htmlspecialchars($shortlist['fullname']) ?></h4>
                          <p><?= htmlspecialchars($shortlist['city']) ?> | <?= $shortlist['age'] ?> yrs</p>

                        </div>
                    </div>
                    <div class="action">
                        
                        <?php if ($profilecomplete): ?>
                            <a class="shortlist" href="/user/profileview?id=<?= $shortlist['user_id'] ?>">View Profile</a>
                             <?php
                            $status = $shortlist['status'] ?? null;
                            ?>
                            <?php if ($status === null ): ?>
                                <button class="connect-btn btn" data-receiver-id="<?= $shortlist['user_id'] ?>">Connect</button>
                            <?php elseif ($status === 0 && $shortlist['sender_id']=== $_SESSION['user_id']): ?>
                                <button class="btnd disabled" disabled>Interest Sent</button>
                                  <?php elseif ($status === 0 && $shortlist['receiver_id']=== $_SESSION['user_id']): ?>
                                <button class="btnd disabled" disabled> Interest Received</button>
                            <?php elseif ($status === 1): ?>
                              <a href="/user/profileview?id=<?= $shortlist['user_id']  ?>" class="contact">Contact Now</a>
                            <?php elseif ($status === 2): ?>
                                <button class="btnd disabled" disabled>Request Rejected</button>
                            <?php endif; ?>
                        <?php else: ?>
                            <button disabled>View Profile </button>
                            <button onclick="alert('Please complete your profile first')"> Connect</button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>No Shortlisted profiles! </p>
            <a href="/user/matches">View Matches</a>
        <?php } ?>
        </div>
         <?php include __DIR__ . '/../layouts/pagination.php'; ?> 
    </section>
</main>