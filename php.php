<?php
    session_start();
    require("config.php");
    if(isset($_POST["account"])){
        $regeisteredAccount = $_POST["account"];
        $check = "select userAccount from users where userAccount = '$regeisteredAccount' ";
        $checkrow = mysqli_query($link, $check);
        $a = mysqli_fetch_assoc($checkrow);
        if ( $a!= null){
            echo "已有此帳號";
        }else{
            $regeisteredPassword = $_POST["password"];
            $regeisteredName = $_POST["name"];
            $sql = "                     
            insert into users(userAccount,userPassword,userName) 
            values('$regeisteredAccount','$regeisteredPassword','$regeisteredName')
            ";
            mysqli_query($link, $sql);
            echo "註冊成功";
        }
    }
    if(isset($_POST['loginAccount'])){
        $loginAccount = $_POST['loginAccount'];
        $sqlAccount = <<<multi
        select userID, userName,userAccount, userPassword from users where userAccount = '$loginAccount' ;
        multi;
        $Accountresult = mysqli_query($link, $sqlAccount);
        $Accountrow = mysqli_fetch_assoc($Accountresult);
        $_SESSION['name'] = $Accountrow['userName'];
        echo json_encode($Accountrow);
    }
    if(isset($_POST['id'])){
        $array2 = [];
        $array3 = [];
        $array = [];
        $b = [];
        $_SESSION["id"] = $_POST["id"];
        $userID = $_SESSION["id"] ;
        $timerecordsql = "select u.userName as name ,recordID,r.userID, money, time, total from record as r 
        JOIN users as u 
        on u.userID = r.userID where r.userID = '$userID' order by time desc";
        $timeresult = mysqli_query($link,$timerecordsql);
        while($timerecord = mysqli_fetch_assoc($timeresult )){
            $array[] = $timerecord;
        }
        $monthrecordsql = "select * from record where date(`time`) BETWEEN date_sub(curdate(),interval 30 day) and date_sub(curdate(),interval 0 day) and userID =  $userID order by time desc";
        $monthresult = mysqli_query($link,$monthrecordsql);
        while($monthrecord = mysqli_fetch_assoc($monthresult )){
            $array2[] = $monthrecord;
        }
        $weekrecordsql = "select * from record where date(`time`) BETWEEN date_sub(curdate(),interval 7 day) and date_sub(curdate(),interval 0 day) and userID =  $userID order by time desc";
        $weekresult = mysqli_query($link,$weekrecordsql);
        while($weekrecord = mysqli_fetch_assoc($weekresult )){
            $array3[] = $weekrecord;
        }
        $_SESSION['total'] = $array[0]["total"];
        $name = $_SESSION['name'];
        $b[] = $array ;
        $b[] = $name;
        $b[] = $array2;
        $b[] = $array3;
        echo json_encode($b);
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