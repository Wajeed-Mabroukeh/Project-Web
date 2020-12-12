<?php

if(isset($_GET['vkey'])){
    $vkey = $_GET['vkey'];


    @$db = new mysqli('localhost','root','','funtime');
    if(mysqli_connect_errno()){
        header('location: ERROR.php');
        die();
    }
    else {

        $srtQuery = "select verified,vkey from users where verified = 0 AND vkey = '$vkey' LIMIT 1";
        $result = $db -> query($srtQuery);
        if($result->num_rows ==1){
            $update="UPDATE users set verified = 1 WHERE vkey = '$vkey' LIMIT 1";
            $alterUsers = $db->query($update);
            if($alterUsers) header('location: successfullyVerified.php');
            else header('location: ERROR.php');
        }
        else{ header('location: ERROR.php'); }
    }
}
else{
    header('location: ERROR.php');
    die();
}

?>