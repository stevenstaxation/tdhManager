<?php
session_start();
include ('connect.php');

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$completeFilter = $_POST['filteredStatus'];


$returnString = "
  <button class='btn btn-sm btn-success' style='margin: 3px 0; margin-right: 6px;' data-toggle='modal' data-target='#modalAddIssue'><svg xmlns='http://www.w3.org/2000/svg' width='32' height='32' fill='currentColor' class='bi bi-bug-fill' viewBox='0 0 16 16'><path d='M4.978.855a.5.5 0 1 0-.956.29l.41 1.352A4.985 4.985 0 0 0 3 6h10a4.985 4.985 0 0 0-1.432-3.503l.41-1.352a.5.5 0 1 0-.956-.29l-.291.956A4.978 4.978 0 0 0 8 1a4.979 4.979 0 0 0-2.731.811l-.29-.956z'/><path d='M13 6v1H8.5v8.975A5 5 0 0 0 13 11h.5a.5.5 0 0 1 .5.5v.5a.5.5 0 1 0 1 0v-.5a1.5 1.5 0 0 0-1.5-1.5H13V9h1.5a.5.5 0 0 0 0-1H13V7h.5A1.5 1.5 0 0 0 15 5.5V5a.5.5 0 0 0-1 0v.5a.5.5 0 0 1-.5.5H13zm-5.5 9.975V7H3V6h-.5a.5.5 0 0 1-.5-.5V5a.5.5 0 0 0-1 0v.5A1.5 1.5 0 0 0 2.5 7H3v1H1.5a.5.5 0 0 0 0 1H3v1h-.5A1.5 1.5 0 0 0 1 11.5v.5a.5.5 0 1 0 1 0v-.5a.5.5 0 0 1 .5-.5H3a5 5 0 0 0 4.5 4.975z'/></svg> New Issue or Feature Request</button>
  <button type='button' class='btn btn-lg btn-secondary mr-0 ml-0 pr-0 pl-0' disabled></button>
  <button class='btn btn-sm btn-primary' id='toggleCompletedIssues' style='margin: 3px 0; margin-left:6px;'><svg version='1.1' id='Layer_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' width='32px' height='32px' fill='currentColor' viewBox='0 0 122.879 79.699' enable-background='new 0 0 122.879 79.699' xml:space='preserve'><g><path d='M0.955,37.326c2.922-3.528,5.981-6.739,9.151-9.625C24.441,14.654,41.462,7.684,59.01,7.334 c6.561-0.131,13.185,0.665,19.757,2.416l-5.904,5.904c-4.581-0.916-9.168-1.324-13.714-1.233 c-15.811,0.316-31.215,6.657-44.262,18.533l0,0c-2.324,2.115-4.562,4.39-6.702,6.82c4.071,4.721,8.6,8.801,13.452,12.227 c2.988,2.111,6.097,3.973,9.296,5.586l-5.262,5.262c-2.782-1.504-5.494-3.184-8.12-5.039c-6.143-4.338-11.813-9.629-16.78-15.85 C-0.338,40.563-0.228,38.59,0.955,37.326L0.955,37.326L0.955,37.326z M96.03,0l5.893,5.893L28.119,79.699l-5.894-5.895L96.03,0 L96.03,0z M97.72,17.609c4.423,2.527,8.767,5.528,12.994,9.014c3.877,3.196,7.635,6.773,11.24,10.735 c1.163,1.277,1.22,3.171,0.226,4.507c-4.131,5.834-8.876,10.816-14.069,14.963C95.119,67.199,79.338,72.305,63.352,72.377 c-6.114,0.027-9.798-3.141-15.825-4.576l3.545-3.543c4.065,0.705,8.167,1.049,12.252,1.031c14.421-0.064,28.653-4.668,40.366-14.02 c3.998-3.191,7.706-6.939,11.028-11.254c-2.787-2.905-5.627-5.543-8.508-7.918c-4.455-3.673-9.042-6.759-13.707-9.273L97.72,17.609 L97.72,17.609z M61.44,18.143c2.664,0,5.216,0.481,7.576,1.359l-5.689,5.689c-0.619-0.079-1.248-0.119-1.886-0.119 c-4.081,0-7.775,1.654-10.449,4.328c-2.674,2.674-4.328,6.369-4.328,10.45c0,0.639,0.04,1.268,0.119,1.885l-5.689,5.691 c-0.879-2.359-1.359-4.912-1.359-7.576c0-5.995,2.43-11.42,6.358-15.349C50.02,20.572,55.446,18.143,61.44,18.143L61.44,18.143z M82.113,33.216c0.67,2.09,1.032,4.32,1.032,6.634c0,5.994-2.43,11.42-6.357,15.348c-3.929,3.928-9.355,6.357-15.348,6.357 c-2.313,0-4.542-0.361-6.633-1.033l5.914-5.914c0.238,0.012,0.478,0.018,0.719,0.018c4.081,0,7.775-1.652,10.449-4.326 s4.328-6.369,4.328-10.449c0-0.241-0.006-0.48-0.018-0.72L82.113,33.216L82.113,33.216z'/></g></svg> Toggle Completed Issues</button>  
  <hr>";

$returnString .= "
<div class='container'>
  <div id='issueLogList' class='listHeader'><h4><strong>Issues Log</strong></h4></div>
  <div id='issueFilter' class='d-none'>" .$completeFilter ."</div>
  <form id='issueForm' class='filterBox d-none'>
  </form>

";

// $sql = 'SELECT * FROM tblVehicle INNER JOIN tblDevice ON tblDevice.vehicleID = tblVehicle.ID INNER JOIN tblCustomer ON tblCustomer.ID = tblVehicle.ownerID';

$sql = "SELECT * FROM tblIssue WHERE status <> '$completeFilter'";



$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result)!=0) {
$returnString .="
<div id = 'issueSummary' class='ml-auto mr-auto' style='margin-top: 15px;'>
  <table id='issueListTable' class='table cell-border compact'>
    <thead>
      <tr class='text-center align-middle'>
        <th>Ref.</th>
        <th>Date</th>
        <th class='text-left'>Description</th>
        <th>Priority</th>
        <th>Status</th>  
        <th>Edit</th>
      </tr>
    </thead>

    <tbody>";


      while ($row = mysqli_fetch_array($result)) {

      $returnString .= "
      <tr>
        <td class='text-center align-middle' style='padding: 0 5px;'>" . $row['ID'] . "</td>
        <td class='align-middle' style='padding-left: 5px;' data-order='" .date('Y-m-d', strtotime($row['reportDate'])) . "'>" . date('d/m/Y', strtotime($row['reportDate'])) . "</td>
        <td class='align-middle'>" . $row['description'] . "</td>";
        switch ($row['priority']) {
          case '5':
            $returnString .="<td class='text-center align-middle' id='pCritical'>Critical</td>";
            break;
          case '4':
            $returnString .="<td class='text-center align-middle' id='pHigh'>High</td>";
            break;
          case '3':
            $returnString .="<td class='text-center align-middle' id='pMedium'>Medium</td>";
            break;
          case '2':
            $returnString .="<td class='text-center align-middle' id='pLow'>Low</td>";
            break;
          case '1':
            $returnString .="<td class='text-center align-middle' id='pBlueSky'>Blue Sky</td>";
            break;
          default:
            $returnString .="<td class='text-center align-middle' style='padding-left: 5px;'>N/A</td>";
            break;
        }
  
        switch ($row['status']) {
          case '7':
            $returnString .="<td class='text-center align-middle' style='padding-left: 5px; background-color:#DD66DD;'>More Info/Cannot Replicate</td>";
            break;
          case '6':
            $returnString .="<td class='text-center align-middle' style='padding-left: 5px; background-color:#a0ffff;'>For Correction</td>";
            break;
          case '5':
              $returnString .="<td class='text-center align-middle' style='padding-left: 5px; background-color:#00ff00;'>Completed</td>";
              break;
          case '4':
              $returnString .="<td class='text-center align-middle' style='padding-left: 5px; background-color:#FFbb00;'>For Review</td>";
              break;
          case '3':
              $returnString .="<td class='text-center align-middle' style='padding-left: 5px; background-color:#7F7F7F;'>In Progress</td>";
              break;
          case '2':
              $returnString .="<td class='text-center align-middle' style='padding-left: 5px;'>Not Started</td>";
              break;
          case '1':
              $returnString .="<td class='text-center align-middle' style='padding-left: 5px; background-color:#FF0000;'>Not Possible</td>";
              break;
          default:
            $returnString .="<td class='text-center align-middle' style='padding-left: 5px;'>N/A</td>";
            break;
        }
       
          $returnString .="
        <td class='text-center align-middle'><btn class='btn btn-sm btn-warning' onclick='showIssueForEdit(\"" . $row[0] . "\")'><svg xmlns='http://www.w3.org/2000/svg' width='12px' fill='currentColor' class='bi bi-pencil-fill' viewBox='0 0 16 16'><path d='M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z'/></svg></btn></td>";

          $returnString .="
      </tr>";
        }
    } else {
          $returnString .="<p class='text-center'>No results found</p>";
  
}

$returnString .= "
    </tbody>

    <tfoot>
      <tr class='text-center align-middle'>
        <th>Ref.</th>
        <th>Date</th>
        <th class='text-left'>Description</th>
        <th>Priority</th>
        <th>Status</th> 
        <th>Edit</th>
      </tr>
    </tfoot>

  </table>

</div>
</div>
<script>
    $(document).ready(function() {
      var issueTable = $('#issueListTable').DataTable({
        destroy: true,
        colReorder: true,
        order: [[1, 'asc']],
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
          this.api().columns([3,4]).every (function() {
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