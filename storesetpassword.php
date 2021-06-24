<?php
session_start();
include('connect.php');

 // If userID or validation key is missing then show an error
if (!isset($_POST['userID']) || !isset($_POST['validationKey'])) {
    echo '<div class="alert alert-warning">Please click on the link you received by email to reset your password.</div>';
    exit();
}

 // Store them in two variable
$userID = $_POST['userID'];
$key = $_POST['validationKey'];
$time = time() - 3600;

// Prepare variables for query
$userID = mysqli_real_escape_string($link, $userID);
$key = mysqli_real_escape_string($link, $key);
                    
$sql = "SELECT userID FROM tblForgotPassword WHERE (userID = '$userID' AND validationKey ='$key' AND time > '$time' AND status='pending')";  
$result = mysqli_query($link,$sql);
if (!$result) {
    echo "<div class='alert alert-danger'>Cannot find user</div>";
    exit();
}
                 
$count = mysqli_num_rows($result);
                    
if ($count !== 1) {
    echo "<div class='alert alert-danger'>Recovery not possible</div>";
    exit();
}

$missingPassword = '<p>Please enter a password</p>';
$invalidPassword = '<p>Your password does not meet security requirements, it should be at least 8 characters long and include at least one capital letter and one number</p>';
$differentPassword = '<p>Passwords do not match</p>';
$missingPassword2= '<p>Please confirm your password</p>';

if(empty($_POST['password'])) {
        $errors .= $missingPassword;
    } elseif(!(strlen($_POST['password'])>8 and preg_match('/[A-Z]/',$_POST['password']) and preg_match('/[0-9]/',$_POST['password']))) {
        $errors .= $invalidPassword;
    } else {
        $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
        if (empty($_POST['password2'])) {
            $errors .= $missingPassword2;
        } else {
            $password2=filter_var($_POST['password2'], FILTER_SANITIZE_STRING);
            if ($password !== $password2) {
                $errors .= $differentPassword;
            }
        }
    }

if ($errors) {
    $resultMessage = "<div class='alert alert-danger'>" . $errors . "</div>";
    echo $resultMessage;
    exit();
}

//  If there are no errors
//  Prepare variables for query
$password = mysqli_real_escape_string($link,$password);
//$password = md5($password); // 128 bit hash ->32 chars
$password = hash('sha256', $password); // 256 bits = 64 bytes hex
$userID = mysqli_real_escape_string($link,$userID);

$sql = "UPDATE tblUsers SET password='$password' WHERE userID='$userID'";

$result = mysqli_query($link,$sql);

if (!$result) {
    echo '<div class="alert alert-danger">Error accessing the database</div>';
    echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
    exit();
}

$sql = "UPDATE tblForgotPassword SET status='used' WHERE validationKey='$key' AND userID='$userID'";
$result=mysqli_query($link, $sql);

if (!$result) {
    echo '<div class="alert alert-danger">Error accessing the database</div>';
    echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
} else {
    echo '<div class="alert alert-success">Your password has been updated successfully <a href="index.php">Login</a></div>';
}

    ?>