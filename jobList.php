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

$returnString = "<div id='hiddenCustomerID' style='display: none'></div><div id='deviceLongList' style = 'margin-top: 50px;margin-bottom: 20px;'><h4><strong>Job Requests</strong></h4></div>";

$returnString .= "<div class='container'>
<div id='jobListFilter'>
    <form id='deviceForm' class='filterBox' style='display: none'><div id='deviceFilters' class='settings-dialog' style='border-width: 1px; border-style: solid; padding: 5px; width:100%'>
        <div class='form-group'>
          <div class='row'>
            <div class='col-sm-6 col-md-4 col-lg-3' style='padding:5px 15px'>
              <label for='byCustomer'>Customer</label>
               <div class='input-group'>
                  <select style='font-size: 75%' id='getCustomerSelect' name='getCustomerSelect' class='custom-select getCustomerSelect'>";

                  $sql = "SELECT ID, businessName FROM tblCustomer ORDER BY businessName ASC";
                  $result = mysqli_query($link,$sql);
                  
                  $returnString .= "<option value= '0' selected='selected'>All customers</option>";

                  while ($customerRow = mysqli_fetch_array($result)) {
                    if ($_POST['FilterCustomer']== $customerRow['ID']) {
                      $returnString .= "<option value= '". $customerRow['ID']."' selected='selected'>";
                    } else {
                      $returnString .= "<option value= '". $customerRow['ID']."'>";
                    }
                      $returnString .= $customerRow['businessName']. " </option>";
                  }

                  $returnString .="
                  </select>
                 </div>
            </div>
            <div class='col-sm-6 col-md-4 col-lg-3' style='padding:5px 15px'>
              <label for='byDeviceType'>VRN</label>
               <div class='input-group'>
                  <select style='font-size: 75%' id='byDeviceType' name='byDeviceType' class='custom-select byDeviceType'>";

                  $sql = "SELECT * FROM tblVehicle ORDER BY regNumber ASC";
                  $result = mysqli_query($link,$sql);

                  $returnString .= "<option value= '0' selected='selected'>All vehicles</option>";

                  while ($deviceRow = mysqli_fetch_array($result)) {
                    if ($_POST['FilterType']== $deviceRow['ID']) {
                      $returnString .= "<option value= '". $deviceRow['ID']."' selected='selected'>";
                    } else {
                      $returnString .= "<option value= '". $deviceRow['ID']."'>";
                    }
                      $returnString .= $deviceRow['regNumber']. " </option>";
                  }

                  $returnString .="
                  </select>
                 </div>
            </div>

            <div class='col-sm-6 col-md-4 col-lg-3' style='padding:5px 15px;'>
              <label for='byOther'>Other Search Term</label>
              <div class='input-group'>
                <input type='text' style='font-size:75%; padding: 5px;' id='byOther' value='" . $_POST['FilterOtherTerm'] . "'/>
              </div>
            </div>
          </div>
          <div class='row'>
   
            <div class='col-md-3' style='padding:5px 15px; margin-left:30px;'>
              <label class='form-check-label' for='showOutstanding' style='padding-top:10px;'>Outstanding</label>
              <input type='checkbox' class='form-check-input' value='checked' id='showOutstanding' style='margin: 10px 15px;padding: 6px 6px;'>
            </div>
            <div class='col-md-3' style='padding:5px 15px; margin-left:30px;'>
              <label class='form-check-label' for='showCompleted' style='padding-top:10px;'>Completed&nbsp;&nbsp;</label>
              <input type='checkbox' class='form-check-input' value='checked' id='showCompleted' style='margin: 10px 15px;padding: 6px 6px;'>
            </div>
            <div class='col-md-3' style='padding:5px 15px; margin-left:30px'>
              <btn type='button' class='btn btn-sm btn-success' id='jobFilterClicked' style='border-radius: 5px;'>Apply Filter/Search</button>
            </div>



     
          </div>
        </div>
    </form>
  </div>
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
      
      $returnString .= "<div id = 'deviceSummary' style='margin-top: 15px;'>
      <table id='jobListTable' class='table table-sm table-bordered table-hover w-auto ml-auto mr-auto' style='font-size: 75%'>
      <thead>
        <tr>
            <th class='text-center align-middle' style='padding:0 3px;'>Date</th>
            <th class='align-middle' style='padding:0 3px;'><strong>Fleet</strong></th>
            <th class='align-middle' style='padding:0 3px;'>Job Type</th>
            <th class='text-center align-middle' style='padding:0 3px;'>VRN</th>
            <th class='align-middle' style='padding:0 3px;'>Notes</th>
            <th class='text-center align-middle' style='padding: 0 3px;'>Edit</th>
            <th class='text-center align-middle' style='padding: 0 3px;'>Notes</th>
        </tr>
      </thead>
    
      <tbody>";
  while ($row= mysqli_fetch_array($result)) {
    if ($row['status']==1) {
      $rowBackground = 'rgba(204,49,64,0.3)';
    } else {
      $rowBackground = 'rgba(23,125,68,0.3)';
    }
    $returnString .= "<tr style='background-color: $rowBackground'>
    <td class='text-center align-middle' style='padding:0 3px;'>" . date('d/m/Y', strtotime($row['date'])) . "</td> 
    <td class='align-middle' style='padding:0 3px;'>" . $row['businessName'] . "</td>
    <td class='align-middle' style='padding:0 3px;'>" . $row['description'] . "</td>
    <td class='text-center align-middle' style='padding:0 3px;'>" . $row['regNumber']. "</td>
    <td class='align-middle' style='padding:0 3px'>" . $row['notes'] . "</td>";
    
    if ($row['status']==1) {
      $returnString .= "<td class='text-center align-middle' style='width:3%'><btn class='btn btn-sm btn-warning' onclick='showFullJob(\"" . $row[0]."editj\")'><svg xmlns='http://www.w3.org/2000/svg' width='16px' fill='currentColor' class='bi bi-pencil-fill' viewBox='0 0 16 16'>
  <path d='M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z'/>
</svg></btn></td>";
    } else {
      $returnString .= "<td class='text-center align-middle' style='width:3%'><btn class='btn btn-sm btn-warning' onclick='showFullJob(\"" . $row[0]."viewj\")'><svg xmlns='http://www.w3.org/2000/svg' width='16px' fill='currentColor' class='bi bi-pencil-fill' viewBox='0 0 16 16'>
  <path d='M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z'/>
</svg></btn></td>";
}

$returnString .= "
<td class='text-center align-middle' style='width:3%'><btn class='btn btn-sm btn-info' onclick='window.alert(\"not implemented yet\")'><svg xmlns='http://www.w3.org/2000/svg' width='16px' fill='currentColor' class='bi bi-card-text' viewBox='0 0 16 16'>
<path d='M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z'/>
<path d='M3 5.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 8zm0 2.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z'/>
</svg></btn></td>

    </tr>";
  } 

  $returnString .="</tbody>
  <tfoot>
  <tr>
      <th class='text-center align-middle' style='padding:0 3px;'>Date</th>
      <th class='align-middle' style='padding:0 3px;'><strong>Fleet</strong></th>
      <th class='align-middle' style='padding:0 3px;'>Job Type</th>
      <th class='text-center align-middle' style='padding:0 3px;'>VRN</th>
      <th class='align-middle' style='padding:0 3px;'>Notes</th>
      <th class='text-center align-middle' style='padding: 0 3px;'><<</th>
      <th class='text-center align-middle' style='padding: 0 3px;'>Filter</th>
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
          {orderable: false, targets: [5,6] },
          {searchable: false, targets: [5,6] }
        ],
        colReorder: true,
        order: [[0, 'asc']],
        pagingType: 'simple_numbers' ,
        processing: true,
        lengthMenu: [[10,25,50,100,-1], [10, 25,50, 100, 'All']],
        initComplete: function() {
          this.api().columns([0,1,2,3,4]).every (function() {
            var column = this;
            var select = $('<select><option value=\"\"></option></select>')
            .appendTo($(column.footer()).empty())
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
