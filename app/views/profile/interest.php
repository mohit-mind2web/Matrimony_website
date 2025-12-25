

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/assets/css/interest.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<main>
    <section>
      <div class="head"> <h2>Interests Received</h2></div>
        <div class="container">
        <?php if (!empty($receivedinterest)) { ?>
            <?php foreach ($receivedinterest as $receive) { ?>
                <div class="card">
                    <div class="photo">
                        <img src="/uploads/<?= $receive['profile_photo'] ?? 'default.png' ?>" width="120">
                        <div class="name">
                        <h4><?= htmlspecialchars($receive['fullname']) ?></h4>
                          <p><?= htmlspecialchars($receive['city']) ?></p>

                        </div>
                    </div>
                    <div class="action">
                        <?php if ($receive['status'] == 0): ?>
                            <a href="/interest/accept?reqid=<?= $receive['id'] ?>" class="accept">Accept</a>
                            <a href="interest/reject?reqid=<?= $receive['id'] ?>" class="reject">Decline</a>
                        <?php elseif ($receive['status'] == 1): ?>
                            <span class="accept">Accepted</span>
                          <a href="/user/profileview?id=<?= $receive['user_id']  ?>" class="contact">Contact Now</a>
                        <?php elseif ($receive['status'] == 2): ?>
                            <span class="reject">Declined</span>

                        <?php endif; ?>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>No Interests Received</p>
        <?php } ?>
        </div>

        <div class="head2"> <h2>Interests Sent</h2></div>
         <div class="container">
        <?php if (!empty($sentinterest)) { ?>
            <?php foreach ($sentinterest as $sent) { ?>
                <div class="card">
                    <div class="photo">
                        <img src="/uploads/<?= $sent['profile_photo'] ?? 'default.png' ?>" width="120">
                        <div class="name">
                        <h4><?= htmlspecialchars($sent['fullname']) ?></h4>
                          <p><?= htmlspecialchars($sent['city']) ?></p>

                        </div>
                    </div>
                    <div class="action">
                        <?php if ($sent['status'] == 0): ?>
                            <span class="requestsent">Interest Sent</span>
                        <?php elseif ($sent['status'] == 1): ?>
                                <span class="accept">Accepted</span>
                            <a href="/user/profileview?id=<?= $sent['user_id']  ?>" class="contact">Contact Now</a>
                        <?php elseif ($sent['status'] == 2): ?>
                            <span class="reject">Declined</span>

                        <?php endif; ?>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>No Sent Interests</p>
        <?php } ?>
        </div>
          <?php include __DIR__ . '/../layouts/pagination.php'; ?>
    </section>
</main>