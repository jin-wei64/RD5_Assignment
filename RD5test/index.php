<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>登入</title>
</head>
<body>
<form id="form1" name="form1" method="post" >
  <table width="300" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#F2F2F2" id = "table">
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
    <tr id = "tr">
      <td colspan="2" align="center" bgcolor="#CCCCCC">
      <input class="btn btn-outline-info btn-md " type="button" name="login" id="login" value="登入" />
      <input class="btn btn-outline-info btn-md " type="reset" name="btnReset" id="btnReset" value="重設" />
      <a href = "registered.php" class="btn btn-outline-info btn-md " type="submit" name="registered" id="registered">註冊</a>
      </td>
    </tr>
  </table>
</form>
</body>
</html>
<script>
$(document).ready(function(){
  $("#login").click(function(){
    $.ajax({
      url:"php.php",
      data:{
        "loginAccount":$("#Account").val()
      },
      type:"post"
    }).then(function(e){
      let obj = JSON.parse(e);
      if(obj==null){
        alert("帳號或密碼錯誤")
      }
      if(obj.userPassword == $("#password").val()){
        document.location.href=`view.php?id=${obj.userID}`
      }
      else{
        alert("帳號或密碼錯誤")
      }
    })
    
  })
})
</script>