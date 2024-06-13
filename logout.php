<?php
  $link = @mysqli_connect('localhost', 'DB-User_name', 'DB-User_password', 'notes');
  
  date_default_timezone_set('Asia/Taipei');
  $time = date("Y-m-d H:i:s");
  $name = $_COOKIE["current_user"];
  $sql = "INSERT INTO user_history (Name, move, Time)
  Values('$name', 'logout', '$time')";
  mysqli_query($link, $sql);  
  
  //刪除確認已登入的cookie
  setcookie("login_success", $login_success, time() - 3600);
  setcookie("current_user", $current_user, time() - 3600);
  setcookie("Create_note", $create_note, time() - 3600);
  setcookie("Delete_note", $Delete_note, time() - 3600);
  setcookie("Super_admin", $Super_admin, time() - 3600);
  
  $alert = "已登出!歡迎您再次登入";
  echo "<script type='text/javascript'>alert('$alert');</script>";  
  header("Location: index.php");
?>