<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$returnString = "<div style='margin-top:50px; margin=left:10px;'><h3><strong>Preferences and Settings</strong></h3></div>";

$returnString .= "
<form id='preferencesForm'>
    <div class='row'>
        <div class='col-md-6 col-lg-4 col-xl-3'>
            <div id='deviceTypesList' class='settings-dialog'>
                <h6>
                    <strong style='margin-top:10px;'>Devices</strong>
                </h6>";

$sql = 'SELECT * FROM tblDeviceDescription ORDER BY description ASC';
$result = mysqli_query($link,$sql);

$returnString .= "<select name='deviceList' id='deviceList' size='8' style='width:100%'>";
while ($row = mysqli_fetch_array($result)) {
    $returnString .= "<option value='" . $row['ID'] . "'>" . $row['description'] . "</option>";
}
$returnString .="</select>
<hr color=#3276B1>

<div class='input-group flex'>
    <input type='text' id='textAddOrUpdateDevice' style='width:100%' placeholder='Device description...'>
</div>

<div class='btn-group' style='display : flex; margin: 5px;'>
    <button class='btn btn-sm btn-success' style='margin: 15px; border-radius: 15px;' id='addOrUpdateDevice' disabled>Add</button>
    <button class='btn btn-sm btn-warning' style='margin: 15px; border-radius: 15px; display: none' id='cancelUpdateDevice' disabled>Cancel</button>
    <button class='btn btn-sm btn-danger' style='margin: 15px; border-radius: 15px;' id='deleteDevice' disabled>Delete</button>
</div>
 <div id='deviceErrorBox'></div>
 </div>


        </div>

        <div class='col-md-6 col-lg-4 col-xl-3'>
            <div id='statusTypesList' class='settings-dialog'>
                <h6>
                    <strong style='margin-top:10px;'>Status Descriptions</strong>
                </h6>";

        $sql = 'SELECT * FROM tblDeviceStatus ORDER BY status ASC';
        $result = mysqli_query($link,$sql);

        $returnString .= "<select name='statusList' id='statusList' size='8' style='width:100%'>";
        while ($row = mysqli_fetch_array($result)) {
            $returnString .= "<option value='" . $row['ID'] . "'>" . $row['status'] . "</option>";
        }
        $returnString .="</select>
        <hr color=#3276B1>

    <div class='input-group flex'>
        <input type='text' id='textAddOrUpdateStatus' style='width:100%' placeholder='Status description...'>
    </div>

<div class='btn-group' style='display : flex; margin: 5px;'>
    <button class='btn btn-sm btn-success' style='margin: 15px; border-radius: 15px;' id='addOrUpdateStatus' disabled>Add</button>
    <button class='btn btn-sm btn-warning' style='margin: 15px; border-radius: 15px; display: none' id='cancelUpdateStatus' disabled>Cancel</button>
    <button class='btn btn-sm btn-danger' style='margin: 15px; border-radius: 15px;' id='deleteStatus' disabled>Delete</button>
</div>
 <div id='statusErrorBox'></div>
 </div>
</div>

<div class='col-md-6 col-lg-4 col-xl-3'>
    <div id='SIMTypesList' class='settings-dialog'>
                <h6>
                    <strong style='margin-top:10px;'>SIM Status Descriptions</strong>
                </h6>";
        $sql = 'SELECT * FROM tblSIMStatus ORDER BY SIMStatus ASC';
        $result = mysqli_query($link,$sql);

        $returnString .= "<select name='SIMStatusList' id='SIMStatusList' size='8' style='width:100%'>";
        while ($row = mysqli_fetch_array($result)) {
            $returnString .= "<option value='" . $row['ID'] . "'>" . $row['SIMStatus'] . "</option>";
        }
        $returnString .="</select>
        <hr color=#3276B1>

    <div class='input-group flex'>
        <input type='text' id='textAddOrUpdateSIMStatus' style='width:100%' placeholder='SIM status description...'>
    </div>

<div class='btn-group' style='display : flex; margin: 5px;'>
    <button class='btn btn-sm btn-success' style='margin: 15px; border-radius: 15px;' id='addOrUpdateSIMStatus' disabled>Add</button>
    <button class='btn btn-sm btn-warning' style='margin: 15px; border-radius: 15px; display: none' id='cancelUpdateSIMStatus' disabled>Cancel</button>
    <button class='btn btn-sm btn-danger' style='margin: 15px; border-radius: 15px;' id='deleteSIMStatus' disabled>Delete</button>
</div>
 <div id='SIMStatusErrorBox'></div>

 </div>
  </div>

<div class='col-md-6 col-lg-4 col-xl-3'>

    <div id='footageTypesList' class='settings-dialog'>
                <h6>
                    <strong style='margin-top:10px;'>Footage Status Descriptions</strong>
                </h6>";
         
                    $sql = 'SELECT * FROM tblFootageStatus ORDER BY description ASC';
                    $result = mysqli_query($link,$sql);

                    $returnString .= "<select name='footageStatusList' id='footageStatusList' size='8' style='width:100%;'>";
                    while ($row = mysqli_fetch_array($result)) {
                        $returnString .= "<option value='" . $row['ID'] . "'>" . $row['description'] . "</option>";
                    }
                    $returnString .="</select>

        <hr color=#3276B1>
        <div class='input-group flex'>
            <input type='text' id='textAddOrUpdateFootageStatus' style='width:100%' placeholder='Footage status description...'>
        </div>
   
        <div class='btn-group' style='display : flex; margin: 5px;'>
            <button class='btn btn-sm btn-success' style='margin: 15px; border-radius: 15px;' id='addOrUpdateFootageStatus' data-toggle='modal' data-target='#modalAddNewFootageStatus' disabled>Add</button>
            <button class='btn btn-sm btn-warning' style='margin: 15px; border-radius: 15px; display: none' id='cancelUpdateFootageStatus'>Cancel</button>
            <button class='btn btn-sm btn-danger' style='margin: 15px; border-radius: 15px;' id='deleteFootageStatus' disabled>Delete</button>
        </div>
        <div id='footageStatusErrorBox'></div>
    </div>
</div>

<div class='col-md-6 col-lg-4 col-xl-3'>

    <div id='renewalTypesList' class='settings-dialog'>
                <h6>
                    <strong style='margin-top:10px;'>Renewal Types</strong>
                </h6>";
         
                    $sql = 'SELECT * FROM tblrenewalType ORDER BY Description ASC';
                    $result = mysqli_query($link,$sql);

                    $returnString .= "<select name='renewalTypeList' id='renewalTypeList' size='8' style='width:100%;'>";
                    while ($row = mysqli_fetch_array($result)) {
                        $returnString .= "<option value='" . $row['ID'] . "'>" . $row['Description'] . "</option>";
                    }
                    $returnString .="</select>

        <hr color=#3276B1>
        <div class='input-group flex'>
            <input type='text' id='textAddOrUpdateRenewalType' style='width:100%' placeholder='Renewal type description...'>
        </div>
   
        <div class='btn-group' style='display : flex; margin: 5px;'>
            <button class='btn btn-sm btn-success' style='margin: 15px; border-radius: 15px;' id='addOrUpdateRenewalType' data-toggle='modal' data-target='#modalAddNewRenewalType' disabled>Add</button>
            <button class='btn btn-sm btn-warning' style='margin: 15px; border-radius: 15px; display: none' id='cancelUpdateRenewalType'>Cancel</button>
            <button class='btn btn-sm btn-danger' style='margin: 15px; border-radius: 15px;' id='deleteRenewalType' disabled>Delete</button>
        </div>
        <div id='renewalTypeErrorBox'></div>
    </div>
</div>

<div class='col-md-6 col-lg-4 col-xl-3'>

    <div id='jobTypesList' class='settings-dialog'>
                <h6>
                    <strong style='margin-top:10px;'>Job Types</strong>
                </h6>";
         
                    $sql = 'SELECT * FROM tblJobType ORDER BY description ASC';
                    $result = mysqli_query($link,$sql);

                    $returnString .= "<select name='jobTypeList' id='jobTypeList' size='8' style='width:100%;'>";
                    while ($row = mysqli_fetch_array($result)) {
                        $returnString .= "<option value='" . $row['ID'] . "'>" . $row['description'] . "</option>";
                    }
                    $returnString .="</select>

        <hr color=#3276B1>
        <div class='input-group flex'>
            <input type='text' id='textAddOrUpdateJobType' style='width:100%' placeholder='Job type description...'>
        </div>
   
        <div class='btn-group' style='display : flex; margin: 5px;'>
            <button class='btn btn-sm btn-success' style='margin: 15px; border-radius: 15px;' id='addOrUpdateJobType' data-toggle='modal' data-target='#modalAddNewJobType' disabled>Add</button>
            <button class='btn btn-sm btn-warning' style='margin: 15px; border-radius: 15px; display: none' id='cancelUpdateJobType'>Cancel</button>
            <button class='btn btn-sm btn-danger' style='margin: 15px; border-radius: 15px;' id='deleteJobType' disabled>Delete</button>
        </div>
        <div id='jobTypeErrorBox'></div>
    </div>
</div>";


  if ($_SESSION['isAdmin']== '1') {
    $returnString .= "

  <div class='col-md-6 col-lg-4 col-xl-4'>
      <div id='userList' class='settings-dialog'>
                  <h6>
                      <strong style='margin-top:10px;'>Users</strong>
                  </h6>";
          $sql = 'SELECT tblUsers.userID, tblUsers.userName, tblUsers.isAdmin, tblUsers.activation, tblUserRecord.firstName, tblUserRecord.lastName FROM tblUsers JOIN tblUserRecord ON tblUserRecord.userID = tblUsers.userID ORDER BY userName ASC';
          $result = mysqli_query($link,$sql);

          $returnString .= "<table class='table table-sm' style='width:100%; font-size: 75%;'><thead>
          <tr>
          <th style='display: none'>ID</th><th>Username</th><th>Name</th><th>Admin</th><th>Active</th>
          </tr>
          </thead><tbody>";
          while ($row = mysqli_fetch_array($result)) {
            if ($row['activation'] == 'activated') {
              $activeFlag = 1;
            } else {
              $activeFlag = 0;
            }
              $returnString .= "<tr><td style='display: none' class='userUpdateID' name='userUpdateID' value='".$row['userID']."'>" . $row['userID'] . "</td><td>" . $row['userName'] . "</td><td>" . $row['firstName'] . " " . $row['lastName'] . "</td><td>
              <center><input type='checkbox' class='isAdministrator' name='isAdministrator' " .($row['isAdmin'] == 1 ? 'checked' : '')." value = '". $row['isAdmin'] ."'>&nbsp;</center></td>
              <td><center><input type='checkbox' class='isActivated' name='isActivated' " .($row['activation'] == 'activated' ? 'checked' : '') . " value = '" . $activeFlag . "'>&nbsp;</center></td></tr>";
          }
          $returnString .="</tbody></table>
          <hr color=#3276B1>


  <div class='btn-group' style='display : flex; margin: 5px;'>
      <button class='btn btn-sm btn-success' style='margin: 15px; border-radius: 15px;' id='updateUserList'>Update</button>
      <button class='btn btn-sm btn-primary' style='margin: 15px; border-radius: 15px;' id='inviteNewUser'>Invite New</button>
    </div>
   <div id='userErrorBox'></div>

   </div>

        </div>";
}

$returnString .= "
    </div>";"

</form>
";

// <center><input type='checkbox' id='isFootageRequest' onclick='return false;' name='isFootageRequest' " . ($contact['isFootageRecipient'] == 1 ? 'checked' : '')." value='1'/>&nbsp;</center></td>

    echo $returnString;
    ?>
