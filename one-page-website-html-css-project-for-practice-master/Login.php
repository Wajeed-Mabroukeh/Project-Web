<?php
$error = NULL;

if(isset($_POST['Username']) &&  isset($_POST['Password']) ){
    $Username = $_POST['Username'];
    $Password = $_POST['Password'];
    $user = false;


    if(strlen($Username) < 5){
        $error = "<p>WRONG USERNAME</p>";
    }
    elseif (strlen($Password) < 8) {
        $error = "<p>WRONG PASSWORD</p>";
    }
    else{
        @$db = new mysqli('localhost','root','','funtime');
        if(mysqli_connect_errno()){
            $error ="<p>Error: Could not connect to database</p>";
            die();
        }
        else{
            $srtQuery = 'select * from users';
            $result = $db -> query($srtQuery);
            $Password = md5($Password);

            for($i=0 ; $i< $result -> num_rows ;$i++){

                $row = $result -> fetch_array();
                if( ($Username == $row[1] && $Password == $row[3]) ){
                    if($row[5] == 1) {
                        $user = true;
                        header('location: Logged_In.php'); // just to show that you are logged in
                    }
                    //else if the user account is not verified
                }
                elseif ( ($Username == $row[2] && $Password == $row[3]) ){
                    $user = true;
                    if($row[5] == 1) {
                        $user = true;
                        header('location: Logged_In.php');
                    }
                    //else if the user account is not verified
                }

            }

            if(!$user){
                $error = "<p>WRONG USERNAME OR PASSWORD!</p>";
            }

        }
    }

}
?>



<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Login Form</title>
    <link rel="stylesheet" href="SignUpStyle.css">
</head>
<body>

<form class="box" action="Login.php" method="post">
    <h1>Login</h1>
    <input type="text" name="Username" id="Username" placeholder="Username\Email">
    <input type="password" name="Password" id="Password" placeholder="Password">
    <input type="submit" name="submit" value="Login">
    <div type="text" style="border: 0 ; color: white ; font-size: large">
        <?php
        echo $error;
        ?>
    </div>
</form>


</body>
</html>
