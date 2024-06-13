<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="Breakpoint.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <title>Let's create a new note</title>
  <style>
    #note{
      text-align: center;
      margin-top: 5%;
    }
    #subject{
      margin-bottom: 30px;
    }
    #content{
      margin: 0;
    }
  </style>
  <?php
    include("Login_check.php");
    if(!isset($_COOKIE["Create_note"])){
      $alert = "請先登入再新增筆記!";
      echo "<script type='text/javascript'>alert('$alert'); location.href = 'index.php'</script>"; 
    }elseif($_COOKIE["Create_note"] != 1){
      $alert = "您尚無此項權限!";
      echo "<script type='text/javascript'>alert('$alert'); location.href = 'welcome.php'</script>";
    }
  ?>
  <?php
    if(isset($_POST["send"])){
      //connect to database
      $link = @mysqli_connect('localhost', 'DB-User_name', 'DB-User_password', 'notes');
      if(!$link){
        $alert = "資料庫連接失敗!";
        echo "<script type='text/javascript'>alert('$alert');</script>"; 
      }else{
        $subject = $_POST["subject"];

        $valid = "select * from note where Subject= '$subject'";
        $result = mysqli_query($link, $valid);
        $result = mysqli_fetch_array($result);
        if(!$result){
          //Open a new file and write.
          $Max_no = "Select max(no) from note";
          $max_no = mysqli_query($link, $Max_no);
          $row = mysqli_fetch_array($max_no);
          $no = $row[0] + 1;
          $path = "Note\\";
          $filename = $no.".txt";
          $path = $path.$filename;
          $file = fopen($path, "w");
          $content = $_POST["content"];
          fwrite($file, $content);

          //Insert a new data to database
          $user = $_COOKIE["current_user"];
          date_default_timezone_set('Asia/Taipei');
          $time = date("Y-m-d H:i:s");
          $move = "create";
          $sql1 = "INSERT INTO note (No, Subject, Editor, Create_Time, Hide, Last_time_edit, Views) 
          VALUES ('$no', '$subject', '$user', '$time', 0, '$time', 1)";
          mysqli_query($link, $sql1);
          
          $sql2 = "INSERT INTO note_history (Subject, Name, Move, Time) 
          Values('$subject', '$user', '$move', '$time')";
          mysqli_query($link, $sql2);

          $sql3 = "INSERT INTO user_history (Name, move, Time)
          Values('$user', '$move', '$time')";
          mysqli_query($link, $sql3);

          $alert = "筆記新增成功!";
          echo "<script type='text/javascript'>alert('$alert');</script>"; 
        }else{
          $alert = "筆記主題重複!";
          echo "<script type='text/javascript'>alert('$alert');</script>"; 
        }
      }
    }
  ?>
</head>
<body>
  <?php include_once("Navbar.php")?>
  <form method="post" action="create_note.php" id="note">
    Subject<br>
    <input id="subject" type="text" name="subject" required><br>
    Content<br>
    <textarea id="content" name="content" rows="10" cols="100"></textarea><br>
    <input type="submit" name="send">
  </form>
</body>
</html>