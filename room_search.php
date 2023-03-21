<!DOCTYPE html>
<html lang="en">
  <head>
  <link rel="stylesheet" href="CDISstyle.css">
    <meta charset="UTF-8">
    <title>您訂的房間資料</title>
  </head>
  <body>
<?php
  session_start();
  $in_time = $_POST["in_time"];
  $in_time = str_replace('T',' ',$in_time);
  //echo $in_time;
  $out_time = $_POST["out_time"];
  $out_time = str_replace('T', ' ', $out_time);
  $number = $_POST["number"];
  
  $_SESSION["in_time"] = $_POST["in_time"];
  $_SESSION["out_time"] = $_POST["out_time"];
  $_SESSION["number"] = $_POST["number"];
  
    $db_link = mysqli_connect('localhost','root','','hotel') or die("die".mysql_error());
    $select_db = mysqli_select_db($db_link,'hotel');
    // 建立SQL指令字串
    $sql1 = "(SELECT 報表.房間ID FROM 報表,房間 WHERE 報表.房間ID = 房間.房間ID AND 報表.Check_out_時間>='";
    $sql1.= $in_time."'AND 報表.Check_out_時間 <='";
    $sql1.= $out_time."')";

    $sql2 = "(SELECT 報表.房間ID FROM 報表,房間 WHERE 報表.房間ID = 房間.房間ID AND 報表.Check_in_時間<='";
    $sql2.= $out_time."'AND 報表.Check_in_時間 >='";
    $sql2.= $in_time."')";

    $sql3 = "(SELECT 報表.房間ID FROM 報表,房間 WHERE 報表.房間ID = 房間.房間ID AND 報表.Check_in_時間<='";
    $sql3.= $in_time."'AND 報表.Check_out_時間 >='";
    $sql3.= $out_time."')";

    $sql = "SELECT DISTINCT 房間ID FROM 房間 WHERE 房型 LIKE '%";
    $sql.= $number."' AND 房間ID <> ALL".$sql1." AND 房間ID <> ALL".$sql2." AND 房間ID <> ALL".$sql3;

    //echo $sql;
    // 執行SQL查詢
    $result = mysqli_query($db_link, $sql);
    $total_records = mysqli_num_rows($result);//取得資料筆數

    //$row = mysqli_fetch_array($result, MYSQLI_NUM);
    if ($total_records==null){
      echo '<div align=center>'; 
      echo "<h2><font color= #FF7575>很抱歉，您輸入的這段期間沒有空房。<br></h2></font>";
      echo '<a href="room_status.php"><button>換個時段試試</a></button></h2></font></div>';
    }else {                
      ?>

  <div style="width:220px;height:210px;border:0px white dashed;position: absolute; vertical-align:middle; top:50%; left: 50%;margin: -300px 0 0 -110px;">
    <div style="position: absolute; bottom: 50px; top:80px; left:6px;">
      <form name="login" action="room_reservation.php" method="post">
      <table align="center" bgcolor="transparent" class="table" >
      <?php
      echo "<h2><font color= #FF7575>恭喜您，總共找到 ";
      echo $total_records;
      echo " 間空房：)<br></h2></font>";
      //echo $row[0];
      ?>
      <script type="text/javascript">alert("<?php echo '恭喜您，總共找到 '.$total_records.' 間空房';?>");</script>
        <tr>
            <td><font size="2"><span style="color:red">*</span>房型:</font></td></tr><tr>
            <td><select name="roomID" required>
                <?php
                while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                    //echo $row[0]."--";
                    
                    $sql_new = "SELECT 房間ID,房間名稱,價格,房型 FROM 房間 WHERE 房間ID='".$row[0]."'";
                    $r = mysqli_query($db_link, $sql_new);
                    $total_records_new = mysqli_num_rows($r);//取得資料筆數
                    $ro = mysqli_fetch_array($r, MYSQLI_NUM);                
                    if ($total_records_new!=null){
                    ?>
                        <option value="<?php echo $row[0];?>">
                            <?php echo $ro[3]." ".$ro[1]."  NT$".$ro[2];?>
                        </option>
                        <?php
                    }
                } 
                 ?>
                    <option value="取消">無</option>
            </select></td>
        </tr>
        <tr>
            <td><font size="2"><span style="color:red">*</span>入住時間:</font></td></tr><tr>
            <td><input type="datetime-local" name="in_time" readonly value="<?php echo $_SESSION["in_time"]?>" /></td>
        </tr>
        <tr>
            <td><font size="2"><span style="color:red">*</span>退房時間:</font></td></tr><tr>
            <td><input type="datetime-local" name="out_time" readonly value="<?php echo $_SESSION["out_time"]?>" /></td>
        </tr>
        <tr>
            <td><font size="2"><span style="color:red">*</span>幾人房:</font></td></tr><tr>
            <td><input type="text" name="number" readonly value="<?php echo $_SESSION["number"]."人房";?>" /></td>
        </tr>
        <tr>
          <td><font size="2" ><span style="color:red">*</span>客人ID:</font></td></tr><tr>
          <td width="70%"><input type="text" name="customerID" readonly value="<?php echo $_SESSION["customerID"]?>"><span></span></td>
        </tr>
        <tr>
          <td><font size="2" ><span style="color:red">*</span>客人姓名:</font></td></tr><tr>
          <td width="70%"><input type="text" name="name" readonly value="<?php echo $_SESSION["name"]?>"><span></span></td>
        </tr>
        <tr>
           <td colspan="2" align="RIGHT"><button><a href="room_status.php" class="btn btn-primary">取消，再查詢一次</a></button></td>
           <td colspan="2" align="right"><button><input type="submit" value="確認訂房"></button></td>
        </tr>
      </table>
    </form></div></div>
  </body>
</html>
<?php
    }
?>
