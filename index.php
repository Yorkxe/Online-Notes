<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Index.html</title>
  <style>
    body{
      overflow: hidden;
    }
    .flex{
      width: 600px;
      background-color:#eee;
      margin: auto;
      margin-top: 25%;
      margin-bottom: 25%;
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
      $mail = $_POST["mail"];
      $password = $_POST["password"];
      $link = @mysqli_connect('localhost', 'DB-User_name', 'DB-User_password', 'notes');
      if(!$link){
        //fail to connect to database
        $alert = "資料庫連接失敗!";
        echo "<script type='text/javascript'>alert('$alert');</script>";
      }else{
        //find the account
        $sql = "select * from user where Mail= '$mail'";
        $result = mysqli_query($link, $sql);
        // turn the mysqli_result into array
        $row = mysqli_fetch_array($result);
        //the result is NULL, represent the account doesn't exist!
        if($row == NULL){
          // jumping alert shows the account doesn't exist, and go back to index.php
          $alert = "查無此帳號";
          echo "<script type='text/javascript'>alert('$alert');</script>";
        }else{
          if($row['Password'] != $password){
            //jumping alert shows the password is incorrect, and go back to index.php
            $alert = "密碼錯誤!";
            echo "<script type='text/javascript'>alert('$alert');</script>";
          }else{
            $date = strtotime("+1 days", time());
            date_default_timezone_set('Asia/Taipei');
            $time = date("Y-m-d H:i:s");          
            $login_success = TRUE;
            $current_user = $row["Name"];
            $mail = $row["Mail"];
            $create_note = $row["Create_note"];
            $Edit_note = $row["Edit_note"];
            $delete_note = $row["Delete_note"];
            $delete_everynote = $row["Delete_everynote"];
            $super_admin = $row["Super_admin"];
            
            $sql = "INSERT INTO user_history (Name, move, Time)
            Values('$current_user', 'login', '$time')";
            mysqli_query($link, $sql);  
                      
            setcookie("login_success", $login_success, $date);
            setcookie("current_user", $current_user, $date);
            setcookie("mail", $mail, $date);
            setcookie("Create_note", $create_note, $date);
            setcookie("Edit_note", $Edit_note, $date);
            setcookie("Delete_note", $delete_note, $date);
            setcookie("Delete_everynote", $delete_everynote, $date);
            setcookie("Super_admin", $super_admin, $date);
            $alert = "歡迎回來!";
            echo "<script type='text/javascript'>alert('$alert');</script>";        
            header("Location: welcome.php");
          }
        }
      }
    }  
  ?>
</head>
<body>
  <div class="flex">
    <form method="post" action="index.php">
      帳號(註冊信箱): <input type="text" name="mail" required><br>
      密碼: <input type="password" name="password" required>
      <input type="submit" name="send"><br>
      尚無帳號?  <button><a href="register.php">註冊</a></button>
    </form>  
  </div>
</body>
</html>