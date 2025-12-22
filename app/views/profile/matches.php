
<?php
include '../app/views/layouts/header.php';
?>

<head>
    <meta charset="UTF-8">
  <link rel="stylesheet" href="/assets/css/matches.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

    <main>
        <section>
        <div><h2>Matches for You</h2></div>
            <?php if($_SESSION['profile_complete']!=1) {?>
                <div class="incomplete">
                    <div>
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div class="unlock">
                    <h3>Your Profile is Incomplete !</h3>
                    <h3>Unlock Matches Now</h3>
                    </div>
                </div><br>
                <br>
                <div class="complete">
               <a href="/user/profilecreate">Complete Profile To view</a></div>
                <?php }?>

                <div class="profiles">
                    
                </div>
        </section>
    </main>
