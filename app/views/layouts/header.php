<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>SoulMates Matrimony</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="/assets/css/header.css" />
</head>
<body>
  <header class="header">
    <div class="logo">
      <h1>Soul<span>Mates</span></h1>
    </div>
    <div class="nav">
      <h2>Welcome <?= $_SESSION['fullname']?> !</h2>
      <i onclick="menu(event)" class="fas fa-bars menu-icon"></i>
      <div class="profile">
        <nav>
          <?php if($_SESSION['role_id']==2):?>
          <ul>
            <li><a href="/user/profileview?id=<?= $_SESSION['user_id'] ?>">View Profile</a></li>
            <li> <a  href="/user/profileedit">Edit Profile</a></li>
            <li><a href="/admin/managequeries">Get Help</a></li>
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
       <?php if($_SESSION['role_id']==2):?>
      <ul>
        <li><a href="/user/matches">My Matches</a></li>
        <?php if ($_SESSION['profile_complete']!=1): ?>
          <li><a href="/user/profilecreate">Complete Profile</a></li>
        <?php endif; ?>
        <li><a href="/user/interests">Interests Received</a></li>
        <li><a href="/user/shortlists">Shortlists Profiles</a></li>
        <li><a href="/user/contactsupport">Help & Support</a></li>
        <li><a href="/logout">Logout</a></li>
      </ul>
       <?php endif;?>
       <?php if($_SESSION['role_id']==1):?>
        <ul>
        <li><a href="/admin/dashboard">Dashboard</a></li>
        <li><a href="/admin/usermanage">Manage Users</a></li>
        <li><a href="/admin/managereports">Manage Reports</a></li>
        <li><a href="/admin/managequeries">Manage Queries</a></li>
        <li><a href="/logout">Logout</a></li>
      </ul>
      <?php endif;?>
        </div>


 <script>
        function menu(event) {
            const profile = document.querySelector('.profile');

            if (profile.style.display === "block") {
                profile.style.display = "none";
            } else {
                profile.style.display = "block";
            }
        }
    </script>
</body>
</html>
