<?php
$error = NULL;

if(isset($_POST['Username']) &&  isset($_POST['Password']) ){
    $Username = $_POST['Username'];
    $Password = $_POST['Password'];
    $user = false;

        @$db = new mysqli('localhost','root','','funtime');
        if(mysqli_connect_errno()){
            $error ="<p>Error: Could not connect to database</p>";
            die();
        }
        else {
            $srtQuery = 'select * from users';
            $result = $db->query($srtQuery);
            $array = array();
            while($row = $result->fetch_assoc()) {
                $array[] = $row;
            }
            $Password = md5($Password);

            if ($array) {
                for ($i = 0; $i < count($array); $i++) {

                    //$row = $result->fetch_array();
                    if (($Username == $array[$i]['username'] && $Password == $array[$i]['password'])) {
                        if ($array[$i]['verified'] == 0) {
                            $user = true;
                            //$error ="<p>true</p>";
                            header('location: index2.html'); // just to show that you are logged in
                        }
                        //else if the user account is not verified
                    } elseif (($Username == $row[2] && $Password == $row[3])) {
                        if ($row[5] == 0) {
                            $array = true;
                            //$error ="<p>false</p>";
                            header('location: index2.html');
                        }
                        //else if the user account is not verified
                    }

                }

                if (!$user) {
                    $error = "<p>WRONG USERNAME OR PASSWORD!</p>";
                }

            }
            else{
                header('location: Sign up1.php');
            }

        }
    //$error ="<p>Please Sign UP </p>";

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
    <h1><label for="Username">Login</label></h1>
    <input type="text" name="Username" id="Username" placeholder="Username\Email" required>
    <input type="password" name="Password" id="Password" placeholder="Password" required>
    <input type="submit" name="submit" value="Login">
    <div type="text" style="border: 0 ; color: black ; font-size: large">
        <?php
        echo $error;

        ?>
    </div>
</form>


</body>
</html>
