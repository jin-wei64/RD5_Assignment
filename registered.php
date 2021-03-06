<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<title>Lab - registered</title>
</head>
<body>
<form id="form1" name="form1" method="post" >
  <table width="300" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#F2F2F2">
    <tr>
      <td colspan="2" align="center" bgcolor="#CCCCCC"><font color="#FFFFFF">註冊頁面</font></td>
    </tr>
    <tr>
      <td width="80" align="center" valign="baseline">帳號</td>
      <td valign="baseline"><input  pattern= "[a-zA-Z0-9]{6,}" placeholder="6~12個英文或數字" type="text" name="userAccount" id="Account" required /></td>
    </tr>
    <tr>
      <td width="80" align="center" valign="baseline">密碼</td>
      <td valign="baseline"><input pattern= "[a-zA-Z0-9]{6,}" placeholder="6~12個英文或數字"  type="password" name="userPassword" id="password" required /></td>
    </tr>
    <tr>
      <td width="80" align="center" valign="baseline">姓名</td>
      <td valign="baseline"><input type="text" name="userName" id="Name" required /></td>
    </tr>
    <tr>
      <td colspan="2" align="center" bgcolor="#CCCCCC">
        <input class="btn btn-outline-info btn-md " type="button" name="login" id="login" value ="登入頁" />
        <input class="btn btn-outline-info btn-md " type="reset" name="btnReset" id="btnReset" value="重設" />
        <input class="btn btn-outline-info btn-md " type="submit" name="registerBtn" id="registerBtn" value="確認" />
      </td>
    </tr>
  </table>
</form>
</body>
</html>
<script>
let regular = /[a-zA-Z0-9]{6,}/;
$(document).ready(function(){
  $("#registerBtn").click(function(){
    if(regular.test($("#account").val())&& regular.test($("#password").val())&& $("#Name").val()!=""){
      $.ajax({
        url:"php.php",
        data:{
          "account":$("#Account").val(),
          "password":$("#password").val(),
          "name":$("#Name").val()
        },
        type:"post"
      }).then(function(e){
        alert(e);
        document.location.href="index.php";
      })
    }
    
  })
  $("#login").click(function(){
    document.location.href="index.php";
  })


})

</script>