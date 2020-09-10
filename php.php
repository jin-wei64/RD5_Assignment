<?php
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
        echo json_encode($Accountrow);
    }
    if(isset($_POST['id'])){
        $array2 = [];
        $array3 = [];
        $array = [];
        $b = [];
        $userID = $_POST["id"];
        $timerecordsql = "select u.userName as name ,recordID,r.userID, money, time, total,type from record as r 
        JOIN users as u 
        on u.userID = r.userID where r.userID = '$userID' order by time desc";
        $timeresult = mysqli_query($link,$timerecordsql);
        $getName = "select * from users where userID = $userID " ;
        $getNamerow = mysqli_fetch_assoc(mysqli_query($link,$getName));
        $name = $getNamerow['userName'];
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
        $b[] = $array ;
        $b[] = $name;
        $b[] = $array2;
        $b[] = $array3;
        echo json_encode($b);
    }
    if(isset($_POST['saveMoney'])){
        $savemoney = $_POST["saveMoney"];
        $userID =$_POST['userID'];
        $timerecordsql = "select total from record where userID = '$userID' order by time desc";
        $timeresult = mysqli_query($link,$timerecordsql);
        $timerecord = mysqli_fetch_assoc($timeresult);
        $total = $timerecord['total'];
        $total += $savemoney ;  
        $saveSql = "insert into record (userID, money,total,type)values('$userID', '$savemoney','$total','In')";
        mysqli_query($link , $saveSql);
        echo "本次存款 : ".$savemoney."  "."剩餘：".$total;
    }
    if(isset($_POST["outMoney"])){
        $outmoney = $_POST["outMoney"];
        $userID =$_POST['userID'];
        $timerecordsql = "select total from record where userID = '$userID' order by time desc";
        $timeresult = mysqli_query($link,$timerecordsql);
        $timerecord = mysqli_fetch_assoc($timeresult);
        $total = $timerecord['total'];
        if ($total >= $outmoney) {
            $total -= $outmoney;
            $outSql = "insert into record (userID, money,total,type)values('$userID', '-$outmoney','$total','Out')";
            mysqli_query($link , $outSql);
            echo "本次提款 : ".$outmoney."  "."剩餘：".$total;
        }
        else{
            echo "餘額不足";
        }
    }
    if( isset($_POST['targetAccount']) && isset($_POST['transfer']) ){
        $transferMoney = $_POST['transfer'];
        $targetAccont = $_POST['targetAccount'];
        //Oneself start
        $userID =$_POST['userID'];
        $OneselfRecordsql = "select u.userAccount,total ,r.userID from record as r JOIN users as u on u.userID = r.userID where r.userID = '$userID' order by time desc";
        $OneselfRecord = mysqli_fetch_assoc(mysqli_query($link,$OneselfRecordsql));
        $OneselfRecordTotal = $OneselfRecord['total']; 
        if ($OneselfRecordTotal >= $transferMoney) {
            $OneselfRecordTotal -= $transferMoney;
            $typeOut = "To:".$targetAccont;
            $outSql = "insert into record (userID, money,total,type)values('$userID', '-$transferMoney','$OneselfRecordTotal','$typeOut')";
            //Oneself end
             //target start
            $targetSql = "select userID from users where userAccount = '$targetAccont' ; ";
            $targetRow = mysqli_fetch_assoc(mysqli_query($link,$targetSql));
            $targetUserID = $targetRow['userID'];
            $targetRecordsql = "select total from record where userID = '$targetUserID' order by time desc";
            $targetRecord = mysqli_fetch_assoc(mysqli_query($link,$targetRecordsql));
            $TargetTotal = $targetRecord['total'];
            $TargetTotal += $transferMoney ;
            $typeIn = "From:".$OneselfRecord['userAccount'];
            $transferSql = "insert into record (userID, money,total,type)values('$targetUserID', '$transferMoney','$TargetTotal','$typeIn')";
            mysqli_query($link , $outSql);
            mysqli_query($link , $transferSql);
            //target end
            echo "本次轉出 : ".$transferMoney."  "."剩餘：".$OneselfRecordTotal;
        }
        else{
            echo "餘額不足";
        }
     
    }

?>