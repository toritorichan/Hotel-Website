<script type="text/javascript">
function cancel(){
  if (confirm('Really？您確認要退房嗎？')) {
    document.r_cancel.submit();
  } else {
    // Do nothing!
  }
}

</script>
<!DOCTYPE html>
<html lang="en">
  <head>
  <link rel="stylesheet" href="NOBUTTONdisplayStyle.css">
    <meta charset="UTF-8">
    <title>房間資料</title>
  </head> 
  <style>
      
  </style>
  <body>
<?php
  session_start();
  $customerID = $_SESSION["customerID"];
  $name = $_SESSION["name"];
  //echo $customerID;

  if (!isset($_SESSION["number"])){
    $_SESSION["number"] = "";
    $_SESSION["in_time"] = "";
    $_SESSION["out_time"] = "";
  }

    $db_host = 'localhost';
    $db_username = 'root';
    $db_password = '';
    $db_name = 'hotel';
    $db_link = mysqli_connect($db_host,$db_username,$db_password,$db_name) or die("die".mysql_error());
    //sqli_set_charset($db_link,"utf8");

    $select_db = mysqli_select_db($db_link,'hotel');
    // 建立SQL指令字串
    $sql = "SELECT 報表.報表ID,報表.房間ID,報表.客人ID,報表.清潔人員ID,報表.Check_in_時間,報表.Check_out_時間,房間.房型,房間.價格 FROM 報表,房間 WHERE 報表.房間ID=房間.房間ID AND 報表.客人ID='";
    $sql.= $customerID."' AND 報表.Check_out_時間>= NOW()";
    //echo $sql;

    // 執行SQL查詢
    $result = mysqli_query($db_link, $sql);
    $total_records = mysqli_num_rows($result);//取得資料筆數
    if ($total_records==null){
      echo '<div align=center><h1><font color= #FF7575>您目前還沒有訂房！<br>';
      echo '<a href="room_introduction.html" ><button>查看房型介紹</button></a></font></a></h1></div>';
      ?>
      <script type="text/javascript">
        alert("您目前還沒有訂房");
      </script>

  <div style="width:220px;height:210px;border:0px white dashed;position: absolute; vertical-align:middle; top:50%; left: 50%;margin: -210px 0 0 -110px;">
    <div style="position: absolute; bottom: 50px; top:80px; left:6px;">
      <form name="login" action="room_search.php" method="post">
      <table align="center" bgcolor="transparent" class="table" >
        <tr>
            <td><font size="2"><span style="color:red">*</span>入住時間:</font></td></tr><tr>
            <td><input type="datetime-local" name="in_time" required value="<?php echo $_SESSION["in_time"];?>" /></td>
        </tr>
        <tr>
            <td><font size="2"><span style="color:red">*</span>退房時間:</font></td></tr><tr>
            <td><input type="datetime-local" name="out_time" required value="<?php echo $_SESSION["out_time"];?>" /></td>
        </tr>
        <tr>
            <td><font size="2"><span style="color:red">*</span>幾人房:</font></td></tr><tr>
            <td><input type="text" name="number" required value="<?php echo $_SESSION["number"];?>" /></td>
        </tr>
        <tr>
             <td colspan="2" align="right" class="button"><input type="submit" value="查詢空房"></td>
        </tr>
      </table>
    </form></div></div>
<?php
    }else {
      $total_records = mysqli_num_rows($result);//取得資料筆數
      $row = mysqli_fetch_array($result, MYSQLI_NUM);
      $_SESSION["reportID"] = $row[0];
      $_SESSION["roomID"] = $row[1];
      $_SESSION["customerID"] = $row[2];
      $_SESSION["employeeID"] = $row[3];
      $in_time = str_replace(' ','T',$row[4]);
      $out_time = str_replace(' ','T',$row[5]);
      //echo $in_time;
      //echo $out_time;
      $_SESSION["in_time"] = $in_time;
      $_SESSION["out_time"] = $out_time;
      $_SESSION["room_type"] = $row[6];
      $_SESSION["price"] = $row[7];
    ?>

  <div style="width:400px;height:210px;border:0px white dashed;position: absolute; vertical-align:middle; top:50%; left: 50%;margin: -300px 0 0 -200px;">
    <div style="position: absolute; bottom: 50px; top:80px; left:6px;">
    <form name="r_cancel" action="room_cancel.php" method="post">
      <table align="center" bgcolor="transparent" class="table" >
        <tr>
            <td><font size="2"><span style="color:red">*</span>入住時間:</font></td></tr><tr>
            <td><input type="datetime-local" name="in_time" value="<?php echo $in_time;?>" /></td>
        </tr>
        <tr>
            <td><font size="2"><span style="color:red">*</span>退房時間:</font></td></tr><tr>
            <td><input type="datetime-local" name="out_time" value="<?php echo $out_time;?>" /></td>
        </tr>
        <tr>
            <td><font color="#FFC2CC">---♥---♩---♥---♩---♥---♩---♥---♩---</font></td>
        </tr>
        <tr>
          <td><font size="2" ><span style="color:red">*</span>客人ID:</font></td></tr><tr>
          <td width="100%"><input type="text" name="customerID" readonly value="<?php echo $_SESSION["customerID"];?>"><span></span></td>
        </tr>
        <tr>
          <td><font size="2" ><span style="color:red">*</span>客人姓名:</font></td></tr><tr>
          <td width="100%"><input type="text" name="name" readonly value="<?php echo $_SESSION["name"];?>"><span></span></td>
        </tr>
        <tr>
            <td><font size="2"><span style="color:red">*</span>房型:</font></td></tr><tr>
            <td width="100%"><input type="text" name="room_type" readonly value="<?php echo $_SESSION["room_type"].'人房';?>"><span></span></td>            
        </tr>
        <tr>
          <td><font size="2" ><span style="color:red">*</span>房間ID:</font></td></tr><tr>
          <td width="100%"><input type="text" name="roomID" readonly value="<?php echo $_SESSION["roomID"];?>"><span></span></td>
        </tr>
        <tr>
          <td><font size="2" ><span style="color:red">*</span>報表ID:</font></td></tr><tr>
          <td width="100%"><input type="text" name="reportID" value="<?php echo $_SESSION["reportID"];?>"><span></span></td>
        </tr>
        <tr>
          <td><font size="2" ><span style="color:red">*</span>價格：</font></td></tr><tr>
          <td width="100%"><input type="text" name="price" readonly value="<?php echo $_SESSION["price"];?>"><span></span></td>
        </tr>
        <tr>
          <td colspan="2" align="RIGHT" class="button"><a href="entrance.html"><button>返回首頁</a></td>
          <td colspan="2" align="RIGHT" class="button" ><input type="button" onclick="cancel()" value="取消訂房"></td>
        </tr>
      </table>
    </form></div></div>
  </body>
</html>
<?php
    }
    exit;
?>