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
if (!isset($_POST['FilterVRN'])) {
  $_POST['FilterVRN'] = '';
}
if (!isset($_POST['FilterTDHNumber'])) {
  $_POST['FilterTDHNumber'] = '';
}
$returnString = "





  <button class='btn btn-sm btn-success' style='margin: 3px 0; margin-right: 6px;'><svg style='margin-right:4px;' xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-file-earmark-arrow-down-fill' viewBox='0 0 16 16'><path d='M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zm-1 4v3.793l1.146-1.147a.5.5 0 0 1 .708.708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 .708-.708L7.5 11.293V7.5a.5.5 0 0 1 1 0z'/></svg>Import CSV File</button>
  <button type='button' class='btn btn-lg btn-secondary mr-0 ml-0 pr-0 pl-0' disabled></button>
  <button class='btn btn-sm btn-primary' style='margin: 3px 6px;'><svg style='margin-right:4px;' xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-collection-fill' viewBox='0 0 16 16'><path d='M0 13a1.5 1.5 0 0 0 1.5 1.5h13A1.5 1.5 0 0 0 16 13V6a1.5 1.5 0 0 0-1.5-1.5h-13A1.5 1.5 0 0 0 0 6v7zM2 3a.5.5 0 0 0 .5.5h11a.5.5 0 0 0 0-1h-11A.5.5 0 0 0 2 3zm2-2a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 0-1h-7A.5.5 0 0 0 4 1z'/></svg>Group by Fleet</button>
  <button type='button' class='btn btn-lg btn-secondary mr-0 ml-0 pr-0 pl-0' disabled></button>
  <button class='btn btn-sm btn-primary' style='margin: 3px 0; margin-left:6px;'>Show Dismissed</button>
  
<hr>
<div id='alertLogList' class='listHeader'><h4><strong>Healthchecks</strong></h4></div>";

$returnString .= "
<div class='container'>
  <div id='healthcheckFilter'>
    <form id='healthcheckForm' class='filterBox d-none'>
      <div class='input-group'>
        <input type='text' style='font-size: 75%; padding: 5px;' id='VRNToLookup' value='" . $_POST['FilterVRN'] . "' />
      </div> 
    </form>
  </div>
</div>";


// $sql = 'SELECT * FROM tblVehicle INNER JOIN tblCustomer ON tblCustomer.ID = tblVehicle.ownerID';

$sql = 'SELECT tblCustomer.businessName, tblVehicle.regNumber, tblHealthStatus.Description, tblHealthCheck.healthCheckNotes FROM tblHealthCheck LEFT JOIN tblVehicle ON tblHealthCheck.vehicleID = tblVehicle.ID LEFT JOIN tblHealthStatus ON tblHealthCheck.healthStatusID = tblHealthStatus.ID LEFT JOIN tblCustomer ON tblCustomer.ID = tblVehicle.ownerID';

if ($sqlFILTER) {
    $sql .= $sqlFILTER;
}


$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result)!=0) {
$returnString .="<div id = 'healthcheckSummary' class='w-auto ml-auto mr-auto' style='margin-top: 15px;max-height: 75vh; overflow: auto;'>
<table id='healthcheckListTable' class='table cell-border compact'>
  <thead>
    <tr class='text-center align-middle'>
      <th>No.</th>
      <th>Customer</th>
      <th>Reg Number</th>
      <th>Status</th>
      <th>Notes</th>  
      <th style='width:5%'>Edit</th>
    </tr>
  </thead>

  <tbody>";

$ix = 1;
while ($row = mysqli_fetch_array($result)) {

    $returnString .= "<tr>
    <td class='text-center align-middle' style='padding: 0 5px;'>" . $ix . "</td>
    <td class='align-middle' style='padding-left: 5px;'>" . $row['businessName'] . "</td>
    <td class='text-center align-middle'>" . $row['regNumber'] . "</td>
    <td class='align-middle' style='padding-left: 5px;'>" . $row['Description'] . "</td>
    <td class='text-center align-middle'>" . $row['healthCheckNotes'] . "</td>   
    <td class='text-center align-middle'><btn class='btn btn-sm btn-warning' onclick='showHealthcheckForEdit(\"" . $row[0] . "vehicle\")'><svg xmlns='http://www.w3.org/2000/svg' width='12px' fill='currentColor' class='bi bi-pencil-fill' viewBox='0 0 16 16'>
  <path d='M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z'/>
</svg></btn></td>
    </tr>";
    $ix++;
}
} else {
  $returnString .="<p class='text-center'>No results found</p>";
}

  $returnString .= "
  </tbody>
  <tfoot>
    <tr class='text-center align-middle'>
      <th>No.</th>
      <th>Customer</th>
      <th>Reg Number</th>
      <th>Status</th>
      <th>Notes</th>  
      <th style='width:5%'>Edit</th>
    </tr>
  </tfoot>

</table>

</div>




<script>

  $(document).ready(function() {
    var groupColumn=1;
    $('#healthcheckListTable').DataTable({
      columnDefs: [
        {orderable: false, targets: 5 },
        {searchable: false, targets: 5 },
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
          this.api().columns([1,2,3,4]).every (function() {
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

echo $returnString;


?>