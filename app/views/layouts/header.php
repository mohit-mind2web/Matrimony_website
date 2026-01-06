<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <?php

if (empty($_SESSION['csrf_token'])) {
    // Generate a 32-byte token 
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];
?>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="<?php echo $csrf_token; ?>">

  <title>SoulMates Matrimony</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="/assets/css/header.css" />
  <script src="/assets/js/tabs.js"></script> 
</head>
<body>
  <header class="header">
    <div class="logo">
      <a href="/user/matches"><h1>Soul<span>Mates</span></h1></a>
    </div>
    <div class="nav">
      <h2>Welcome <?= $_SESSION['fullname']?> !</h2>
      <i onclick="menu(event)" class="fas fa-bars menu-icon"></i>
      <div class="profile">
        <nav>
          <?php if($_SESSION['role_id']==2):?>
          <ul>
            <li><a href="/user/profileview?id=<?= $_SESSION['user_id'] ?>">Your Profile</a></li>
            <li> <a  href="/user/profileedit">Edit Profile</a></li>
            <li><a href="/user/contactsupport">Get Help</a></li>
            <li><a href="/logout">Logout</a></li>
          </ul>
          <?php else:?>
            <ul>
            <li><a href="/admin/managequeries">View Queries</a></li>
            <li><a href="/logout">Logout</a></li>
            </ul>
            <?php endif;?>

        </nav>
      </div>
    </div>
  </header>


    <div class="sidebar">
        <?php 
        $current_page = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        ?>
       <?php if($_SESSION['role_id']==2):?>
      <ul>
        <li><a href="/user/matches" class="<?= $current_page == '/user/matches' ? 'active' : '' ?>">My Matches</a></li>
        <?php if ($_SESSION['profile_complete']!=1): ?>
          <li><a href="/user/profilecreate" class="<?= $current_page == '/user/profilecreate' ? 'active' : '' ?>">Complete Profile</a></li>
        <?php endif; ?>
        <li><a href="/user/interests" class="<?= $current_page == '/user/interests' ? 'active' : '' ?>">Interests Received</a></li>
        <li><a href="/user/shortlists" class="<?= $current_page == '/user/shortlists' ? 'active' : '' ?>">Shortlists Profiles</a></li>
          <li><a href="/user/chatinbox" class="<?= $current_page == '/user/chatinbox' ? 'active' : '' ?>">Chat Inbox</a></li>
         <li><a href="/user/queries" class="<?= $current_page == '/user/queries' ? 'active' : '' ?>">Your queries</a></li>
        <li><a href="/user/contactsupport" class="<?= $current_page == '/user/contactsupport' ? 'active' : '' ?>">Help & Support</a></li>
        <li><a href="/logout">Logout</a></li>
      </ul>
       <?php endif;?>
       <?php if($_SESSION['role_id']==1):?>
        <ul>
        <li><a href="/admin/dashboard" class="<?= $current_page == '/admin/dashboard' ? 'active' : '' ?>">Dashboard</a></li>
        <li><a href="/admin/usermanage" class="<?= $current_page == '/admin/usermanage' ? 'active' : '' ?>">Manage Users</a></li>
        <li><a href="/admin/managereports" class="<?= $current_page == '/admin/managereports' ? 'active' : '' ?>">Manage Reports</a></li>
        <li><a href="/admin/managequeries" class="<?= $current_page == '/admin/managequeries' ? 'active' : '' ?>">Manage Queries</a></li>
        <li><a href="/admin/activity-logs" class="<?= $current_page == '/admin/activity-logs' ? 'active' : '' ?>">Activity Logs</a></li>
        <li><a href="/logout">Logout</a></li>
      </ul>
      <?php endif;?>
        </div>
</body>
</html>
