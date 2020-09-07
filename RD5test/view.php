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
<table width="300" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#F2F2F2">
  <tr>
    <td align="center" bgcolor="#CCCCCC"><font id = "title" size="5" > </font>
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
      <input id = "usermoney" name = "usermoney" type = "button" class="btn btn-outline-info btn-sm " value = "餘額" ></input> 
    
    </td>
    
  </tr>
</table>
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
    $.ajax({
        url:"php.php",
        type:"post",
        data:{
            "id":a
        }
    }).then(function(e){
        obj = JSON.parse(e);
        $("#title").text("Welcome")
        let total = function(){
            $("#td").empty();
            $("#td").append(
                $('<font id = "h3" size="6px"></font>').text("$"+obj[0].total),
                $('<input  style= " width:20px;height:20px "id="check" type="checkBox">')
            )
            $("#check").click(function(){
            var isChecked = $("#check").prop("checked")
            if(isChecked == true)
                $("#h3").text("********");
            else
                $("#h3").text("$"+obj[0].total);    
        })          
        }
        total();
        $("#usermoney").click(total);
        $("#details").click(function(){
            $("#td").empty();
            $("#td").append(
                $('<div style="width:500px;height:300px;overflow-y:scroll;overflow-x:none;"></div>').append(
                    $('<table class="table table-striped"></table>').append(
                        $("<thead></thead>").append(
                            $("<tr></tr>").append(
                                $("<th></th>").text("ID"),
                                $("<th></th>").text("金額"),
                                $("<th></th>").text("餘額"),
                                $("<th></th>").text("日期"),
                            )
                        ),
                        $('<thead id = "thead"></thead>')
                    )
                )
            )
            for(let i = 0;i<obj.length;i++){
                $("#thead").append(
                    $("<tr></tr>").append(
                        $("<td></td>").text(obj[i].recordID),
                        $("<td></td>").text(obj[i].money),
                        $("<td></td>").text(obj[i].total),
                        $("<td></td>").text(obj[i].time)
                    )
                )
            }
        })
        
    })
    $("#save").click(function(){
        $("#td").empty();
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
                        "outMoney":`${$("#outText").val()}`  
                    }
                }).then(function(e){           
                    alert(e);
                    document.location.href=`view.php?id=${a}`;
                })
            }
        })
    })
})
    
</script>