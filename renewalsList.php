<?php
session_start();
include ('connect.php');

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$returnString = "<div id='alertLogList' class='listHeader'><h4><strong>Renewals</strong></h4></div>";

$returnString .= "<div class='container'>";

$sql = 'SELECT tblCustomer.businessName, tblCustomer.renewalDate, tblrenewalType.Description, tblInsurer.insurerName FROM tblCustomer LEFT JOIN tblRenewalType ON tblCustomer.renewalType = tblRenewalType.ID LEFT JOIN tblInsurer ON tblCustomer.insurerID = tblinsurer.ID';


$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result)!=0) {

  $returnString .="<div id = 'renewalSummary' class='w-auto ml-auto mr-auto' style='margin-top: 15px;'>
  <table id='renewalsListTable' class='table cell-border compact'>
  <thead>
    <tr>
      <th class='text-center align-middle'>No.</th>
      <th class='align-middle'>Customer</th>
      <th class='text-center align-middle'>Renewal Type</th>
      <th class='text-center align-middle'>Renewal Date</th>
      <th class='text-centeralign-middle'>Insurer</th>
    </tr>
  </thead>

  <tbody>";

  $ix = 1;
  $noRenewalDate = 0;

  while ($row = mysqli_fetch_array($result)) {
    if (!$row['renewalDate']) {
      $noRenewalDate++;
    } else {
      $returnString .= "
      <tr>
        <td class='text-right align-middle' style='padding-right: 20px;'>" . $ix . "</td>
        <td class='align-middle' style='padding-left: 3px;padding-right:3px'>" . $row['businessName'] . "</td>
        <td class='text-center align-middle' style='padding-left: 3px;padding-right:3px'>" . $row['Description'] . "</td>
        <td class='text-center align-middle' style='padding-left: 3px;padding-right:3px' data-order='" .date('Y-m-d', strtotime($row['renewalDate'])) ."'>" . date('d/m/Y', strtotime($row['renewalDate'])) . "</td>
        <td class='align-middle' style='padding-left: 3px;padding-right:3px' >" . $row['insurerName'] . "</td>
      </tr>";
      $ix++;
    }
  }
} else {
  $returnString .="<p class='text-center'>No results found</p>";
}

$returnString .= "</tbody>
<tfoot>
    <tr>
        <th class='text-center align-middle'>No.</th>
        <th class='text-center align-middle'>Customer</th>
        <th class='text-center align-middle'>Renewal Type</th>
        <th class='text-center align-middle'>Renewal Date</th>
        <th class='text-center align-middle'>Insurer</th>
    </tr>
</tfoot>

</table>";

if ($noRenewalDate!=0) {
  $returnString .="<p style='margin-top: 20px' class='alert alert-info listNoteInfo'><small>NOTE: There are " . $noRenewalDate . " customers without a renewal date entered.  These are not shown in this list</small></p>";
}  

$returnString .="
</div>
<script>

    $(document).ready(function() {
      $('#renewalsListTable').DataTable({
        order: [[3, 'asc']],
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