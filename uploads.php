<?php
/**
 * @author Lee Stevens
 * @copyright Stevens Taxation Services Ltd
 * @filesource
 * @param $_FILES['file']   The file to be uploaded
 * @return String 'success' with uploaded file name appended
 * @throws HTML alert class 'upload failed'
 */

/**
 * Ensure user is logged in
 */
 session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}


/**
 * Ensure the uploads directory is in the root directory
 */
if (!file_exists('uploads')) {
    mkdir('uploads', 0777);
}
 
/**
 * Upload file
 */
$uploadFileName = 'uploads/' . $_FILES['file']['name'];

if(move_uploaded_file($_FILES['file']['tmp_name'], $uploadFileName)) {
    echo "success" . $_FILES['file']['name'];
} else {
    echo "<div class='alert alert-danger'>Upload failed</alert>";
}



?>


