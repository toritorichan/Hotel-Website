<?php
session_start();
    $in_time = $_POST["in_time"];
    $out_time = $_POST["out_time"];
    $number = $_SESSION["number"];
    $customerID = $_SESSION["customerID"];
    $roomID = $_POST["roomID"];
    
    $link = mysqli_connect("localhost","root","","hotel")
            or die("無法開啟MySQL資料庫連接!<br/>");
            //送出UTF8編碼的MySQL指令
    mysqli_query($link, 'SET NAMES utf8'); 

    $sql = "INSERT INTO 報表 (房間ID, 客人ID, Check_in_時間, Check_out_時間)
    VALUES ('$roomID', '$customerID', '$in_time', '$out_time')";

    if ($link->query($sql) === TRUE) {
      echo '<div align=center>'; 
      echo "<h1><font color= #FF7575>恭喜您，訂房成功囉！<br>";
      echo '<a href="room_status.php" >♥ 查看訂房資訊 ♥</a></font></a></h1></div>';
      //header("Location: login.html");
    } else {
        echo '<div align=center>'; 
        echo "<h1><font color= #FF7575>訂房失敗</h1></div>";
        echo "Error: " . $sql . "<br>" . $link->error;
    }
    $link->close();
?>

<html lang="en">
  <head>
  <link rel="stylesheet" href="CDISstyle.css">
    <meta charset="UTF-8">
    <title>訪客訂房</title>
  </head>
  <style>
        a{
            font-size: 16px;
            color:#FF7575;
            text-decoration:none;

        }
        a:hover{
            color:hsl(350, 100%, 88%);
        }
  </style>
   <body>

   </body>
   </html>