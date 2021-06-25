<?php
session_start();


if (!file_exists('uploads')) {
    mkdir('uploads', 0777);
}
 


$uploadFileName = 'uploads/' . $_FILES['file']['name'];


if(move_uploaded_file($_FILES['file']['tmp_name'], $uploadFileName)) {
    echo "success" . $_FILES['file']['name'];
} else {
    echo "<div class='alert alert-danger'>Upload failed</alert>";
}

?>
