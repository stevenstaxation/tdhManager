<?php
session_start();
include ('connect.php');

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$sqlFILTER = ($_POST['SQLFilter']);

if (!isset($_POST['FilterCustomer'])) {
  $_POST['FilterCustomer'] = '';
}
if (!isset($_POST['FilterType'])) {
  $_POST['FilterType'] = '';
}
if (!isset($_POST['FilterOtherTerm'])) {
  $_POST['FilterOtherTerm'] = '';
}

$returnString = "<div id='deviceLongList' class='listHeader'><h4><strong>Footage Requests</strong></h4></div>";

$returnString .= "
<div class='container'>
  <div id='deviceFilter'>
    <form id='deviceForm' class='filterBox' style='display: none'>        
      <div class='input-group'>
        <input type='text' style='font-size:75%; padding: 5px;' id='byOther' value='" . $_POST['FilterOtherTerm'] . "'/>
      </div>
    </form>
  </div>
</div>

";

  $sql = 'SELECT tblFootageRequest.ID, tblFootageRequest.ownerID,  tblVehicle.regNumber, tblFootageRequest.requestDateTime, tblFootageRequest.incidentDate, tblFootageRequest.claimRef, 
  tblFootageRequest.responseDateTime, tblFootageStatus.description, tblFootageRequest.requestNotes, tblFootageRequest.responseText, tblCustomer.businessName, tblUsers.userName  
  
  FROM tblFootageRequest INNER JOIN tblVehicle ON tblFootageRequest.vehicleID = tblVehicle.ID INNER JOIN tblCustomer ON tblCustomer.ID = tblFootageRequest.ownerID 
  INNER JOIN tblFootageStatus ON tblFootageRequest.statusID = tblFootageStatus.ID INNER JOIN tblUsers ON tblFootageRequest.userID = tblUsers.userID';

    if ($sqlFILTER) {
      $sql .= $sqlFILTER;
    }

  $result = mysqli_query($link, $sql);

    if (mysqli_num_rows($result) !=0) {
      $returnString .= "<div id = 'deviceSummary' class='w-auto ml-auto mr-auto' style='margin-top: 15px;'>
      <table id='footageListTable' class='table cell-border compact'>
      <thead>
        <tr>
          <th class='text-center align-middle' style='padding-left: 3px; padding-right: 3px;'>No.</th>
            <th class='text-center align-middle' style='padding-left: 3px; padding-right: 3px;'>Request Date</th>
            <th class='text-center align-middle' style='padding-left: 3px; padding-right: 3px;'>Request Time</th>
            
            <th class='text-center align-middle' style='padding-left: 3px; padding-right: 3px;'>Incident Date</th> 
            <th class='text-center align-middle' style='padding-left: 3px; padding-right: 3px;'>Days</th> 
            <th class='text-center align-middle' style='padding-left: 3px; padding-right: 3px;'>VRN</th>
            <th class='text-center align-middle' style='padding-left: 3px; padding-right: 3px;'><strong>Fleet</strong></th>
            <th class='text-center align-middle' style='padding-left: 3px; padding-right: 3px;'>Claim Ref</th>
            <th class='text-center align-middle' style='padding-left: 3px; padding-right: 3px;'>Hub</th> 
            <th class='text-center align-middle' style='padding-left: 3px; padding-right: 3px;'>Response Date</th>
            <th class='text-center align-middle' style='padding-left: 3px; padding-right: 3px;'>Status</th>
            <th class='text-center align-middle' style='padding-left: 3px; padding-right: 3px;'>Request Text</th> 
            <th class='text-center align-middle' style='padding-left: 3px; padding-right: 3px;'>Edit</th>
            <th class='text-center align-middle' style='padding-left: 3px; padding-right: 3px;'>Notes</th>
            <th class='text-center align-middle' style='padding-left: 3px; padding-right: 3px;'>Footage</th>            
        </tr>
      </thead>
    
      <tbody>";

      $ix = 1;
  while ($row= mysqli_fetch_array($result)) {
      $dt1 = new DateTime($row['requestDateTime']);
      $dt2 = new DateTime($row['incidentDate']);
      $dateDifference = $dt1->diff($dt2);

    $returnString .= "<tr>
    <td class='text-center align-middle' style='padding:0 3px;'>" . $ix . "</td>
    <td class='text-center align-middle' style='padding:0 3px;' data-sort='" .$row['requestDateTime'] ."'>" . date('d/m/Y', strtotime($row['requestDateTime'])). "</td> 
    <td class='text-center align-middle' style='padding:0 3px;'>" . date('G:i', strtotime($row['requestDateTime'])). "</td> 
    <td class='text-center align-middle' style='padding:0 3px;' data-sort='" .$row['incidentDate'] ."'>" . date('d/m/Y', strtotime($row['incidentDate'])). "</td>
    <td class='text-center align-middle' style='padding:0 3px;'>" . $dateDifference->d . "</td>
    <td class='text-center align-middle' style='padding:0 3px;'>" . $row['regNumber']. "</td>
    <td class='align-middle' style='padding:0 3px'>" . $row['businessName'] . "</td>
    <td class='align-middle' style='padding:0 3px;'>" . $row['claimRef']. "</td>
    <td class='align-middle' style='padding:0 3px;'>" . $row['userName']. "</td>";

    if ($row['responseDateTime']) {
      $returnString .="
    <td class='text-center align-middle' style='padding:0 3px;' data-sort='" .$row['responseDateTime'] ."'>" . date('d/m/Y G:i', strtotime($row['responseDateTime'])). "</td>";
    } else {
      $returnString .="
      <td class='text-center align-middle' style='padding:0 3px; color: red' data-sort='" .$row['incidentDate'] ."'>outstanding</td>";
    } 
    $returnString .="
    <td class='align-middle' style='padding:0 3px;'>" . $row['description']. "</td>
    <td class='align-middle' style='padding:0 3px;'>" . $row['requestNotes']. "</td>
    
  <td class='text-center align-middle' style='width:1%'><btn class='btn btn-sm btn-warning' onclick='window.alert(\"not implemented yet\")'><svg xmlns='http://www.w3.org/2000/svg' width='16px' fill='currentColor' class='bi bi-pencil-fill' viewBox='0 0 16 16'>
  <path d='M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z'/>
</svg></btn></td>
<td class='text-center align-middle' style='width:1%'><btn class='btn btn-sm btn-info' onclick='window.alert(\"not implemented yet\")'><svg xmlns='http://www.w3.org/2000/svg' width='16px' fill='currentColor' class='bi bi-card-text' viewBox='0 0 16 16'>
<path d='M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z'/>
<path d='M3 5.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 8zm0 2.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z'/>
</svg></btn></td>
<td class='text-center align-middle' style='width:1%'><btn class='btn btn-sm btn-primary' onclick='window.alert(\"not implemented yet\")'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-film' viewBox='0 0 16 16'>
<path d='M0 1a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V1zm4 0v6h8V1H4zm8 8H4v6h8V9zM1 1v2h2V1H1zm2 3H1v2h2V4zM1 7v2h2V7H1zm2 3H1v2h2v-2zm-2 3v2h2v-2H1zM15 1h-2v2h2V1zm-2 3v2h2V4h-2zm2 3h-2v2h2V7zm-2 3v2h2v-2h-2zm2 3h-2v2h2v-2z'/>
</svg></btn></td>

    </tr>";
    $ix++;
  }

  $returnString .="</tbody>
  <tfoot>
    <tr>
      <th class='text-center align-middle'>No.</th>
      <th class='text-center align-middle'>Request Date</th>
      <th class='text-center align-middle'>Request Time</th>          
      <th class='text-center align-middle'>Incident Date</th> 
      <th class='text-center align-middle'>Days</th> 
      <th class='text-center align-middle'>VRN</th>
      <th class='text-center align-middle'><strong>Fleet</strong></th>
      <th class='text-center align-middle'>Claim Ref</th>
      <th class='text-center align-middle'>Hub</th> 
      <th class='text-center align-middle'>Response Date</th>
      <th class='text-center align-middle'>Status</th>
      <th class='text-center align-middle'>Request Text</th> 
      <th class='text-center align-middle'>Edit</th>
      <th class='text-center align-middle'>Notes</th>
      <th class='text-center align-middle'>Footage</th>            
    </tr>
  </tfoot>

  </table>

</div>
<script>
 document.getElementById('byOther').addEventListener('keypress', function (event) {
       if (event.keyCode == 13) {
            event.preventDefault();
        } 
    });

    $(document).ready(function() {
      $('#footageListTable').DataTable({
        columnDefs: [
          {orderable: false, targets: [12,13,14] },
          {searchable: false, targets: [12,13,14] }
        ],
        colReorder: true,
        order: [[0, 'asc']],
        processing: true,
        paging: false,
        dom: '<\"top\"iflp>rt<\"bottom\"><\"clear\">',
        rowCallback: function(row, data, dataIndex) {
          if ($('body').hasClass('dark')) {
            $(row).css('background-color', 'rgba(68,68,68,1)')
                  .css('color', 'white');
          } else {
            $(row).css('background-color', 'rgba(255,255,255,1)')
                  .css('color', 'rgba(68,68,68,1)');
        }
      },
        initComplete: function() {
          this.api().columns([1,2,3,4,5,6,7,8,9,10,11]).every (function() {
            var column = this;
            var select = $('<br><select><option value=\"\"></option></select>')
            .appendTo($(column.header()))
            .on('change', function() {
              var val = $.fn.dataTable.util.escapeRegex(
                $(this).val()
              );

              column
                .search(val ? '^'+val+'$' : '', true, false)
                .draw();
            });
  
            column.data().unique().sort().each(function (d,j) {
              select.append('<option value=\"'+d+'\">'+d+'</option>')
            });
          });
        }
      });
  });
    </script>
";
  } else {
    $returnString .= "<p class='text-center'>No results found</p>";
  }

echo $returnString;

?>
