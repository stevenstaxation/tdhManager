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

$returnString = "<div id='hiddenCustomerID' style='display: none'></div><div id='deviceLongList' class='listHeader'><h4><strong>Job Requests</strong></h4></div>";

$returnString .= "
<div class='container'>
  <div id='jobListFilter'>
    <form id='deviceForm' class='filterBox' style='display: none'><div id='deviceFilters' class='settings-dialog' style='border-width: 1px; border-style: solid; padding: 5px; width:100%'>
      <div class='input-group'>
        <input type='text' style='font-size:75%; padding: 5px;' id='byOther' value='" . $_POST['FilterOtherTerm'] . "'/>
      </div>
    </form>
  </div>
</div>
";

  $sql = 'SELECT tblJobs.ID, tblJobs.ownerID,  tblJobs.date, tblJobs.jobType, tblJobType.description, tblJobs.VRN, tblVehicle.regNumber, tblJobs.notes, tblCustomer.businessName, tblJobs.status 
  
  FROM tblJobs INNER JOIN tblVehicle ON tblJobs.VRN = tblVehicle.ID INNER JOIN tblJobType ON tblJobs.jobType = tblJobType.ID INNER JOIN tblCustomer ON tblCustomer.ID = tblJobs.ownerID';

    if ($sqlFILTER) {
      $sql .= $sqlFILTER;
    }


  $result = mysqli_query($link, $sql);

    if (mysqli_num_rows($result) !=0) {
      
      $returnString .= "<div id = 'deviceSummary' class='w-auto ml-auto mr-auto' style='margin-top: 15px;'>
      <table id='jobListTable' class='table cell-border compact'>
      <thead>
        <tr>
            <th class='text-center align-middle'>Date</th>
            <th class='text-left align-middle'><strong>Fleet</strong></th>
            <th class='text-left align-middle'>Job Type</th>
            <th class='text-center align-middle'>VRN</th>
            <th class='text-center align-middle'>Status</th>
            <th class='text-center align-middle'>Notes</th>
            <th class='text-center align-middle'>Edit</th>
            <th class='align-middle'>Notes</th>
        </tr>
      </thead>
    
      <tbody>";
  while ($row= mysqli_fetch_array($result)) {
    if ($row['status']==1) {
      $rowBackground = 'Open';
    } else {
      $rowBackground = 'Complete';
    }
    $returnString .= "<tr>
    <td class='text-center align-middle' style='padding:0 3px;'>" . date('d/m/Y', strtotime($row['date'])) . "</td> 
    <td class='align-middle' style='padding:0 3px;'>" . $row['businessName'] . "</td>
    <td class='align-middle' style='padding:0 3px;'>" . $row['description'] . "</td>
    <td class='text-center align-middle' style='padding:0 3px;'>" . $row['regNumber']. "</td>
    <td class='text-center align-middle'>" . $rowBackground . "</td>
    <td class='align-middle' style='padding:0 3px'>" . $row['notes'] . "</td>";
    
    if ($row['status']==1) {
      $returnString .= "<td class='text-center align-middle' style='width:1%'><btn class='btn btn-sm btn-warning' onclick='showFullJob(\"" . $row[0]."editj\")'><svg xmlns='http://www.w3.org/2000/svg' width='16px' fill='currentColor' class='bi bi-pencil-fill' viewBox='0 0 16 16'>
  <path d='M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z'/>
</svg></btn></td>";
    } else {
      $returnString .= "<td class='text-center align-middle' style='width:1%'><btn class='btn btn-sm btn-warning' onclick='showFullJob(\"" . $row[0]."viewj\")'><svg xmlns='http://www.w3.org/2000/svg' width='16px' fill='currentColor' class='bi bi-pencil-fill' viewBox='0 0 16 16'>
  <path d='M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z'/>
</svg></btn></td>";
}

$returnString .= "
<td class='text-center align-middle' style='width:1%'><btn class='btn btn-sm btn-info' onclick='window.alert(\"not implemented yet\")'><svg xmlns='http://www.w3.org/2000/svg' width='16px' fill='currentColor' class='bi bi-card-text' viewBox='0 0 16 16'>
<path d='M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z'/>
<path d='M3 5.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 8zm0 2.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z'/>
</svg></btn></td>

    </tr>";
  } 

  $returnString .="</tbody>
  <tfoot>
  <tr>
      <th class='text-center align-middle'>Date</th>
      <th class='text-left align-middle'><strong>Fleet</strong></th>
      <th class='text-left align-middle'>Job Type</th>
      <th class='text-center align-middle'>VRN</th>
      <th class='text-center align-middle'>Status</th>
      <th class='text-center align-middle'>Notes</th>
      <th class='text-center align-middle'>Edit</th>
      <th class='align-middle'>Notes</th>
  </tr>
</tfoot>

  </table>

</div>
<div id='hiddenJobID' style='display: none'></div>
<script>
 document.getElementById('byOther').addEventListener('keypress', function (event) {
       if (event.keyCode == 13) {
            event.preventDefault();
        } 
    });

    $(document).ready(function() {
      $('#jobListTable').DataTable({
        columnDefs: [
          {orderable: false, targets: [6,7] },
          {searchable: false, targets: [6,7] }
        ],
        colReorder: true,
        order: [[0, 'asc']],
        processing: true,
        paging: false,
        responsive: true,
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
          this.api().columns([0,1,2,3,4,5]).every (function() {
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
