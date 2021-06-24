<?php
session_start();


if (!file_exists('uploads')) {
    mkdir('uploads', 0777);
}
 


$uploadFileName = 'uploads/' . time() . '_' . $_FILES['file']['name'];

if(move_uploaded_file($_FILES['file']['tmp_name'], $uploadFileName)) {
    $_SESSION['filePath'] = $uploadFileName;
    echo "<div class='alert alert-success'>File uploaded successfully</alert>";
} else {
    echo "<div class='alert alert-danger'>Upload failed</alert>";
}

?>