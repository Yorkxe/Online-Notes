<?php
  include("Login_check.php");
  $user = $_COOKIE["current_user"];
?>
<!DOCTYPE html>
<html lang='en'>
<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <link rel='stylesheet' type='text/css' href='Breakpoint.css'>
  <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH' crossorigin='anonymous'>
  <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz' crossorigin='anonymous'></script>
  <title></title>
</head>
<body>
  <div class='row'>
    <div id='search'>
      <nav class='navbar navbar-expand-md bg-dark'>
        <div class='container-fluid'>
          <button class='navbar-toggler me-auto' type='button' data-bs-toggle='collapse' data-bs-target='#navbarTogglerDemo03' aria-controls='navbarTogglerDemo03' aria-expanded='false' aria-label='Toggle navigation'>
            <span class='navbar-toggler-icon'></span>
          </button>
          <div class='collapse navbar-collapse' id='navbarTogglerDemo03'>
            <ul class='navbar-nav me-auto mb-2 mb-lg-0'>
              <li class='nav-item'>
                <?php
                 echo "<a class='nav-link d-flex justify-content-center text-light' href='welcome.php'>Welcome, $user</a>";
                ?>
              </li>
              <li class='nav-item'>
                <a class='nav-link d-flex justify-content-center text-light' href='About.php'>About</a>
              </li>
              <li class='nav-item'>
                <a class='nav-link d-flex justify-content-center text-light' href='Note_list.php?mode=list'>Note list</a>
              </li>
              <?php 
              if($_COOKIE["Create_note"] == 1)
               echo "<li class='nav-item'><a class='nav-link d-flex justify-content-center text-light' href='Create_note.php'>Create</a></li>";
              ?>
              <li class='nav-item'>
                <a class='nav-link d-flex justify-content-center text-light' href='Edit_profile.php'>Personal profile</a>
              </li>
              <?php
               if($_COOKIE["Super_admin"] == 1)
                echo ("<li class='nav-item'><a class='nav-link d-flex justify-content-center text-light' href='Super_admin.php'>Super_admin</a></li>");
              ?>
              <li class='nav-item'>
                <a class='nav-link d-flex justify-content-center text-light' href='logout.php'>Logout</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </div>
  </div>
</body>
</html>