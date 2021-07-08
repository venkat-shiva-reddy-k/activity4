<?php
$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "activityfour";

$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  if(isset($_POST['submit'])){

    $uname = mysqli_real_escape_string($conn,$_POST['usernameLog']);
    $password = mysqli_real_escape_string($conn,$_POST['passwordLog']);

    if ($uname != "" && $password != ""){

        $sql_query = "select count(*) as cntUser from register where username='".$uname."' and password='".$password."'";
        $result = mysqli_query($conn,$sql_query);
        $row = mysqli_fetch_array($result);

        $count = $row['cntUser'];

        if($count > 0){
            $_SESSION['uname'] = $uname;
            echo "<script type=\"text/javascript\">window.alert('Login Success.');window.location.href = './login.html';</script>";
        }else{
            echo "<script type=\"text/javascript\">window.alert('Login Failed! Invalid Username or Password.');window.location.href = './login.html';</script>";
        }
    }
}
?>