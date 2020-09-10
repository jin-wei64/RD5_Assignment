<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<title>VIEW</title>
</head>

<body>
<form method = "post">
<table width="350" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#F2F2F2">
  <tr>
    <td id = "titleID" align="center" bgcolor="#CCCCCC"><font id = "title" size="5" > </font>
      <a class="btn btn-outline-info btn-sm float-right " href="index.php">登出</a>
    </td>
  </tr>
  <tr>
    <td id = "td" align="center" >
    </td>
  </tr>
  <tr>
    <td align="center" bgcolor="#CCCCCC">
      <input id = "save" name = "save" type = "button" class="btn btn-outline-info btn-sm " value = "存款" >｜</input> 
      <input id = "out" name = "out" type = "button" class="btn btn-outline-info btn-sm " value = "提款" >｜</input> 
      <input id = "details" name = "details" type = "button" class="btn btn-outline-info btn-sm " value = "歷史明細" >｜</input> 
      <input id = "usermoney" name = "usermoney" type = "button" class="btn btn-outline-info btn-sm " value = "餘額" >｜</input> 
      <input id = "transfer" name = "transfer" type = "button" class="btn btn-outline-info btn-sm " value = "轉帳" ></input> 
    
    </td>
    
  </tr>
</table>
<!-- modal start -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Check ID</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <input placeholder = "帳號" id= "jj" type = "text">
          <input placeholder = "密碼" id= "gg" type = "text">
        </div>
        <div class="modal-footer">
          <button id = "hh" type="button" class="btn btn-default" >OK</button>
        </div>
      </div>
    </div>
</div>
<!-- modal end -->
</form>
</body>
</html>
<script>
let regular = /^[1-9]\d*|0$./;
$(document).ready(function(){
    
    var getUrlString = location.href;
    var url = new URL(getUrlString);
    let a = url.searchParams.get('id');
    let obj ;
    function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    $.ajax({
        url:"php.php",
        type:"post",
        data:{
            "id":a
        }
    }).then(function(e){
        obj = JSON.parse(e);
        $("#title").text("Welcome !" +" " +obj[0][0].name  )
        let total = function(){
            $("#td").empty();
            $("#month").remove();
            $("#week").remove();
            if(obj[0] == ""){
                $("#td").append(
                    $('<font id = "h3" size="6px"></font>').text("$"+ 0),
                    $('<input  style= " width:20px;height:20px "id="check" type="checkBox">')
                )
            }
            else{
                $("#td").append(
                    $('<font id = "h3" size="6px"></font>').text("$"+numberWithCommas(obj[0][0].total)),
                    $('<input  style= " width:20px;height:20px "id="check" type="checkBox">')
                )
            }
            $("#check").click(function(){
                var isChecked = $("#check").prop("checked")
                if(isChecked == true)
                    $("#h3").text("********");
                else{
                    if(obj[0]== ""){
                        $("#h3").text("$"+0);  
                    }else{
                        $("#h3").text("$"+numberWithCommas(obj[0][0].total));  
                    }
                }
                      
            })          
        }
        total();
        $("#usermoney").click(total);
        $("#details").click(function(){
            $("#td").empty();
            $("#month").remove();
            $("#week").remove();
            $("#tbody").empty();
            $("#titleID").append(
                $('<input id = "month" type = "button" name = "month" class="btn btn-outline-success btn-sm float-right " value = "Month">'),
                $('<input id = "week" type = "button" name = "week" class="btn btn-outline-danger btn-sm float-right" value = "Week">')
            )
            $("#td").append(
                $('<div style="width:600px;height:200px;overflow-y:scroll;overflow-x:none;"></div>').append(
                    $('<table class="table table-striped"></table>').append(
                        $("<thead></thead>").append(
                            $("<tr></tr>").append(
                                $("<th></th>").text("ID"),
                                $("<th></th>").text("金額"),
                                $("<th></th>").text("餘額"),
                                $("<th></th>").text("轉/領/存"),
                                $("<th></th>").text("日期"),
                            )
                        ),
                        $('<tbody id = "tbody"></tbody>')
                    )
                )
            )
            for(let i = 0;i<obj[0].length;i++){
                $("#tbody").append(
                    $("<tr></tr>").append(
                        $("<td></td>").text(obj[0][i].recordID),
                        $("<td></td>").text("$"+numberWithCommas(obj[0][i].money)),
                        $("<td></td>").text("$"+numberWithCommas(obj[0][i].total)),
                        $("<td></td>").text(obj[0][i].type),
                        $("<td></td>").text(obj[0][i].time)
                    )
                )
            }
            $("#month").click(function(){
                $("#tbody").empty();
                for(let i = 0;i<obj[2].length;i++){
                    $("#tbody").append(
                        $("<tr></tr>").append(
                            $("<td></td>").text(obj[2][i].recordID),
                            $("<td></td>").text("$"+numberWithCommas(obj[2][i].money)),
                            $("<td></td>").text("$"+numberWithCommas(obj[2][i].total)),
                            $("<td></td>").text(obj[2][i].type),
                            $("<td></td>").text(obj[2][i].time)
                        )
                    )
                }
            })
            $("#week").click(function(){
                $("#tbody").empty();
                for(let i = 0;i<obj[3].length;i++){
                    $("#tbody").append(
                        $("<tr></tr>").append(
                            $("<td></td>").text(obj[3][i].recordID),
                            $("<td></td>").text("$"+numberWithCommas(obj[3][i].money)),
                            $("<td></td>").text("$"+numberWithCommas(obj[3][i].total)),
                            $("<td></td>").text(obj[3][i].type),
                            $("<td></td>").text(obj[3][i].time)
                        )
                    )
                }
            })
            
        })

        
    })
    $("#save").click(function(){
        $("#td").empty();
        $("#week").remove();
        $("#month").remove();
        $("#td").append(
            $(`<input id = "saveText" type = "text" name = "savetext" pattern= ${/^[1-9]\d*|0$./} required >`),
            $('<button id ="saveBtn" class="btn btn-outline-success btn-sm " name = "savebtn">確認</button>')
        )
        $("#saveBtn").click(function(){
            if(regular.test($("#saveText").val())){   
                $.ajax({
                    url:"php.php",
                    type:"post",
                    data:{
                        "userID":a,
                        "saveMoney":`${$("#saveText").val()}`  
                    }
                }).then(function(e){
                    alert(e);
                    document.location.href=`view.php?id=${a}`;
                })
            }
        })
    })
    $("#out").click(function(){
        $("#td").empty();
        $("#week").remove();
        $("#month").remove();
        $("#td").append(
            $(`<input id = "outText" pattern= ${/^[1-9]\d*|0$./} type = "text" name = "outtext" required>`),
            $('<button id ="outBtn" class="btn btn-outline-dark btn-sm " name = "outbtn">確認</button>')
        )
        $("#outBtn").click(function(){
            if(regular.test($("#outText").val())){
                $.ajax({
                    url:"php.php",
                    type:"post",
                    data:{
                        "userID":a,
                        "outMoney":`${$("#outText").val()}`  
                    }
                }).then(function(e){           
                    alert(e);
                    document.location.href=`view.php?id=${a}`;
                })
            }
        })
    })
    $("#transfer").click(function(){
        regularAccount = /[a-zA-Z0-9]{6,}/;
        $("#td").empty();
        $("#week").remove();
        $("#month").remove();
        $("#td").append(
            $(`<input placeholder = "金額"class ="float-left"  id = "transferText" type = "text" name = "transferText" pattern= ${/^[1-9]\d*|0$./} required >`),
            $(`<input placeholder = "帳號"class ="float-left"  id = "transferAccount" type = "text" name = "transferAccount" pattern= ${/[a-zA-Z0-9]{6,}/} required >`),
            $('<button id ="transferBtn" class="btn btn-outline-success btn-sm float-right" name = "transferBtn">確認</button>')
        )
        $("#transferBtn").click(function(){
            if(regular.test($("#transferText").val())&&regularAccount.test($("#transferAccount").val()) ){ 
                $("#myModal").modal({backdrop:"static"})
                $("#hh").click(function(){
                    $.ajax({
                        url:"php.php",
                        type:"post",
                        data:{
                            "loginAccount":`${$("#jj").val()}`
                        }
                    }).then(function(e){
                        let obj = JSON.parse(e);
                        if(obj==null){
                            alert("帳號或密碼錯誤")
                        }
                        if(obj.userPassword == $("#gg").val()){
                            $.ajax({
                                url:"php.php",
                                type:"post",
                                data:{
                                    "userID":a,
                                    "targetAccount":`${$("#transferAccount").val()}`,
                                    "transfer":`${$("#transferText").val()}`
                                }
                            }).then(function(e){
                                alert(e);
                                document.location.href=`view.php?id=${a}`;
                            })
                        }
                        else{
                            alert("帳號或密碼錯誤")
                        }
                    })
                })
                
                
            }
        })
    })
})
    
</script>