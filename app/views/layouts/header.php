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
      <h2>Welcome <?= $_SESSION['fullname'] ?? 'Guest' ?> !</h2>
      <i onclick="menu(event)" class="fas fa-bars menu-icon"></i>
      <div class="profile">
        <nav>
          <ul>
            <li><a href="/profile">View Profile</a></li>
            <li><a href="/queries">Edit Profile</a></li>
            <li><a href="/employee/contactsupport">Get Help</a></li>
            <li><a href="/logout">Logout</a></li>
          </ul>
        </nav>
      </div>
    </div>
  </header>


    <div class="sidebar">
      <ul>
        <li><a href="/user/matches">My Matches</a></li>
        <?php if ($_SESSION['profile_complete']!=1): ?>
          <li><a href="/user/profilecreate">Complete Profile</a></li>
        <?php endif; ?>
        <li><a href="/profile/view">Search / Filter</a></li>
        <li><a href="/profile/requests">Interest Received</a></li>
        <li><a href="/favorites">Shortlist Profiles</a></li>
        <li><a href="/logout">Logout</a></li>
      </ul>
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
