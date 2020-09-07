<?php
    session_start();
    require("config.php");
    if(isset($_POST["account"])){
        $regeisteredAccount = $_POST["account"];
        $regeisteredPassword = $_POST["password"];
        $regeisteredName = $_POST["name"];
        $sql = "                     
        insert into users(userAccount,userPassword,userName) 
        values('$regeisteredAccount','$regeisteredPassword','$regeisteredName')
        ";
        mysqli_query($link, $sql);
        echo "註冊成功";
    }
    if(isset($_POST['loginAccount'])){
        $loginAccount = $_POST['loginAccount'];
        $sqlAccount = <<<multi
        select userID, userName,userAccount, userPassword from users where userAccount = '$loginAccount' ;
        multi;
        $Accountresult = mysqli_query($link, $sqlAccount);
        $Accountrow = mysqli_fetch_assoc($Accountresult);
        echo json_encode($Accountrow);
    }
    if(isset($_POST['id'])){
        $array = [];
        $_SESSION["id"] = $_POST["id"];
        $userID = $_SESSION["id"] ;
        $timerecordsql = "select recordID,userID, money, time, total from record where userID = '$userID' order by time desc";
        $timeresult = mysqli_query($link,$timerecordsql);
        while($timerecord = mysqli_fetch_assoc($timeresult )){
            $array[] = $timerecord;
        }
        $_SESSION['total'] = $array[0]["total"];
        echo json_encode($array);
    }
    if(isset($_POST['saveMoney'])){
        $savemoney = $_POST["saveMoney"];
        $userID = $_SESSION["id"];
        $total = $_SESSION['total'];
        $total += $savemoney ;  
        $saveSql = "insert into record (userID, money,total)values('$userID', '$savemoney','$total')";
        mysqli_query($link , $saveSql);
        echo "本次存款 : ".$savemoney."  "."剩餘：".$total;
    }
    if(isset($_POST["outMoney"])){
        $outmoney = $_POST["outMoney"];
        $total = $_SESSION['total'];
        $userID = $_SESSION["id"];
        if ($total >= $outmoney) {
            $total -= $outmoney;
            $outSql = "insert into record (userID, money,total)values('$userID', '-$outmoney','$total')";
            mysqli_query($link , $outSql);
            echo "本次提款 : ".$outmoney."  "."剩餘：".$total;
        }
        else{
            echo "餘額不足";
        }
    }

?>