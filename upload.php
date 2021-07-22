<?php

if ($_FILES['file']['name']!='') {
    $test = explode(".", $_FILES['file']['name']);
    $extension = end($test);
    $name = rand(100, 999) . "." . $extension;
    $location = "uploads/" . $name;

    move_uploaded_file($_FILES['file']['tmp_name'], $location);
    echo "<img id='uploadScreenshot' src='" . $location . "' height='150' width='225' class='img-thumbnail' />";

}