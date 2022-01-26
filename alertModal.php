<?php
session_start();
include('connect.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$returnString= "<script>
$(document).ready(function() {
    $('.dismissButton').on('click' , function() {
        var dataToPost = {};
        var vRow = $(this).closest('tr');
        dataToPost.rowNumber = vRow.find('.nr').text();
        $.ajax ({
            url: 'removeAlert.php',
            type: 'POST',
            data: dataToPost,
            success: function(data) {
                $.ajax ({
                    url: 'alertModal.php',
            type: 'POST',
            success: function(data) {
                $('.rowAlert').html(data);

                $.ajax ({
                    url: 'getAlerts.php',
                    type: 'GET',
                    success: function(data) {
                        var arr = data.split('^^^');

                        if ((arr[0]+arr[1]) !=0) {
                            $('#renewalTotal').html(+arr[0] + +arr[1]);
                            $('#renewalTotal').show();
                        } else {
                            $('#renewalTotal').hide();
                        }
                        if (arr[3]!=0) {
                            $('#installTotal').html(arr[3]);
                            $('#installTotal').show();
                        } else {
                            $('#installTotal').hide();
                        }
                        if (arr[2]!=0) {
                            $('#alertTotal').html(arr[2]);
                            $('#alertTotal').show();
                        } else {
                            $('#alertTotal').hide();
                        }
                    }
                });
            },
            error: function() {
            }
        });
            },
            error: function() {

            }
        })

    });
});
</script>
<table class='table table-bordered table-hover table-sm'>
                    <thead>
                        <tr>
                            <th style='display: none'></th>
                            <th class='text-center' style='width:10%'>Date</th>
                            <th style='width:30%'>Customer</th>
                            <th style='width:50%'>Description</th>
                            <th class='text-center'>Owner</th>
                            <th class='text-center' style='width:5%'>Dismiss</th>
                        </tr>
                    </thead>

                    <tbody>";


                    $_SESSION['Alerts'] = getAlerts($link);


                    foreach($_SESSION['Alerts'] as $alert) {
                        if ($alert['alertType']==3) {
//                            if ($alert['days']<=0) {
                                $returnString .= "<tr class='table-danger'>";
//                            } else {
//                                $returnString .= "<tr>";
//                            }

                            $returnString .= "<td style='display: none;' class='nr align-middle'><span>" . $alert['noteID'] . "</span></td>";
                            $returnString .= "<td class='text-center align-middle'>" . substr($alert['date'],8,2) ."/" . substr($alert['date'],5,2) . "/" . substr($alert['date'],0,4) . "</td>
                                <td class='align-middle'>" . $alert['customername'] . "</td>
                                <td class='align-middle'>" . $alert['text'] . "</td>
                                <td class='text-center align-middle'>" . $alert['owner'] . "</td>";


//                            if ($alert['userID'] == $_SESSION['userID'] || ($alert['userID']==0 && $_SESSION['isAdmin']==1)) {
                                if ($alert['userID'] == $_SESSION['userID'] || ($_SESSION['isAdmin']==1)) {
                                    $returnString .= "<td><btn class='btn btn-secondary btn-sm dismissButton' style='height: 2.2vh'>Dismiss</td>";
                                } else {
                                    $returnString .= "<td><btn class='btn btn-secondary btn-sm disabled'>Dismiss</td>";
                                }

                                $returnString .= "</tr>";
                            }
                        }

                     $returnString .="
                     </tbody>
                    </table>

                    <h5 class='modal-title' style='color:green; margin-top: 20px;'><strong>Installs coming up</strong></h5>
                    <table class='table table-bordered table-sm'>
                        <thead>
                            <th style='width:80%'>Description</th>
                        </thead>
                        <tbody>";

                            foreach ($_SESSION['Alerts'] as $alert) {
                                if ($alert['alertType']==4) {
                                      $returnString .= "<tr class='table-primary'><td>" . $alert['text'] . "</td></tr>";
                                 }
                            }

                    $returnString .="
                    </tbody>
                    </table>

                    <h5 class='modal-title' style='color:green; margin-top:20px;'><strong>Impending Renewals</strong></h5>
                    <table class='table table-bordered table-sm'>
                        <thead>
                            <th style='width:80%'>Description</th>
                        </thead>
                        <tbody>";

                            foreach ($_SESSION['Alerts'] as $alert) {
                                if ($alert['alertType']==1 || $alert['alertType']==2) {
//                                    if ($alert['days']<=30) {
                                        $returnString .= "<tr class='table-warning'><td>" . $alert['text'] . "</td></tr>";
//                                    } else {
//                                        $returnString .= "<tr><td>" . $alert['text'] . "</td></tr>";
//                                    }
                                }
                            }

                    $returnString .="
                    </tbody>
                    </table>";

echo $returnString;


function getAlerts($link) {
$sql = 'SELECT * FROM tblCustomer';
$result = mysqli_query($link, $sql);
    $alerts=[];
    $dateNow = new dateTime();

    while ($alertRows = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

      if (!$alertRows['renewalDate']) {
        $daysToRenewal = -1;
      } else {
        $renewalDate = new DateTime($alertRows['renewalDate']);
        $daysToRenewal = $dateNow->diff($renewalDate)->format('%r%a');
      }
        // renewals due within 30 or fewer days
        if ($daysToRenewal<=30 && $daysToRenewal>=0) {
            $alert['date'] = $renewalDate->format('Y-m-d H:i');
            $alert['alertType'] = 1;
            $alert['days'] = $daysToRenewal;
            $alert['customerID'] = $alertRows['ID'];
            $alert['text'] = $alertRows['businessName'] . " is due ";
            switch (intval($alert['days'])) {
                case 0:
                    $alert['text'] .= "today";
                    break;
                case 1:
                    $alert['text'] .= "tomorrow";
                    break;
                default:
                    $alert['text'] .= "in " . $alert['days'] . " days";
            }

            $alert['owner'] = '-';
            $alert['userID'] = 0;
            $alert['noteID'] = 0;
            array_push($alerts,$alert);
        }
        // renewals due within 31-60 days
        if ($daysToRenewal<=60 && $daysToRenewal>30) {
            $alert['date'] = $renewalDate->format('Y-m-d H:i');
            $alert['alertType'] = 2;
            $alert['days'] = $daysToRenewal;
            $alert['customerID'] = $alertRows['ID'];
            $alert['text'] = $alertRows['businessName'] . " renewal is due in " . $alert['days'] . " days";
            $alert['owner'] = '-';
            $alert['userID'] = 0;
            $alert['noteID'] = 0;
            array_push($alerts,$alert);
        }
    }

    $interval = new DateInterval('P30D');
    $dateNow->add($interval);

    $sql = "SELECT * FROM tblCustomerNote INNER JOIN tblUsers ON tblCustomerNote.userID = tblUsers.userID INNER JOIN tblCustomer ON tblCustomerNote.customerID = tblCustomer.ID WHERE (noteDate <= '" . $dateNow->format('Y-m-d H:i') ."' AND isAnAlert='1')";

    $result = mysqli_query($link, $sql);
    if ($result) {
        while ($noteRows = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $alert['date'] = $noteRows['noteDate'];
            $alert['alertType'] = 3;
            $alertDate = new DateTime($noteRows['noteDate']);
            $alert['days'] = $dateNow->diff($alertDate)->format('%r%a');
            $alert['customerID'] = $noteRows['customerID'];
            $alert['customername'] = $noteRows['businessName'];
            $alert['text'] = $noteRows['noteText'];
            $alert['owner'] = $noteRows['userName'];
            $alert['userID'] = $noteRows['userID'];
            $alert['noteID'] = $noteRows['cnID'];
            array_push($alerts,$alert);
        }
    }

    $dateNow = new dateTime();

    $sql = "SELECT * FROM tblDevice INNER JOIN tblCustomer ON tblCustomer.ID = tblDevice.ownerID INNER JOIN tblVehicle ON tblDevice.vehicleID = tblVehicle.ID WHERE (installDate >= '" . $dateNow->format('Y-m-d') ."')";

    $result = mysqli_query($link, $sql);

    if ($result) {
        while ($noteRows = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $alert['date'] = $noteRows['installDate'];
            $alert['alertType'] = 4;
            $alert['text'] = "Install for " .$noteRows['businessName'] ." (" .$noteRows['regNumber'] . ") is booked for " . date('d/m/Y', strtotime($noteRows['installDate'])) ;
            $alert['owner'] = "-";
            $alert['userID'] = 0;
            $alert['noteID'] = 0;
            array_push($alerts,$alert);
        }
    }
    sort($alerts);
    return $alerts;
}

                    ?>
