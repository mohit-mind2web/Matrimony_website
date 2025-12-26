<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/assets/css/interest.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <script src="/assets/js/tabs.js"></script> 
    <title>Document</title>
</head>
<main>
    <section>
        <div class="tabs">
            <button class="tab-btn" onclick="showTab('received',this)">Interests Received</button>
            <button class="tab-btn" onclick="showTab('sent',this)">Interests Sent</button>
            <button class="tab-btn" onclick="showTab('accepted',this)">Accepted Interests</button>
            <button class="tab-btn" onclick="showTab('declined',this)">Declined Interests</button>
        </div>

        <div id="received" class="tab-content active">
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
            <?php $pagination = $receivepagination; ?>
             <?php include __DIR__ . '/../layouts/pagination.php'; ?> 
        </div>

        <div id="sent" class="tab-content">
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
            <?php $pagination = $sentpagination; ?>
             <?php include __DIR__ . '/../layouts/pagination.php'; ?> 
        </div>

         <div id="accepted" class="tab-content">
            <div class="container">
                <?php if (!empty($acceptinterest)) { ?>
                    <?php foreach ($acceptinterest as $accept) { ?>
                        <div class="card">
                            <div class="photo">
                                <img src="/uploads/<?= $accept['profile_photo'] ?? 'default.png' ?>" width="120">
                                <div class="name">
                                    <h4><?= htmlspecialchars($accept['fullname']) ?></h4>
                                    <p><?= htmlspecialchars($accept['city']) ?></p>

                                </div>
                            </div>
                            <div class="action">
                                <?php if ($accept['status'] == 0): ?>
                                    <span class="requestsent">Interest Sent</span>
                                <?php elseif ($accept['status'] == 1): ?>
                                    <span class="accept">Accepted</span>
                                    <a href="/user/profileview?id=<?= $accept['user_id']  ?>" class="contact">Contact Now</a>
                                <?php elseif ($accept['status'] == 2): ?>
                                    <span class="reject">Declined</span>

                                <?php endif; ?>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <p>No Accepted Interests</p>
                <?php } ?>
            </div>
            <?php $pagination = $acceptpagination; ?>
             <?php include __DIR__ . '/../layouts/pagination.php'; ?> 
        </div>


         <div id="declined" class="tab-content">
            <div class="container">
                <?php if (!empty($declineinterest)) { ?>
                    <?php foreach ($declinetinterest as $decline) { ?>
                        <div class="card">
                            <div class="photo">
                                <img src="/uploads/<?= $decline['profile_photo'] ?? 'default.png' ?>" width="120">
                                <div class="name">
                                    <h4><?= htmlspecialchars($decline['fullname']) ?></h4>
                                    <p><?= htmlspecialchars($decline['city']) ?></p>

                                </div>
                            </div>
                            <div class="action">
                                <?php if ($decline['status'] == 0): ?>
                                    <span class="requestsent">Interest Sent</span>
                                <?php elseif ($decline['status'] == 1): ?>
                                    <span class="accept">Accepted</span>
                                    <a href="/user/profileview?id=<?= $decline['user_id']  ?>" class="contact">Contact Now</a>
                                <?php elseif ($decline['status'] == 2): ?>
                                    <span class="reject">Declined</span>

                                <?php endif; ?>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <p>No Declined Interests</p>
                <?php } ?>
            </div>
            <?php $pagination = $declinepagination; ?>
             <?php include __DIR__ . '/../layouts/pagination.php'; ?> 
        </div>
        

    </section>
</main>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const params = new URLSearchParams(window.location.search);
    const tab = params.get('tab') || 'received';

    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(tc => tc.classList.remove('active'));

    const activeTab = document.getElementById(tab);
    if (activeTab) {
        activeTab.classList.add('active');
    }

    const activeBtn = document.querySelector(`[onclick*="${tab}"]`);
    if (activeBtn) {
        activeBtn.classList.add('active');
    }
});
</script>