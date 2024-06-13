<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    body{
      overflow: hidden;
    }
    .flex{
      width: 600px;
      background-color:#eee;
      margin: auto;
      margin-top: 10%;
      margin-bottom: 10%;
    }    
    form {
      border: solid;
      border-width: thin;
      text-align: center;
    }
    form input{
      margin-top:5%;
      margin-bottom: 2.5%;
    }
  </style>
  <?php
    if(isset($_POST["send"])){
      $name = $_POST["name"];
      $mail = $_POST["mail"];
      $account = $_POST["account"];
      $pass1 = $_POST["pass1"];
      $pass2 = $_POST["pass2"];
      $Create_note = $Delete_note = 0;
      if(strlen($name) > 6 ){
        $alert = "名稱長度不大於6";
        echo "<script type='text/javascript'>alert('$alert');</script>";
      }elseif($_POST["pass1"] != $_POST["pass2"]){
        $alert = "密碼輸入不相同";
        echo "<script type='text/javascript'>alert('$alert');</script>";
      }elseif(strlen($mail) < 8 ){
        $alert = "密碼需大於8個字數";
        echo "<script type='text/javascript'>alert('$alert');</script>";
      }else{
        $link = @mysqli_connect('localhost', 'DB-User_name', 'DB-User_password', 'notes');
        if(!$link){
          $alert = "資料庫連接失敗!";
          echo "<script type='text/javascript'>alert('$alert');</script>";
          exit();
        }else{
          mysqli_select_db($link, "notes");
          $valid = "select * from user where mail= '$mail'";
          $result = mysqli_query($link, $valid);
          $result = mysqli_fetch_array($result, MYSQLI_NUM);
          if(!$result){
            $sql = "INSERT INTO user
            (Name, Mail, Password, Create_note, Edit_note, Delete_note, Super_admin)
            VALUES ('$name', '$account', '$pass1', 0, 0, 0, 0)";
            mysqli_query($link, $sql);
            $alert = "帳號新增成功";
            echo "<script type='text/javascript'>alert('$alert');</script>";
            header("Refresh:0.5; url=index.php");  
          }else{
            $alert = "此信箱已被註冊過!";
            echo "<script type='text/javascript'>alert('$alert');</script>";
            header("Location: register.php");  
          }
        }      
      }
    }
  ?>
</head>
<body>
  <div class="flex">
    <form method="POST" action="register.php">
      姓名: <input type="text" name="name" required><br>
      信箱: <input type="mail" name="mail" required><br>
      密碼: <input type="password" name="pass1" required><br>
      再輸入一次密碼: <input type="password" name="pass2" required>
      <input type="submit" name="send">
    </form>
  </div>
</body>
</html>