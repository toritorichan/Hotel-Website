<?php
session_start();
    $reportID = $_POST["reportID"];

    $link = mysqli_connect("localhost","root","","hotel")
            or die("無法開啟MySQL資料庫連接!<br/>");
            //送出UTF8編碼的MySQL指令
    mysqli_query($link, 'SET NAMES utf8'); 

    $sql = "DELETE FROM 報表 WHERE 報表ID='".$reportID."'";

    if ($link->query($sql) === TRUE) {
      echo '<div align=center>'; 
      echo "<h1><font color= #FF7575>好的，我們已經幫您退房。<br>";
      echo "有任何問題歡迎來店客服：(06)0487087<br>";
      echo '<a href="room_status.php" >♥ 查看房間資訊 ♥</a><br>';
      echo '<a href="entrance.html" >♥ 回官網首頁 ♥</a></font></a></h1></div>';
      //header("Location: login.html");
    } else {
        echo "註冊失敗";
        echo "Error: " . $sql . "<br>" . $link->error;
    }
    $link->close();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
  <link rel="stylesheet" href="Cstyle.css">
    <meta charset="UTF-8">
    <title>取消成功囉！</title>
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