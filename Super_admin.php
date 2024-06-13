<?php
  include("Login_check.php");
  if($_COOKIE["Super_admin"] != 1){
    $alert = "只有最高權限者才能使用此項功能!!!";
    echo "<script type='text/javascript'>alert('$alert'); location = 'welcome.php'</script>";
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Super_admin</title>
  <style>
    h3{
      text-align: center;
      display: flex;
      justify-content: center;
    }
    table{
      /* margin-left: auto;
      margin-right: auto; */
    }
    table, th, td{
      border: 1px solid black;
      border-collapse: collpase;
    }
    th, td{
      width: 2%;
    }
    #page_select{
      text-align:center;
    }
    #page_select a{
      font-size: 200%;
    }
  </style>
  <?php
    $link = mysqli_connect("localhost", "DB-User_name", "DB-User_password", "notes");
    $sql = "select * from user";
    $result = mysqli_query($link, $sql);
    $num = mysqli_num_rows($result);
    $total_fields = mysqli_num_fields($result); // the column number of the result
    $records_per_page = 10;
    $pages = ceil($num / $records_per_page);
  ?>
</head>
<body>
  <?php include_once("navbar.php"); ?>
    <h3>共有<?php echo $num;?>筆資料</h3><br>
    <table id="content">
      <tr>
        <th>Name</th>
        <th>Mail</th>
        <th>Password</th>
        <th>Create_note</th>
        <th>Edit_note</th>
        <th>Delete_note</th>
        <th>Super_admin</th>
      </tr>
      <?php
        if (isset($_GET["current_pages"]))  
          $current_pages = (int)$_GET["current_pages"];
        else                       
          $current_pages = 1;
        // The starting Subject, if current_pages is 2.
        // The starting number is 6.
        $offset = ($current_pages - 1) * $records_per_page;
        mysqli_data_seek($result, $offset);        
        $j = 1;
        echo "<tr>";
        while ($rows = mysqli_fetch_array($result, MYSQLI_NUM) and $j <= $records_per_page){
          for( $i = 0; $i< $total_fields; $i++)
            echo "<td>".$rows[$i]."</td>";
            $j++;
          echo "</tr>";         

        }
      ?>
    </table>
    <?php
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
      echo "</div>"
    ?>  
</body>
</html>