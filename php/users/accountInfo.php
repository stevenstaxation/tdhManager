<?php
session_start();
include '../../connect.php';

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header('Location: index.php');
}

$userID = $_POST['userID'];
$sql = "SELECT tblUsers.userID, email, password, firstName, lastName FROM tblUsers JOIN tblUserRecord ON tblUsers.userID = tblUserRecord.userID WHERE tblUsers.userID = '$userID'";
$result = mysqli_query($link, $sql);

if (!$result) {
    echo "<div class='alert alert-danger'>'" . mysqli_error($link) . "'</div>";
    exit();
}

$count = mysqli_num_rows($result);

if ($count !== 1) {
    echo "<div class='alert alert-danger'>'" . $sql . mysqli_error($link) . "'</div>";
    exit();
}

$row = mysqli_fetch_array($result);
?>

<h3 style='margin-top:50px;'>
    <strong>Profile Information</strong>
</h3>

<form id='profileForm'>
    <div id='showAccountInfo' class='settings-dialog' style='margin-top:15px; margin-bottom: 100px; border-width: 1px; border-style: solid; border-radius: 8px; padding: 20px;'>
        <h5>
            <strong style='margin-top:10px;'>Settings</strong>
        </h5>
        <div id='errorBox'></div>

        <div class='row'>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class='control-label' for='emailAddress'>
                        <strong>Email Address </strong>
                        <a style='color:red'>*</a>
                    </label>
                    <div class='input-group'>
                        <input class='form-control enabler' type='email' id='inputEmailAddress' name='inputEmailAddress' placeholder='enter your email address...' value='<?php echo $row["email"]; ?>'>
                    </div>
                </div>
            </div>

            <div class='col-md-6'>
                <div class='form-group'>
                    <label class='control-label' for='password'>
                        <strong>Password </strong>
                        <a style='color:red'>*</a>
                    </label>
                    <div class='input-group'>
                        <input class='form-control enabler' type='password' id='inputPassword' name='inputPassword' readonly='readonly' value='<?php echo $row["password"]; ?>'>
                        <div class='input-group-append'>
                            <button class='btn btn-primary' id='changePassword'style='border: 1px solid white; border-left: none'>change</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div class='row'>
        <div class='col-md-6'>
            <div class='form-group'>
                <label class='control-label' style='padding-top:10px;' for='firstName'>
                    <strong>First Name </strong>
                    <a style='color:red'>*</a>
                </label>
                <div class='input-group'>
                    <input class='form-control' type='text' id='inputFirstName' name='inputFirstName' placeholder='enter your first name...' value='<?php echo $row["firstName"]; ?>'>
                </div>
            </div>
        </div>
        <div class='col-md-6'>
            <div class='form-group'>
                <label class='control-label' style='padding-top:10px;' for='lastName'>
                    <strong>Last Name </strong>
                    <a style='color:red'>*</a>
                </label>
                <div class='input-group'>
                    <input class='form-control' type='text' id='inputLastName' name='inputLastName' placeholder='enter your last name...' value='<?php echo $row["lastName"]; ?>'>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class='row'>
        <!-- <div class='col-md-1'></div> -->
        <div class='btn-group m-auto profileButtons'>
            <button type='button' id='updateUser' name='updateUser' class='btn btn-success profileButton' disabled='disabled' style='border-radius: 5px;'>Update</button>
            <button type='button' id='discardUser' name='discardUser' class='btn btn-danger profileButton' disabled='disabled' onclick='showMyAccount()' style='border-radius: 5px;'>Discard</button>
            <button type='button' id='closeUser' name='closeUser'class='btn btn-warning profileButton' style='border-radius: 5px;'>Close</button>
        </div>
    </div>
</div>
</form>

<?php
require_once 'modalChangePassword.php';
?>

