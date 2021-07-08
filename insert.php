<?php
if (isset($_POST['submit'])) {
    if (
        isset($_POST['username']) && isset($_POST['password']) &&
        isset($_POST['email']) &&
        isset($_POST['confirmPassword'])
    ) {

        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $confirmPassword = $_POST['confirmPassword'];

        if($password == $confirmPassword) {

            $host = "localhost";
            $dbUsername = "root";
            $dbPassword = "";
            $dbName = "activityfour";

            $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

            if ($conn->connect_error) {
                die('Could not connect to the database.');
            } else {
                $Select = "SELECT email FROM register WHERE email = ? LIMIT 1";
                $Insert = "INSERT INTO register(username, password, email) values(?, ?, ?)";

                $stmt = $conn->prepare($Select);
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->bind_result($resultEmail);
                $stmt->store_result();
                $stmt->fetch();
                $rnum = $stmt->num_rows;

                if ($rnum == 0) {
                    $stmt->close();

                    $stmt = $conn->prepare($Insert);
                    $stmt->bind_param("sss", $username, $password, $email);
                    if ($stmt->execute()) {
                        echo "<script type=\"text/javascript\">window.alert('Signed Up successfully.');window.location.href = './register.html';</script>";
                    } else {
                        echo $stmt->error;
                    }
                } else {
                    echo "<script type=\"text/javascript\">window.alert('A user with this email address already exists.');window.location.href = './register.html';</script>";
                }
                $stmt->close();
                $conn->close();
            }
        }else {
            echo "<script type=\"text/javascript\">window.alert('Password does not match the Confirm Password.');window.location.href = './register.html';</script>";
            exit;
            }
    } else {
        echo "<script type=\"text/javascript\">window.alert('All the fields are required.');window.location.href = './register.html';</script>";
            die();
        }
} else {
    echo "<script type=\"text/javascript\">window.alert('Submit button is not set.');window.location.href = './register.html';</script>";
    exit;
}
?>