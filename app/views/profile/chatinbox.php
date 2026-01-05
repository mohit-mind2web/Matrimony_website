<head>
    <link rel="stylesheet" href="/assets/css/interest.css" />
</head>
<main>
    <section>
      <div class="head"><h2>Chat Inbox</h2></div>
         <div class="container">
            Messages
        <?php if (!empty($friends)) { ?>
            <?php foreach ($friends as $friend) { ?>
                <div class="card">
                    <div class="photo">
                        <img src="/uploads/<?= $friend['profile_photo'] ?? 'default.png' ?>" width="120">
                        <div class="name">
                        <h4><?= htmlspecialchars($friend['fullname']) ?></h4>
                        </div>
                    </div>
                    <div class="action">
                        <a href="/user/messages?id=<?= $friend['user_id'] ?>" class="message-btn">Message</a>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>No messages yet! </p>
        <?php } ?>
        </div> 
    </section>
</main>