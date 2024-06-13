<?php
  if(!isset($_COOKIE["current_user"])){
    $alert = "您已登出，請重新再登入";
    echo "<script type='text/javascript'>alert('$alert'); location='index.php'</script>";      
  }
?>