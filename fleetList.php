<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$returnString = "<div id='fleetLongList' class='listHeader'><h4><strong>Global Fleet List</strong></h4></div>";

$sql = "SELECT tblcustomer.ID, tblcustomer.businessName, tblinsurer.insurerName, tblrenewaltype.Description FROM tblcustomer LEFT JOIN tblInsurer ON tblcustomer.insurerid = tblInsurer.ID LEFT JOIN tblrenewaltype ON tblcustomer.renewalType = tblrenewaltype.ID";
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) != 0) {
    $returnString .= "<div id = 'fleetSummary' class='m-4 w-2' style='margin-top: 15px;'>
      <table id='fleetListTable' class='table cell-border table-sm display compact'>
      <thead>
        <tr>
          <th class='text-center align-middle'><strong>No.</strong></th>
          <th class='align-middle'><strong>Fleet Name</strong></th>

          <th class='align-middle'>Insurer</th>
          <th class='align-middle'>Business Name 1</th>
          <th class='align-middle'>Business Contact 1</th>
          <th class='align-middle'>Business Telephone</th>
          <th class='align-middle'>Business Name 2</th>
          <th class='align-middle'>Business Contact 2</th>
          <th class='text-center align-middle'>Renewal Type</th>
          <th class='text-right align-middle'>Total Devices</th>
          <th class='text-right align-middle'>Installed Devices</th>
          <th class='text-center align-middle'>View Customer</th>
        </tr>
      </thead>

      <tbody>

      ";

    while ($row = mysqli_fetch_array($result)) {
        $sql = "SELECT tblcustomercontact.firstName, tblcustomercontact.lastName, tblcustomercontact.mobileNo, tblcustomercontact.telephone, tblcustomerContact.email FROM tblcustomercontact WHERE tblcustomercontact.businessID = '" . $row['ID'] . "' LIMIT 2";

        $contactResult = mysqli_query($link, $sql);
        $contact = [];
        $contactphone = [];
        $contactemail = [];

        while ($contactRow = mysqli_fetch_array($contactResult)) {

            array_push($contact, $contactRow['firstName'] . " " . $contactRow['lastName']);
            array_push($contactemail, $contactRow['email']);

            if ($contactRow['mobileNo']) {
                array_push($contactphone, $contactRow['mobileNo']);
            } elseif ($contactRow['telephone']) {
                array_push($contactphone, $contactRow['telephone']);
            } else {
                array_push($contactphone, '');
            }
        }

        if (count($contactphone) == 0) {
            $contactphone[0] = '';
        }
        switch (count($contact)) {
            case 0:
                array_push($contact, '');
                array_push($contact, '');
                break;
            case 1:
                array_push($contact, '');
                break;
        }
        switch (count($contactemail)) {
            case 0:
                array_push($contactemail, '');
                array_push($contactemail, '');
                break;
            case 1:
                array_push($contactemail, '');
                break;
        }

        $sql = "SELECT COUNT(tbldevice.ownerID) FROM tbldevice WHERE ownerID = '" . $row['ID'] . "'";
        $totalCountResult = mysqli_query($link, $sql);
        $totalCount = mysqli_fetch_array($totalCountResult);
        $sql = "SELECT COUNT(tbldevice.ownerID) FROM tbldevice WHERE ownerID = '" . $row['ID'] . "' AND (status='1' OR status='11')";
        $activeCountResult = mysqli_query($link, $sql);
        $activeCount = mysqli_fetch_array($activeCountResult);
        $returnString .= "<tr>
        <td class='align-middle'>" . $row['ID'] . "</td>";
        if ($row['Description'] == '' || $row['Description'] == null) {
            $returnString .= "<td class='align-middle' style='padding:0 3px; color: #FF4444'>" . $row['businessName'] . "</td>";
        } else {
            $returnString .= "      <td class='align-middle' style='padding:0 3px'>" . $row['businessName'] . "</td>";
        }
        $returnString .= "
      <td class='align-middle' style='padding:0 3px;'>" . $row['insurerName'] . "</td>
      <td class='align-middle' style='padding:0 3px;'>" . $contact[0] . "</td>
      <td class='align-middle' style='padding:0 3px;'>" . $contactemail[0] . "</td>
      <td class='align-middle' style='padding:0 3px;'>" . $contactphone[0] . "</td>
      <td class='align-middle' style='padding:0 3px;'>" . $contact[1] . "</td>
      <td class='align-middle' style='padding:0 3px;'>" . $contactemail[1] . "</td>
      <td class='text-center align-middle' style='padding:0 3px;'>" . $row['Description'] . "</td>
      <td class='text-right align-middle' style='padding:0 13px;'>" . $totalCount[0] . "</td>
      <td class='text-right align-middle' style='padding:0 13px;'>" . $activeCount[0] . "</td>
      <td class='text-center align-middle'><btn class='btn btn-sm btn-info' onclick='showCustomers(" . $row['ID'] . ")'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-person-vcard' viewBox='0 0 16 16'>
      <path d='M5 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm4-2.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5ZM9 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4A.5.5 0 0 1 9 8Zm1 2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5Z'/>
      <path d='M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2ZM1 4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H8.96c.026-.163.04-.33.04-.5C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1.006 1.006 0 0 1 1 12V4Z'/>
    </svg></btn></td>";
        $returnString .= "</tr>";

    }

    mysqli_free_result($result);
    unset($result);

} else {
    $returnString .= "<p class='text-center'>No results found</p>";
}
$returnString .= "</tbody>

  </table>

</div>
<script>
    // document.getElementById('byOther').addEventListener('keypress', function (event) {
    //     if (event.keyCode == 13) {
    //         event.preventDefault();
    //     }
    // });

    $(document).ready(function() {
        let alertColour = '#FFAA44';
        if ($('body').hasClass('dark')) {
            alertColour = '#fff035';
        }

        $('#fleetListTable').DataTable({
            columnDefs: [
                {
                    targets: 0,
                    visible: false,
                    searchable: false
                }
            ],
            order: [[1, 'asc'], [2,'asc']],
            processing: true,
            fixedHeader: true,
            pagingType: 'numbers',
            lengthMenu: [[5,10,25,50, 100, 250, 500, -1], [5,10,25,50, 100, 250, 500, 'All']],
            pageLength: 50,
            deferRender: true,
            responsive: true,
            orderClasses: false,
            rowCallback: function(row, data, dataIndex) {
                if ($('body').hasClass('dark')) {
                  $(row).css('background-color', 'rgba(68,68,68,1)')
                        .css('color', 'white');
                } else {
                  $(row).css('background-color', 'rgba(255,255,255,1)')
                        .css('color', 'rgba(68,68,68,1)');
              }
            }
        });
    });

    </script>
";

echo $returnString;
