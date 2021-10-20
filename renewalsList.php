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
$returnString = "<div id='alertLogList' class='listHeader'><h4><strong>Renewals</strong></h4></div>";

$returnString .= "<div class='container'>
<div id='renewalFilter'>
    <form id='renewalForm' class='filterBox' style='display: none'>
    <div id='renewalFilters' class='settings-dialog' style='border-width: 1px; border-style: solid; padding: 5px; width:100%' onSubmit='return false;'>
        <div class='form-group'>
          <div class='row'>
            <div class='col-sm-6 col-md-4 col-lg-3' style='padding:5px 15px'>
              <label for='byCustomer'>Customer</label>
               <div class='input-group'>
                  <select style='font-size: 75%' id='getCustomerSelect' name='getCustomerSelect' class='custom-select getCustomerSelect'>";

$sql = "SELECT ID, businessName FROM tblCustomer ORDER BY businessName ASC";
$result = mysqli_query($link, $sql);

$returnString .= "<option value= '0' selected='selected'>All customers</option>";

while ($customerRow = mysqli_fetch_array($result)) {
    if ($_POST['FilterCustomer'] == $customerRow['ID']) {
        $returnString .= "<option value= '" . $customerRow['ID'] . "' selected='selected'>";
    } else {
        $returnString .= "<option value= '" . $customerRow['ID'] . "'>";
    }
    $returnString .= $customerRow['businessName'] . " </option>";
}

$returnString .= "
                  </select>
                 </div>
            </div>
            <div class='col-sm-6 col-md-4 col-lg-3' style='padding:5px 15px'>
              <label for='byInsurer'>Insurer</label>
               <div class='input-group'>
                  <select style='font-size: 75%' id='getInsurerSelect' name='getInsurerSelect' class='custom-select getInsurerSelect'>";

$sql = "SELECT ID, insurerName FROM tblInsurer ORDER BY insurerName ASC";
$result = mysqli_query($link, $sql);

$returnString .= "<option value= '0' selected='selected'>All insurers</option>";

while ($insurerRow = mysqli_fetch_array($result)) {
    if ($_POST['FilterInsurer'] == $insurerRow['ID']) {
        $returnString .= "<option value= '" . $insurerRow['ID'] . "' selected='selected'>";
    } else {
        $returnString .= "<option value= '" . $insurerRow['ID'] . "'>";
    }
    $returnString .= $insurerRow['insurerName'] . " </option>";
}

$returnString .= "
                  </select>
                 </div>
            </div>
            <div class='col-sm-6 col-md-4 col-lg-3' style='padding:5px 10px'>
              <label for='VRNToLookup'>Search Term</label>
              <div class='input-group'>
                <input type='text' style='font-size: 75%; padding: 5px;' id='VRNToLookup' value='" . $_POST['FilterVRN'] . "' />
              </div>
            </div>
           
            <div class='col-sm-6 col-md-4 col-lg-3' style ='padding-left:15px; padding-top: 32px;'>
              <btn type='button' class='btn btn-success' id='renewalvehicleFilterClicked' style='border-radius: 5px;'>Apply Filter</button>
            </div>
          </div>
        </div>
    </form>
</div>




";

$sql = 'SELECT tblCustomer.businessName, tblCustomer.renewalDate, tblrenewalType.Description, tblInsurer.insurerName FROM tblCustomer LEFT JOIN tblRenewalType ON tblCustomer.renewalType = tblRenewalType.ID LEFT JOIN tblInsurer ON tblCustomer.insurerID = tblinsurer.ID';

if ($sqlFILTER) {
    $sql .= $sqlFILTER;
}


$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result)!=0) {

  $returnString .="<div id = 'renewalSummary' class='w-auto ml-auto mr-auto' style='margin-top: 15px;'>
  <table id='renewalsListTable' class='table cell-border compact'>
  <thead>
    <tr>
      <th class='text-center align-middle'>No.</th>
      <th class='text-center align-middle'>Customer</th>
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
        <td class='align-middle' style='padding-left: 3px;padding-right:3px'>" . $row['Description'] . "</td>
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
 document.getElementById('VRNToLookup').addEventListener('keypress', function (event) {
       if (event.keyCode == 13) {
            event.preventDefault();
        } 
    });

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