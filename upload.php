<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$selectorType = $_POST['selector'];


if ($_FILES['file']['name']!='') {
    $test = explode(".", $_FILES['file']['name']);
    $extension = end($test);
    $name = rand(100, 999) . "." . $extension;
    $location = "uploads/" . $name;

    move_uploaded_file($_FILES['file']['tmp_name'], $location);
    $returnString = "<p>File " . $_FILES['file']['name'] ." uploaded...";

    //read file (csv)
    $data = array();
    $fHandle = fopen($location, 'r');
    $dataString = "<table class='table table-sm table-striped'>";
    
    $headings[] = '';
    $ix = 0;
    $row =fgetcsv($fHandle);
    $dataString .= "<thead class='thead-dark'><tr><th>Row</th></th>";
    foreach ($row as $item) {
        $headings[$ix] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '',$item);
        $dataString .= "<th>" .  $headings[$ix] ."</th>";
        $ix++;
    }

    switch ($selectorType) {
        case "devices": 
            // check headings match required mapping
            $errors = '';
            if ($ix!=9) {
                $errors = "Incorrect number of columns in file<br>";
                echo "<div class='alert alert-danger'>" . $errors . "</div>";
                unlink($location);
                exit();
            }

            if (trim(strtolower($headings[0]))!="model") {$errors .= "Column 1 heading should be Model, found " . $headings[0] ."<br>";}
            if (strtolower($headings[1])!="platform") {$errors .= "Column 2 heading should be Platform, found " . $headings[1] ."<br>";} 
            if (strtolower($headings[2])!="serial") {$errors .= "Column 3 heading should be Serial, found " . $headings[2] ."<br>";}
            if (strtolower($headings[3])!="imei") {$errors .= "Column 4 heading should be IMEI, found " . $headings[3] ."<br>";}
            if (strtolower($headings[4])!="devicestatus") {$errors .= "Column 5 heading should be DeviceStatus, found " . $headings[4] ."<br>";}
            if (strtolower($headings[5])!="dridnumber") {$errors .= "Column 6 heading should be DRIDNumber, found " . $headings[5] ."<br>";}
            if (strtolower($headings[6])!="simserialno") {$errors .= "Column 7 heading should be SimSerialNo, found " . $headings[6] ."<br>";}
            if (strtolower($headings[7])!="simphone") {$errors .= "Column 8 heading should be SimPhone, found " . $headings[7] ."<br>";}
            if (strtolower($headings[8])!="customer") {$errors .= "Column 9 heading should be Customer, found " . $headings[8] ."<br>";}

            if ($errors) {
                echo "<div class='alert alert-danger'>" . $errors . "</div>";
                unlink($location);
                exit();
            }

            $dataString .="</tr></thead><tbody>";
    $count = 0;
    $readFile [] ='';
    while ($row = fgetcsv($fHandle)) { 
        $readFile[$count] = $row;
        $dataString .="<tr>";
        $dataString .="<td>" . ($count + 1) . "</td>";
        foreach ($row as $item) {
            $dataString .="<td>" . htmlspecialchars($item) . "</td>";
        }
        $dataString .="</tr>";
        $count++;
    }

    $dataString .="</tbody></table>"; // contains a table showing the data uploaded


    fclose($fHandle);
   

    $returnString .= "&nbsp;&nbsp;" . $count . " records found to import...</p>"; 

    if ($count!=0) {
    // check for errors
    $itemCount = 1;
    $errorCount = 0;
    $errorString = '';
    foreach ($readFile as $readItem) {
        
        // $readFile[x][0] = Model must be in database
        $sqlModel = "SELECT description FROM tblDeviceDescription WHERE description='$readItem[0]'";
        $result = mysqli_query($link, $sqlModel);  
        if (mysqli_num_rows($result)==0) { 
            $errorString .= "Unknown model '" . $readItem[0] . "' at row " . $itemCount . "<br>"; 
            $errorCount++;
        } 

        // $readFile[x][1] = Platform must be in database
         $sqlPlatform = "SELECT supplierName FROM tblSupplier WHERE supplierName='$readItem[1]'";
         $result = mysqli_query($link, $sqlPlatform);
         if (mysqli_num_rows($result)==0) { 
             $errorString .= "Unknown platform '" . $readItem[1] . "' at row " . $itemCount . "<br>"; 
             $errorCount++;
         }

        // $readFile[x][3] = IMEI must be 15 characters long
         if (strlen($readItem[3])!=15 && $readItem[3]!='') {
            $errorString .= "Invalid IMEI '" . $readItem[3] . "' at row " . $itemCount . "<br>"; 
         }

        // $readFile[x][4] = Status must be in database
         $sqlStatus = "SELECT status FROM tblDeviceStatus WHERE status='$readItem[4]'";
         $result = mysqli_query($link, $sqlStatus);
         if (mysqli_num_rows($result)==0) { 
            $errorString .= "Unknown status '" . $readItem[4] . "' at row " . $itemCount . "<br>"; 
            $errorCount++;
         }

        // $readFile[x][8] = Customer must be in database
         if ($readItem[8]=='') {
             $readItem[8] = 'DHINSTALL';
         }
         $sqlCustomer = "SELECT businessName FROM tblCustomer WHERE businessname='$readItem[8]'";
         $result = mysqli_query($link, $sqlCustomer);
         if (mysqli_num_rows($result)==0) { 
            $errorString .= "Unknown customer '" . $readItem[8] . "' at row " . $itemCount . "<br>"; 
            $errorCount++;
         }

         $itemCount++;
    }

    if ($errorCount!=0) {
        $errorString = "<b>Errors found: " .$errorCount . "</b><br>" . $errorString;
        $returnString .= $errorString;
        $returnString .= $dataString; 
        echo $returnString;  
        unlink($location);
        exit();
    } else {
        $errorString = "No errors found...";
        $returnString .= $errorString;
        $insertCount = 0;
        // now to import into database
        foreach ($readFile as $readItem) {
            // get modelID
            $sql = "SELECT ID FROM tblDeviceDescription WHERE description='$readItem[0]'";
            $result=mysqli_query($link, $sql);
            $row = mysqli_fetch_array($result);
            $rowModelID = $row['ID'];
            // get PlatformID
            $sql = "SELECT ID FROM tblSupplier WHERE supplierName='$readItem[1]'";
            $result=mysqli_query($link, $sql);
            $row = mysqli_fetch_array($result);
            $rowPlatformID = $row['ID'];
            // get StatusID
            $sql = "SELECT ID FROM tblDeviceStatus WHERE status='$readItem[4]'";
            $result=mysqli_query($link, $sql);
            $row = mysqli_fetch_array($result);
            $rowStatusID = $row['ID'];
            // get CustomerID
            $sql = "SELECT ID FROM tblCustomer WHERE businessname='$readItem[8]'";
            $result=mysqli_query($link, $sql);
            $row = mysqli_fetch_array($result);
            $rowCustomerID = $row['ID'];

            $SQL = "INSERT INTO tblDevice (ownerID, cameraUsedFor, isCamera, deviceDescriptionID, serialNumber, IMEI, DRIDNumber, SIMNumber, SIMPhone, 
            status, supplierID, SIMStatus) VALUES ('$rowCustomerID', '$rowCustomerID','1','$rowModelID','$readItem[2]','$readItem[3]','$readItem[5]','$readItem[6]',
            '$readItem[7]','$rowStatusID','$rowPlatformID','1')";
            
            $result = mysqli_query($link, $SQL);
            $insertCount++;     
        }
    }    
        $returnString .= $insertCount . " devices imported OK...";


            unlink($location);
            echo $returnString;
 
    }

        break;


        case "healthchecks":

        break;


        case "vehicles":
        // check headings match required mapping
        $errors = '';
        if ($ix!=5) {
            $errors = "Incorrect number of columns in file<br>";
            echo "<div class='alert alert-danger'>" . $errors . "</div>";
            unlink($location);
            exit();
        }

        if (trim(strtolower($headings[0]))!="regnumber") {$errors .= "Column 1 heading should be RegNumber, found " . $headings[0] ."<br>";}
        if (trim(strtolower($headings[1]))!="camerarequired") {$errors .= "Column 2 heading should be CameraRequired, found " . $headings[1] ."<br>";} 
        if (trim(strtolower($headings[2]))!="status") {$errors .= "Column 3 heading should be Status, found " . $headings[2] ."<br>";}
        if (trim(strtolower($headings[3]))!="installdate") {$errors .= "Column 4 heading should be InstallDate, found " . $headings[3] ."<br>";}
        if (trim(strtolower($headings[4]))!="customer") {$errors .= "Column 5 heading should be Customer, found " . $headings[4] ."<br>";}
 
        if ($errors) {
            echo "<div class='alert alert-danger'>" . $errors . "</div>";
            unlink($location);
            exit();
        }

    $dataString .="</tr></thead><tbody>";
    $count = 0;
    $readFile [] ='';
    while ($row = fgetcsv($fHandle)) { 
        $readFile[$count] = $row;
        $dataString .="<tr>";
        $dataString .="<td>" . ($count + 1) . "</td>";
        foreach ($row as $item) {
            $dataString .="<td>" . htmlspecialchars($item) . "</td>";
        }
        $dataString .="</tr>";
        $count++;
    }

    $dataString .="</tbody></table>"; // contains a table showing the data uploaded


    fclose($fHandle);


    $returnString .= "&nbsp;&nbsp;" . $count . " records found to import...</p>"; 

    if ($count!=0) {
    // check for errors
    $itemCount = 1;
    $errorCount = 0;
    $errorString = '';
    foreach ($readFile as $readItem) {

    // $readFile[x][0] = RegNunber must NOT be in database
    $sqlModel = "SELECT regNumber FROM tblVehicle WHERE regNumber='$readItem[0]'";
    $result = mysqli_query($link, $sqlModel);  
    if (mysqli_num_rows($result)!=0) { 
        $errorString .= "Registration No. '" . $readItem[0] . "' at row " . $itemCount . " already exists<br>"; 
        $errorCount++;
    } 

    // $readFile[x][4] = Customer must be in database
    $sqlCustomer = "SELECT businessName FROM tblCustomer WHERE businessname='$readItem[4]'";
    $result = mysqli_query($link, $sqlCustomer);
    if (mysqli_num_rows($result)==0) { 
        $errorString .= "Unknown customer '" . $readItem[4] . "' at row " . $itemCount . "<br>"; 
        $errorCount++;
    }

    $itemCount++;
}

if ($errorCount!=0) {
    $errorString = "<b>Errors found: " .$errorCount . "</b><br>" . $errorString;
    $returnString .= $errorString;
    $returnString .= $dataString; 
    echo $returnString;  
    unlink($location);
    exit();
} else {
    $errorString = "No errors found...";
    $returnString .= $errorString;
    $insertCount = 0;

    // now to import into database
    foreach ($readFile as $readItem) {
        // get CustomerID
        $sql = "SELECT ID FROM tblCustomer WHERE businessname='$readItem[4]'";
        $result=mysqli_query($link, $sql);
        $row = mysqli_fetch_array($result);
        $rowCustomerID = $row['ID'];

        if ($readItem[1] !=1) { 
            $camRequired=0;
        } else  {
            $camRequired=1;
        }

        if ($readItem[2] !=1 && $readItem[2] !=2) {
            $vehicleStatus = 0;
        } else {
            $vehicleStatus = $readItem[2];
        }

        $readItem[3] = str_replace("/","-",$readItem[3]);

        if ($readItem[3]!='') {
            $installDate = date('Y-m-d', strtotime($readItem[3]));
        } else {
            $installDate = null;
        }
   
        $SQL = "INSERT INTO tblVehicle (regNumber, ownerID, vehicleStatus, installDate, cameraRequired) VALUES ('$readItem[0]', '$rowCustomerID','$vehicleStatus',NULLIF('$installDate',''),'$camRequired')";
   
        $result = mysqli_query($link, $SQL);
        $insertCount++;     
    }
} 
    $returnString .= $insertCount . " vehicles imported OK...";
    unlink($location);
    echo $returnString;

}
 
break;

default:

break;

}

}
    

    

    



?>