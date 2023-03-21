<?php
session_start();
  $employeeID = $_POST["employeeID"];
  $password = $_POST["password"];

    $db_host = 'localhost';
    $db_username = 'root';
    $db_password = '';
    $db_name = 'hotel';
    $db_link = mysqli_connect($db_host,$db_username,$db_password,$db_name) or die("die".mysql_error());
    //sqli_set_charset($db_link,"utf8");

  $select_db = mysqli_select_db($db_link,'hotel');
  // 建立SQL指令字串
    $sql = "SELECT * FROM 員工 WHERE 員工ID='";
    $sql.= $employeeID."' AND 密碼='".$password."'";

    // 執行SQL查詢
    $result = mysqli_query($db_link, $sql);
    $total_records = mysqli_num_rows($result);//取得資料筆數
    $row = mysqli_fetch_array($result, MYSQLI_NUM);
    if ($total_records==null){
      echo '<div align=center>'; 
      echo "<h1><font color= #FF7575>登入失敗，請確認帳號密碼是否填寫正確<br>";
      echo '<a href="employee_login.html">♥ 再試一次 ♥</a></font></a></h1></div>';
    }else {
      $_SESSION["employeeID"] = $row[0];
      $_SESSION["name"] = $row[1];
      $_SESSION["birth"] = $row[2];
      $_SESSION["sex"] = $row[3];
      $_SESSION["address"] = $row[4];
      $_SESSION["tel"] = $row[5];
      $_SESSION["班別"] = $row[6];
      $_SESSION["department"] = $row[7];
      $_SESSION["position"] = $row[8];  
      $_SESSION["password"] = $row[9];
        ?>
<!DOCTYPE html>
<html lang="en">
  <head>
  <link rel="stylesheet" href="DISstyle.css">
    <meta charset="UTF-8">
    <title>員工個資</title>
  </head>
  <body>    
<div id="navigation" class="slide-right" style="position: absolute; top: 100px; left:0px;">
        <h2 align="center"><font color= #FF7575 >目錄</font></h2>
    <ul class="sidebar-nav">
        <li class="borderFade"><a href="entrance.html">回首頁</a></li>
        <li class="borderFade"><a href="room_introduction.html">房型介紹</a></li>
        <li class="borderFade"><a href="room_register.html">訪客註冊</a></li>
        <li class="borderFade"><a href="room_login.html">客人登入</a></li>
        <li class="borderFade"><a href="employee_login.html">員工登入</a></li>
        <li class="borderFade"><a href="logout.php">帳號登出</a></li>
    </ul></div>
 
  <div class="slide-right" style="width:225px;height:100px;border:0px white dashed;position: absolute; top: 0px; right:450px;">
    <div style="position: absolute; bottom: 50px; top:80px; left:6px;">   
    <form name="login" action="employee_display_update.php" method="post">
      <table align="center" bgcolor="transparent" class="table" >
        <tr>
            <td><font size="2" ><span style="color:red">*</span>員工ID:</font></td></tr><tr>
            <td><input type="text" name="employeeID" size="15" readonly value="<?php echo $_SESSION["employeeID"];?>" /></td>
        </tr>
        <tr>
            <td><font size="2"><span style="color:red">*</span>員工姓名:</font></td></tr><tr>
            <td><input type="text" name="name" size="15" required value="<?php echo $_SESSION["name"];?>"/></td>
        </tr>
        <tr>
            <td><font size="2"><span style="color:red">*</span>生日:</font></td></tr><tr>
            <td><input type="date" name="birth" readonly value="<?php echo str_replace(' ','T',$_SESSION["birth"]);?>" /></td>
        </tr>
        <tr>
            <td><font size="2"><span style="color:red">*</span>性別:</font></td></tr><tr>
            <td><input type="text" name="sex" value="male" readonly value="<?php echo $_SESSION["employeeID"];?>"/>
        </tr>
        <tr>
            <td><font size="2"><span style="color:red">*</span>住家地址:</font></td></tr><tr>
            <td><input type="text" name="address" size="35" required value="<?php echo $_SESSION["address"];?>"/></td>
        </tr>
        <tr>
            <td><font size="2"><span style="color:red">*</span>電話:</font></td></tr><tr>
            <td><input type="text" name="phone" size="15" required value="<?php echo $_SESSION["tel"];?>"/></td>
        </tr>
        <tr>
            <td><font size="2"><span style="color:red">*</span>班別:</font></td></tr><tr>
            <td><input type="text" name="shift" size="15" readonly value="<?php echo $_SESSION["班別"];?>"/></td>
        </tr>
        <tr>
            <td><font size="2"><span style="color:red">*</span>部門:</font></td></tr><tr>
            <td><input type="text" name="department" size="15" readonly value="<?php echo $_SESSION["department"];?>"/></td>
        </tr>
        <tr>
            <td><font size="2"><span style="color:red">*</span>職位:</font></td></tr><tr>
            <td><input type="text" name="position" size="15" readonly value="<?php echo $_SESSION["position"];?>"/></td>
        </tr>
        <tr>
            <td><font size="2"><span style="color:red">*</span>密碼:</font></td></tr><tr>
            <td><input type="password" name="password" size="15" required value="<?php echo $_SESSION["password"];?>"/></td>
        </tr><tr>

          <td colspan="2"><div align="right"><button><a href="logout.php">登出帳號</a></button></td>
           <td colspan="2"><div align="right"><button><input type="submit" value="修改資料"></button></td>
        </tr>
      </table>
    </form></div></div>
  </body>
</html>
<?php
}
?>