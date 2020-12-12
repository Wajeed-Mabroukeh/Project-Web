<?php
$error = NULL;

if(isset($_POST['Username']) && isset($_POST['email']) && isset($_POST['Password']) && isset($_POST['Password2'])){
    $Username = $_POST['Username'];
    $Email = $_POST['email'];
    $Password = $_POST['Password'];
    $Password2 = $_POST['Password2'];


    if(strlen($Username) < 5){
        $error = "Your Username Must be at least 5 Characters Long";
    }
    elseif ($Password != $Password2)
        $error .= "<p>Your Passwords Do Not Match</p>";
    elseif (strlen($Password) < 8 || strlen($Password) > 16)
        $error .= "<p>Your Passwords Must Be 8 to 16 Characters Long</p>";
    else{
        @$db = new mysqli('localhost','root','','funtime');
        if(mysqli_connect_errno()){
            $error ="<p>Error: Could not connect to database</p>";
            die();
        }
        else{
            $srtQuery = 'select * from users where id = (SELECT MAX(id) FROM users)';
            $result = $db -> query($srtQuery);
            $row = $result -> fetch_array();
            $id = $row[0]+1;
            $verified = 0;
            $vkey = md5(time().$Username);
            $Password = md5($Password);
            $insert = "INSERT INTO users(id,username,email,password,vkey,verified) VALUES('$id','$Username','$Email','$Password','$vkey','$verified')";
            $insertion = $db -> query($insert);
            if($insertion){
                //SEND EMAIL
                $to = $Email;
                $subject = "Email Verification";
                $massage = '<p style="'.'font-size: x-large ; color: red; alignment: center">'.'WELCOME TO OUR FAMILY'.'</p>';
                $massage .="<br>";
                $massage .= '<p style="'.'font-size: large ; color: red; alignment: left">'.'This is an automatic message from the FUN TIME registration system.
                Thank you for registration with FUN TIME. You can now create your own Watchlist, rate and review movies and shows, get personalized recommendations, and much more. 
                Please confirm your email address to get the full benefits of your account by clicking this link:'.'</p>';
                $massage .="<br>";
                $massage .="<a style='alignment: left font-size: large ' href ='http://localhost/WEB/WebProject_2020/verify.php?vkey=$vkey'>REGISTER YOUR ACCOUNT</a>";
                $massage .="<br>";
                $massage .= '<p style="'.'font-size: large ; color: red; alignment: left">'.'If you received this message but did not attempt to register, it means that someone may have entered your email address when registering with FUNTIME.com, probably by mistake. If this is the case, you can safely disregard this email. No further action is required.
                If you have questions about using FUN TIME, including instructions and guidelines on how to submit content or how to sign up please visit the FUN TIME Main WebSite.'.'</p>';
                $headers = "From: funtimecompany2020@gmail.com \r\n";
                $headers .= "MIME-Version: 1.0" ."\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" ."\r\n";

                if(mail($to, $subject , $massage ,$headers ))
                    header('location: thankyou.php');
            }
            else  header('location: ERROR.php');

        }
    }

}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Sign Up Form</title>
    <link rel="stylesheet" href="SignUpStyle.css">
</head>
<body>

<form class="box" action="SignUp.php" method="post">

    <h1>Sign Up</h1>
    <input type="text" name="Username" id="Username" placeholder="Username">
    <input type="email" name="email" id="email" placeholder="Email">
    <input type="password" name="Password" id="Password" placeholder="Password">
    <input type="password" name="Password2" id="Password2" placeholder="Repeat Password">
    <input type="submit" name="Sign Up" value="Sign Up">
    <div type="text" style="border: 0 ; color: white ; font-size: large">
        <?php
        echo $error;
        ?>
    </div>
</form>

</body>
</html>
