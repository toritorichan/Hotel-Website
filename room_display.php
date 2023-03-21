<?php
session_start();
  $email = $_POST["email"];
  $password = $_POST["password"];

if ($email!="" && $password!="") {//這邊先設定不能讓使用者輸入空值
    $db_host = 'localhost';
    $db_username = 'root';
    $db_password = '';
    $db_name = 'hotel';
    $db_link = mysqli_connect($db_host,$db_username,$db_password,$db_name) or die("die".mysql_error());
    //sqli_set_charset($db_link,"utf8");

  $select_db = mysqli_select_db($db_link,'hotel');
  // 建立SQL指令字串
    $sql = "SELECT * FROM 客人 WHERE email='";
    $sql.= $email."' AND 密碼='".$password."'";

    // 執行SQL查詢
    $result = mysqli_query($db_link, $sql);
    $total_records = mysqli_num_rows($result);//取得資料筆數
    $row = mysqli_fetch_array($result, MYSQLI_NUM);
    if ($total_records==null){
      echo "登入失敗，請確認帳號密碼是否填寫正確<br>";
      echo '<a href="room_login.html">再試一次</a>';
    }else {
      $_SESSION["customerID"] = $row[0];
      $_SESSION["password"] = $row[1];
      $_SESSION["name"] = $row[2];
      $_SESSION["birth"] = $row[3];
      $_SESSION["sex"] = $row[4];
      $_SESSION["address"] = $row[5];
      $_SESSION["tel"] = $row[6];
      $_SESSION["em_name"] = $row[7];
      $_SESSION["em_tel"] = $row[8];
      $_SESSION["email"] = $row[9];
        /*
        echo "登入成功";
      echo $row[0];
      echo $row[1];
      echo $row[2];
      echo $row[3];
      echo $row[4];
      echo $row[5];
      */
      //header("Location: room_display.html");
        ?>
<!DOCTYPE html>
<html lang="en">
  <head>
  <link rel="stylesheet" href="CDISstyle.css">
    <meta charset="UTF-8">
    <title>客人資料</title>
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
    <form name="login" action="room_update.php" method="post">
      <table align="center" bgcolor="transparent" class="table">
            <tr>
                <td><font size="2"><span style="color:red">*</span>客人ID:</font></td></tr><tr>
                <td><input type="text" name="customerID" size="30" readonly value="<?php echo $row[0] ?>" /></td>
            </tr>
            <tr>
                <td><font size="2"><span style="color:red">*</span>Email(帳號):</font></td></tr><tr>
                <td><input type="text" name="email" size="30" required value="<?php echo $row[9] ?>" /></td>
            </tr>
            <tr>
                <td><font size="2"><span style="color:red">*</span>密碼:</font></td></tr><tr>
                <td><input type="password" name="password" size="15" required value="<?php echo $row[1] ?>" /></td>
            </tr>
            <tr>
                <td><font size="2"><span style="color:red">*</span>姓名:</font></td></tr><tr>
                <td><input type="text" name="name" size="15" required value="<?php echo $row[2] ?>" /></td>
            </tr>
            <tr>
                <td><font size="2"><span style="color:red">*</span>生日:</font></td></tr><tr>
                <td><input type="date" name="birth" size="15" required value="<?php echo $row[3] ?>" /></td>
            </tr>
            <tr>
                <td><font size="2"><span style="color:red">*</span>性別:</font></td></tr><tr>
                <td><input type="text" name="sex" value="<?php echo $row[4] ?>" readonly/>
            </tr>
            <tr>
                <td><font size="2"><span style="color:red">*</span>住址:</font></td></tr><tr>
                <td><input type="text" name="address" size="50" required value="<?php echo $row[5] ?>" /></td>
            </tr>
            <tr>
                <td><font size="2"><span style="color:red">*</span>電話:</font></td></tr><tr>
                <td><input type="text" name="phone" size="15" required value="<?php echo $row[6] ?>" /></td>
            </tr>
            <tr>
                <td><font size="2"><span style="color:red">*</span>緊急聯絡人姓名:</font></td></tr><tr>
                <td><input type="text" name="contact_name" size="15" required value="<?php echo $row[7] ?>" /></td>
            </tr>
            <tr>
                <td><font size="2"><span style="color:red">*</span>緊急聯絡人電話:</font></td></tr><tr>
                <td><input type="text" name="contact_phone" size="15" required value="<?php echo $row[8] ?>" /></td>
            </tr>
            <tr>
                 <td colspan="2" ><div align="right" ><button><input type="submit" value="更新個資"/></button></td></div>
                <td colspan="2" ><div align="right" ><button><input type="submit" value="訂房資料" onclick='this.form.action="room_status.php"' /></button></td></div>
            </tr>        
      </table>
    </form></div></div>
  </body>
</html>
<?php
    }
    exit;
  }  
  else {  // 登入失敗
          echo "<center><font color='red'>";
          echo "使用者名稱或密碼不得為空!<br/>";
          echo "</font>";
  }
?>