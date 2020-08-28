<?php 
session_start();
require("config.php");
$userID = $_GET["id"];
$toatlSql = "select userID, money, time, total from record where userID = '$userID' order by time desc";
$totalMoney = mysqli_fetch_assoc(mysqli_query($link,$toatlSql));
$total = $totalMoney['total'];
if (isset($_SESSION["userName"]))
  $userName =$_SESSION["userName"];
if(isset($_POST["savebtn"])){
  $savemoney = $_POST["savetext"];
  $total += $savemoney ;  
  $saveSql = "insert into record (userID, money,total)values('$userID', '$savemoney','$total')";
  mysqli_query($link , $saveSql);
}
if(isset($_POST["outbtn"])){
  $outmoney = $_POST["outtext"];
  $_SESSION["total"] = $total ;
  if ($total > $outmoney) {
    $total -= $outmoney;
    $outSql = "insert into record (userID, money,total)values('$userID', '-$outmoney','$total')";
    mysqli_query($link , $outSql);
  }
}
$timerecordsql = "select recordID,userID, money, time, total from record where userID = '$userID' order by time desc";
$timeresult = mysqli_query($link,$timerecordsql);


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<title>Lab - index</title>
</head>
<body>
<form method = "post">
<table width="300" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#F2F2F2">
  <tr>
    <td align="center" bgcolor="#CCCCCC"><font size="5" ><?= "Welcome! " . $userName ?> </font>
      <a class="btn btn-outline-info btn-sm float-right " href="login.php?logout=1">登出</a>
    </td>
  </tr>
  <tr>
    <td align="center" >
      <?php if(isset($_POST["save"])) { ?>
              <input pattern= "^[1-9]\d*|0$." type = "text" name = "savetext">
              <button class="btn btn-outline-success btn-sm " name = "savebtn">確認</button> 
      <?php } elseif (isset($_POST["out"])) { ?>
              <input pattern= "^[1-9]\d*|0$." type = "text" name = "outtext">
              <button class="btn btn-outline-dark btn-sm " name = "outbtn">確認</button> 
      <?php } elseif (isset($_POST["details"])) { ?>
        <table class="table table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>金額</th>
            <th>餘額</th>
            <th>日期</th>
          </tr>
        </thead>
        <tbody>
          <?php while ( $timerecord = mysqli_fetch_assoc($timeresult )) { ?>
            <tr>
              <td><?= $timerecord["recordID"] ?></td>
              <td><?= $timerecord["money"] ?></td>
              <td><?= $timerecord["total"] ?></td>
              <td><?= $timerecord["time"] ?></td>
            </tr>
          <?php } ?>
        </tbody>
        </table>
      <?php } else { ?>
            <h3>$<?= $total ?>&nbsp<input  type="checkbox"></h3>
      <?php } ?>
    </td>
  </tr>
  <tr>
    <td align="center" bgcolor="#CCCCCC">
    
      <input name = "save" type = "submit" class="btn btn-outline-info btn-sm " value = "存款" >｜</input> 
      <input name = "out" type = "submit" class="btn btn-outline-info btn-sm " value = "提款" >｜</input> 
      <input name = "details" type = "submit" class="btn btn-outline-info btn-sm " value = "歷史明細" >｜</input> 
      <input name = "usermoney" type = "submit" class="btn btn-outline-info btn-sm " value = "餘額" ></input> 
    
    </td>
    
  </tr>
</table>
</form>

</body>
<script>
if('<?=isset($_POST["outbtn"])?>'){
  if('<?= $_SESSION["total"] >= $outmoney ?>') {
    alert("本次提款金額：<?= $outmoney  ?>"+",餘額：<?= $total ?>" );    
  }
  if('<?= $_SESSION["total"] < $outmoney  ?>') {
    alert("餘額不足");
  }
}
if('<?= isset($_POST["savebtn"])?>'){
  alert("本次存款金額：<?= $savemoney ?>"+",餘額：<?= $total ?>" );
}
</script>
</html>