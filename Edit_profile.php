<?php
  $link = @mysqli_connect("localhost", "DB-User_name", "DB-User_password", "notes");
  
  $mail = $_COOKIE["mail"];
  $sql = "SELECT * from user where Mail = '$mail'";
  $result = mysqli_query($link, $sql);
  $result = mysqli_fetch_array($result);
  
  $name = $result["Name"];
  $password = $result["Password"];
?>
<?php
  if(isset($_POST["send"])){
    $mail = $_POST["mail"];
    $account = $_POST["account"];
    $pass1 = $_POST["pass1"];
    $pass2 = $_POST["pass2"];
    date_default_timezone_set('Asia/Taipei');
    $time = date("Y-m-d H:i:s");          

    if($_POST["pass1"] != $_POST["pass2"]){
      $alert = "密碼輸入不相同";
      echo "<script type='text/javascript'>alert('$alert');</script>";
    }else{
      $sql1 = "UPDATE user SET 
      Name = '$name', Mail = '$mail', Account = '$account', Password = '$pass1'
      from user where Name = '$Name' ";
      mysqli_query($link, $sql1);

      $sql2 = "INSERT INTO user_history (Name, move, Time) 
      VALUES ('$name', 'edit-profile', '$time')";
      mysqli_query($link, $sql2);
    }
  }
?>
<?php
  include("Login_check.php");
  include_once("Navbar.php");
  echo "
    <form method='post' action='Edit_profile.php'>
      姓名:$name<br>
      信箱:<input type='mail' name='mail' value='$mail'><br>
      新密碼:<input type='text' name='pass1' value='$password'><br>
      再輸入一次密碼:<input type='password' name='pass2' value='$password'><br>
      <input type='submit' name='send'>
    </form>
  "
?>