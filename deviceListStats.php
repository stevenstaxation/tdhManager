<?php

include 'connect.php';

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}
// $sql = 'SELECT tbldevicestatus.status FROM tbldevicestatus';
// $result = mysqli_query($link, $sql);

$returnString .= "
<table id='deviceListStats' class='table cell-borderless table-sm display compact'>
    <thead>
        <tr><th class='text-left align-middle'>Active Units</th><th class='text-right align-middle'>AI-12</th><th class='text-right align-middle'>CP2</th><th class='text-right align-middle'>CP4</th><th class='text-right align-middle'>Other</th><th class='text-right align-middle'>KP1</th><th class='text-right align-middle'>Total</th></tr>
    </thead>
    <tbody>
";


    $returnString .="<tr><td class='text-left align-middle'>Installed</td>"; //</tr>
    $sql = "SELECT COUNT(*), tbldevicedescription.devicegroup FROM tbldevice INNER JOIN tbldevicedescription ON tbldevice.devicedescriptionID = tbldevicedescription.id INNER JOIN tbldevicestatus ON tbldevicestatus.id = tbldevice.status WHERE tbldevicestatus.isactive='1' AND tbldevicestatus.status LIKE 'Installed%' GROUP BY tbldevicedescription.devicegroup ORDER BY tbldevicedescription.devicegroup ASC";
    $result3 = mysqli_query($link, $sql);
    $counter = 0;
    $index = 1;
    $lastRow = 0;

    while($row = mysqli_fetch_array($result3)) {
        $counter += $row[0];
      
        if ($row[1] == $index) {
            $returnString .="<td class='text-right align-middle'>" . $row[0] . "</td>";  
            if ($index==5) { $lastRow = 1; }
            $index++; 
        } else {
            while ($row[1] != $index) {
                $returnString .="<td class='text-right align-middle'>0</td>";   
                $index++;
            }
            $returnString .="<td class='text-right align-middle'>" . $row[0] . "</td>";  
         }
    
    }

    while ($index<5 && $lastRow!=1) {
        $returnString .="<td class='text-right align-middle'>0</td>";   
        $index++; 
    }

    $returnString .="<td class='text-right align-middle'>" . $counter . "</td></tr>";

    $returnString .="<tr><td class='text-left align-middle'>With Charlie</td>"; //</tr>
    $sql = "SELECT COUNT(*), tbldevicedescription.devicegroup FROM tbldevice INNER JOIN tbldevicedescription ON tbldevice.devicedescriptionID = tbldevicedescription.id INNER JOIN tbldevicestatus ON tbldevicestatus.id = tbldevice.status WHERE tbldevicestatus.isactive='1' AND tbldevicestatus.status LIKE '%Charlie%' GROUP BY tbldevicedescription.devicegroup ORDER BY tbldevicedescription.devicegroup ASC";
    $result3 = mysqli_query($link, $sql);
    $counter = 0;
    $index = 1;
    $lastRow = 0;

        while($row = mysqli_fetch_array($result3)) {
            $counter += $row[0];
          
            if ($row[1] == $index) {
                $returnString .="<td class='text-right align-middle'>" . $row[0] . "</td>";  
                if ($index==5) { $lastRow = 1; }
                $index++; 
            } else {
                while ($row[1] != $index) {
                    $returnString .="<td class='text-right align-middle'>0</td>";   
                    $index++;
                }
                $returnString .="<td class='text-right align-middle'>" . $row[0] . "</td>";  
             }
        
        }
        while ($index<5 && $lastRow!=1) {
            $returnString .="<td class='text-right align-middle'>0</td>";   
            $index++; 
        }
    
    $returnString .="<td class='text-right align-middle'>" . $counter . "</td></tr>";

    $returnString .="<tr><td class='text-left align-middle'>With Jimmy</td>"; //</tr>
    $sql = "SELECT COUNT(*), tbldevicedescription.devicegroup FROM tbldevice LEFT JOIN tbldevicedescription ON tbldevice.devicedescriptionID = tbldevicedescription.id INNER JOIN tbldevicestatus ON tbldevicestatus.id = tbldevice.status WHERE tbldevicestatus.isactive='1' AND tbldevicestatus.status LIKE '%Jimmy%' GROUP BY tbldevicedescription.devicegroup ORDER BY tbldevicedescription.devicegroup ASC";
    $result3 = mysqli_query($link, $sql);
    $counter = 0;
    $index = 1;
    $lastRow = 0;
        while($row = mysqli_fetch_array($result3)) {
            $counter += $row[0];
          
            if ($row[1] == $index) {
                $returnString .="<td class='text-right align-middle'>" . $row[0] . "</td>"; 
      
                if ($index==5) { $lastRow = 1; } 
                $index++; 
            } else {
                while ($row[1] != $index) {
                    $returnString .="<td class='text-right align-middle'>0</td>";   
                    $index++;
                }
                $returnString .="<td class='text-right align-middle'>" . $row[0] . "</td>";  
             }
        
        }

        while ($index<=5 && $lastRow!=1) {
            $returnString .="<td class='text-right align-middle'>0</td>";   
            $index++; 
        }
    
    $returnString .="<td class='text-right align-middle'>" . $counter . "</td></tr>";


    $returnString .="<tr><td class='text-left align-middle'>With Fleet</td>"; //</tr>
    $sql = "SELECT COUNT(*), tbldevicedescription.devicegroup FROM tbldevice LEFT JOIN tbldevicedescription ON tbldevice.devicedescriptionID = tbldevicedescription.id INNER JOIN tbldevicestatus ON tbldevicestatus.id = tbldevice.status WHERE tbldevicestatus.isactive='1' AND tbldevicestatus.status LIKE '%Fleet%' GROUP BY tbldevicedescription.devicegroup ORDER BY tbldevicedescription.devicegroup ASC";
    $result3 = mysqli_query($link, $sql);
    $counter = 0;
    $index = 1;
    $lastRow = 0;
    while($row = mysqli_fetch_array($result3)) {
        $counter += $row[0];
      
        if ($row[1] == $index) {
            $returnString .="<td class='text-right align-middle'>" . $row[0] . "</td>"; 
            if ($index==5) { $lastRow = 1; } 
            $index++; 
        } else {
            while ($row[1] != $index) {
                $returnString .="<td class='text-right align-middle'>0</td>";   
                $index++;
            }
            $returnString .="<td class='text-right align-middle'>" . $row[0] . "</td>";  
         }
    
    }

    while ($index<5 && $lastRow!=1) {
        $returnString .="<td class='text-right align-middle'>0</td>";   
        $index++; 
    }

    $returnString .="<td class='text-right align-middle'>" . $counter . "</td></tr>";


    $returnString .="<tr><td class='text-left align-middle'>In Hub</td>"; //</tr>
    $sql = "SELECT COUNT(*), tbldevicedescription.devicegroup FROM tbldevice LEFT JOIN tbldevicedescription ON tbldevice.devicedescriptionID = tbldevicedescription.id INNER JOIN tbldevicestatus ON tbldevicestatus.id = tbldevice.status WHERE tbldevicestatus.isactive='1' AND tbldevicestatus.status LIKE '%Hub%' GROUP BY tbldevicedescription.devicegroup ORDER BY tbldevicedescription.devicegroup ASC";
    $result3 = mysqli_query($link, $sql);
    $counter = 0;
    $index = 1;
    $lastRow = 0;
    while($row = mysqli_fetch_array($result3)) {
        $counter += $row[0];
      
        if ($row[1] == $index) {
            $returnString .="<td class='text-right align-middle'>" . $row[0] . "</td>";     
            $index++; 
            if ($index==5) { $lastRow = 1; } 
        } else {
            while ($row[1] != $index) {
                $returnString .="<td class='text-right align-middle'>0</td>";   
                $index++;
            }
            $returnString .="<td class='text-right align-middle'>" . $row[0] . "</td>";  
         }
    
    }

    while ($index<5 && $lastRow!=1) {
        $returnString .="<td class='text-right align-middle'>0</td>";   
        $index++; 
    }

    
    $returnString .="<td class='text-right align-middle'>" . $counter . "</td></tr>";



$returnString .= "</tbody></table>";



echo $returnString;
?>


