<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Note List</title>
  <link rel="stylesheet" type="text/css" href="Breakpoint.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <style>
    h3{
      margin-top: 5%;
      display: flex;
      justify-content: center;
    }
    table{
      margin-left: auto;
      margin-right: auto;
    }
    #content, th, td{
      border: 1px solid black;
    }
    th, td{
      width: 10%;
    }
    #page_select{
      text-align:center;
    }
    #page_select a{
      font-size: 200%;
    }
  </style>
  <!-- default mode -->
  <?php
    include("Login_check.php");

    $link = mysqli_connect('localhost', 'DB-User_name', 'DB-User_password', 'notes');
    if(!$link){
      $alert = "資料庫連接失敗!";
      echo "<script type='text/javascript'>alert('$alert');</script>";
      header("Loctaion: create_note.php");  
    }else{
      $sql = "select No, Subject, Editor, Create_Time, Views from note where Hide = 0";
      $result = mysqli_query($link, $sql);
    }

    if (!isset($_GET["mode"]))  
      $mode = "list";
    else                       
      $mode = $_GET["mode"];
  ?>
  <!--Judging the permission for editing and deleting -->
  <?php
    if($mode == "edit" && $_COOKIE["Edit_note"] != 1){
      $alert = "您尚無此項權限功能";
      echo "<script type='text/javascript'>alert('$alert'); location = 'welcome.php'</script>";
    }
  ?>
  <!-- mode:edit -->
  <?php
    if(isset($_POST["save"])){
      $no = $_GET["no"];
      $path = "Note/".$no.".txt";
      $user = $_COOKIE["current_user"];
      date_default_timezone_set('Asia/Taipei');
      $time = date("Y-m-d H:i:s");
      $subject = $_POST["subject"];
      $content = $_POST["content"];
      $file = fopen($path, "w");
      fwrite($file, $content);

      $sql1 = "UPDATE note SET Subject = '$subject', Last_time_edit = '$time' where no = '$no'";
      mysqli_query($link, $sql1);
      
      $sql2 = "INSERT INTO note_history (Subject, Name, Move, Time) 
      Values('$subject', '$user', 'edit', '$time')";
      mysqli_query($link, $sql2);

      $sql3 = "INSERT INTO user_history (Name, move, Time)
      Values('$user', 'edit-note', '$time')";
      mysqli_query($link, $sql3);

      $alert = "筆記修改成功!";
      echo "<script type='text/javascript'>alert('$alert');</script>"; 
    }
  ?>
  <!-- mode:del -->
  <?php
    if(isset($_POST["Yes"])){
      $no = $_GET["no"];
      $user = $_COOKIE["current_user"];
      date_default_timezone_set('Asia/Taipei');
      $time = date("Y-m-d H:i:s");
      $name = $_COOKIE["current_user"];
      $subject = $_GET["subject"];
      $move = 'delete';

      $sql1 = "UPDATE note SET Hide = 1 where No = $no";
      mysqli_query($link, $sql1);

      $sql2 = "INSERT INTO note_history (Subject, Name, Move, Time) 
      VALUES ('$subject', '$name', '$move','$time')";
      mysqli_query($link, $sql2);

      $sql3 = "INSERT INTO user_history (Name, move, Time)
      VALUES ('$name', '$move', '$time')";
      mysqli_query($link, $sql3); 
    }elseif(isset($_POST["No"])){
      header("Location: Note_list.php?mode=list");
    }  
  ?>
</head>
<body>
  <?php include_once("Navbar.php")?>
  <?php
    switch($mode){
      case "list":
        $num = mysqli_num_rows($result); // the number of subject from result
        $total_fields = mysqli_num_fields($result); // the column number of the result
        $records_per_page = 5;
        $pages = ceil($num / $records_per_page);
        if (isset($_GET["current_pages"]))  
          $current_pages = (int)$_GET["current_pages"];
        else                       
          $current_pages = 1;
        // The starting Subject, if current_pages is 2.
        // The starting number is 6.
        $offset = ($current_pages - 1) * $records_per_page;
        mysqli_data_seek($result, $offset);
        
        echo(
        "<h3>共有$num"."筆資料</h3><br>
        <form method='post' action='Note_list.php?mode=search'>
          <input type='text' name='subject' placeholder='今天想搜尋什麼'>
          <input type='submit' name='search'>
        </form>
        <table id='content'>
          <tr>
            <th>No</th>
            <th>Subject</th>
            <th>Editor</th>
            <th>Create_Time</th>
            <th>Views</th>
            <th>move</th>
          </tr>"
        );

        $j = 1;
        while ($rows = mysqli_fetch_array($result, MYSQLI_NUM) and $j <= $records_per_page){
          $user = $rows[2];
          echo "<tr>";
          for( $i = 0; $i<= $total_fields-1; $i++)
            echo "<td>".$rows[$i]."</td>";
          echo "<td><a href='Note_list.php?mode=read&no=".$rows[0]."'><b>Read</b> | ";
          if($_COOKIE["Edit_note"] == 1 && $user == $_COOKIE["current_user"])
            echo "<a href='Note_list.php?mode=edit&no=".$rows[0]."'><b>Edit</b></td>";
          echo "</tr>";   
          echo "</tr>";
          $j++;
        }      
        echo("</table>");
        echo "<div id='page_select'>";
        if($pages > 1)
          echo "<a href=\"Note_list.php?current_pages=1"."\">⇤  </a>";  
        if($current_pages - 1 >= 1){
          echo "<a href=\"Note_list.php?current_pages=".($current_pages-1)."\">  ☚  </a>";  
        }
        for($j = 1; $j <= $pages; $j++){
          echo "<a href=\"Note_list.php?current_pages=".$j."\">".$j." "."</a>";
        }
        if($current_pages + 1 <= $pages){
          echo "<a href=\"Note_list.php?current_pages=".($current_pages+1)."\">  ☛  </a>";  
        }
        if($pages > 1)
          echo "<a href=\"Note_list.php?current_pages=".($pages)."\">  ⇥</a>";  
        echo "</div>";
        break;
      case "read":
        $no = $_GET["no"];
        $name = $_COOKIE["current_user"];
        date_default_timezone_set('Asia/Taipei');
        $time = date("Y-m-d H:i:s");

        $sql1 = "select * from note where no = $no";
        $result = mysqli_query($link, $sql1);
        $result = mysqli_fetch_array($result);
        
        if($result["Hide"] == 1){
          $alert = "此項筆記已被刪除";
          echo "<script type='text/javascript'>alert('$alert'); location='Note_list.php'</script>";
        }

        $subject = $result["Subject"];
        $view = $result["Views"];
        $move = 'read';

        $sql2 = "INSERT INTO note_history (Subject, Name, Move, Time) 
        VALUES ('$subject', '$name', '$move', '$time')";
        mysqli_query($link, $sql2);

        $sql3 = "UPDATE note SET Views = $view+1 where no = '$no'";
        mysqli_query($link, $sql3);

        $sql4 = "INSERT INTO user_history (Name, move, Time)
        VALUES ('$name', '$move', '$time')";
        mysqli_query($link, $sql4);

        echo "<h3>$subject</h3>";
        $path = "Note/".$no.".txt";
        $file = fopen($path, "r");
        while(! feof($file)) {
          $line = fgets($file);
          echo $line. "<br>";
        }
        fclose($file);
        echo "<button><a href='Note_list.php?mode=list'>返回</a></button>";
        break;
      case "edit":
        $no = $_GET["no"];
        $sql = "select * from note where no = $no";
        $result = mysqli_query($link, $sql);
        $result = mysqli_fetch_array($result);
        $subject = $result["Subject"];
        $path = "Note/".$no.".txt";
        $file = fopen($path, 'r');
        echo "
          <form method='post' action='Note_list.php?no=$no'>
            Subject: <input type='text' name='subject' value='$subject'><br>
            content:<br>
            <textarea id='content' name='content' rows='10' cols='100'>";
            while(! feof($file)) {
              $line = fgets($file);
              echo $line;
            }
            fclose($file);    
            echo "
            </textarea><br>
            <input type='submit' name='save' value='儲存'>
            </form>
        ";
        if($_COOKIE["Delete_note"] == 1 && $_COOKIE["current_user"] == $user){
          echo "<form method='post' action='Note_list.php?mode=del&subject=$subject&no=$no'>
          <input type='submit' name='delete' value='刪除'>
          </form>";
        }
        break;
      case "del":
        $subject = $_GET["subject"];
        $no = $_GET["no"];

        $sql = "SELECT Editor from note where No = '$no'";
        $result = mysqli_query($link, $sql);
        $result = mysqli_fetch_array($result, MYSQLI_NUM);
        $editor = $result[0];

        if($mode == "del" && $_COOKIE["Delete_note"] != 1){
          $alert = "您尚無此項權限功能";
          echo "<script type='text/javascript'>alert('$alert'); location = 'welcome.php'</script>";
        }elseif($_COOKIE["current_user"] != $editor){
          $alert = "不能刪除別人的筆記";
          echo "<script type='text/javascript'>alert('$alert'); location =' Note_list.php'</script>";    
        }
        echo "
        <dialog open>
          <p>是否確定要刪除$subject";
        echo"這則筆記</p>
          <form method='post' action='Note_list.php?subject=$subject&no=$no'>
            <input type='submit' name='Yes' value='Yes'>
            <input type='submit' name='No' value='NO'>
          </form>
        </dialog>
        ";
        break;
      case "search":
        $subject = $_POST["subject"];
        $keyword = $subject.'%';
        $sql = "SELECT NO, Subject, Editor, Create_Time, Views 
        from note where Subject LIKE '$keyword'";
        $result = mysqli_query($link, $sql);
        $empty = mysqli_fetch_array($result);

        if(!$empty){
          echo "<p>查無關於$subject 的筆記";
        }else{
          $num = mysqli_num_rows($result); // the number of subject from result
          $total_fields = mysqli_num_fields($result); // the column number of the result
          $records_per_page = 5;
          $pages = ceil($num / $records_per_page);
          if (isset($_GET["current_pages"]))  
            $current_pages = (int)$_GET["current_pages"];
          else                       
            $current_pages = 1;
          // The starting Subject, if current_pages is 2.
          // The starting number is 6.
          $offset = ($current_pages - 1) * $records_per_page;
          mysqli_data_seek($result, $offset);
          
          echo(
          "<h3>關於$subject 共有$num"."筆資料</h3><br>
          <table id='content'>
            <tr>
              <th>No</th>
              <th>Subject</th>
              <th>Editor</th>
              <th>Create_Time</th>
              <th>Views</th>
              <th>move</th>
            </tr>"
          );
  
          $j = 1;
          while ($rows = mysqli_fetch_array($result, MYSQLI_NUM) and $j <= $records_per_page){
            echo "<tr>";
            for( $i = 0; $i<= $total_fields-1; $i++)
              // $no = 
              echo "<td>".$rows[$i]."</td>";
              echo "<td><a href='Note_list.php?mode=read&no=".$rows[0]."'>Read</a></td>";
              if($_COOKIE["Create_note"] == 1)
                echo "<a href='Note_list.php?mode=edit&no=".$rows[0]."'>|Edit</a></td>";
              echo "</tr>";   
              echo "</tr>";
              $j++;
          }      
          echo("</table>");
          echo "<div id='page_select'>";
          if($pages > 1)
            echo "<a href=\"Note_list.php?current_pages=1"."\">⇤  </a>";  
          if($current_pages - 1 >= 1){
            echo "<a href=\"Note_list.php?current_pages=".($current_pages-1)."\">  ☚  </a>";  
          }
          for($j = 1; $j <= $pages; $j++){
            echo "<a href=\"Note_list.php?current_pages=".$j."\">".$j." "."</a>";
          }
          if($current_pages + 1 <= $pages){
            echo "<a href=\"Note_list.php?current_pages=".($current_pages+1)."\">  ☛  </a>";  
          }
          if($pages > 1)
            echo "<a href=\"Note_list.php?current_pages=".($pages)."\">  ⇥</a>";  
          echo "</div>";
          echo "<button><a href='Note_list.php?mode=list'>返回</a></button>";  
        }
        break;
    }
  ?>
</body>
</html>