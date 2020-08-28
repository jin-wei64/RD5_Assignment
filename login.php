<?php
  session_start();
  if (isset($_GET["logout"]))
  {
    session_destroy();
    header("Location: login.php");
    exit();
  }
  require("config.php");
  $account = $_POST["Account"];
  $password= $_POST["password"];
  if(isset($_POST['login'])){
    $sqlAccount = <<<multi
    select userID, userName,userAccount, userPassword from users where userAccount = '$account' ;
    multi;
    $Accountresult = mysqli_query($link, $sqlAccount);
    $Accountrow = mysqli_fetch_assoc($Accountresult);
    if ($Accountrow["userAccount"] == $account && $Accountrow["userPassword"] == $password){
    $ID = $Accountrow["userID"] ; //session Account
    $_SESSION["userName"] = $Accountrow["userName"];
      header("location:index.php?id=$ID");
    }
    else {
      $a = "PassWord or Account is Error";
    } 
  }
  if(isset($_POST["registered"])){
    header("location:registered.php");
  }
?>
<script>
  if(<?= isset($_POST['login']) ?>)
    alert("<?= $a ?>")
</script>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<title>Lab - Login</title>
</head>
<body>
<form id="form1" name="form1" method="post" action="login.php">
  <table width="300" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#F2F2F2">
    <tr>
      <td colspan="2" align="center" bgcolor="#CCCCCC"><font color="#FFFFFF">會員系統 - 登入</font></td>
    </tr>
    <tr>
      <td width="80" align="center" valign="baseline">帳號</td>
      <td valign="baseline"><input type="text" name="Account" id="Account" /></td>
    </tr>
    <tr>
      <td width="80" align="center" valign="baseline">密碼</td>
      <td valign="baseline"><input type="password" name="password" id="password" /></td>
    </tr>
    <tr>
      <td colspan="2" align="center" bgcolor="#CCCCCC">
      <input class="btn btn-outline-info btn-md " type="submit" name="login" id="login" value="登入" />
      <input class="btn btn-outline-info btn-md " type="reset" name="btnReset" id="btnReset" value="重設" />
      <input class="btn btn-outline-info btn-md " type="submit" name="registered" id="registered" value="註冊" />
      </td>
    </tr>
  </table>
</form>
</body>
</html>