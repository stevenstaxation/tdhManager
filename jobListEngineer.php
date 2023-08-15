<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$thisEngineer = ($_SESSION['userID']);

?>


<!DOCTYPE html>
<html>
	<head>
	<title>My Page</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- <link rel="stylesheet" href="https://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.css" />
	<script type="text/javascript" src="https://code.jquery.com/jquery-1.6.4.min.js"></script>
	<script type="text/javascript" src="https://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.js"></script> -->

</head>
<body>
<h5 class='text-center'>Jobs summary for <?php echo $_SESSION['userName']; ?></h5>

<div class='container'>
	<table class='table table-striped' id="engineerTable">
  		<thead>
    		<tr>
				<th style='display: none'>ID</th>
      			<th class='text-center'>Reg No</th>
				<th>Customer</th>
      			<th class='text-center'>Post Code</th>
      			<th class='text-center'>Date/Time</th>
    		</tr>
  		</thead>

		<?php
$sql = "SELECT tbljobs.ID, tblvehicle.regNumber, tblcustomer.businessName, tbljobs.bookingAddress, tbljobs.date FROM tblJobs
	INNER JOIN tblvehicle ON tbljobs.VRN = tblvehicle.ID
	INNER JOIN tblcustomer ON tbljobs.ownerID = tblcustomer.ID
	WHERE tbljobs.engineerid = 12 AND cast(date as date) = '2023-08-01'";
//  . $thisEngineer;

$result = mysqli_query($link, $sql);
echo "<tbody>";

while ($row = mysqli_fetch_array($result)) {
    $pattern = "/((GIR 0AA)|((([A-PR-UWYZ][0-9][0-9]?)|(([A-PR-UWYZ][A-HK-Y][0-9][0-9]?)|(([A-PR-UWYZ][0-9][A-HJKSTUW])|([A-PR-UWYZ][A-HK-Y][0-9][ABEHMNPRVWXY])))) [0-9][ABD-HJLNP-UW-Z]{2}))/i";
    preg_match($pattern, $row['bookingAddress'], $matches);
    if ($matches) {
        $postcode = $matches[0];
    } else {
        $pattern = "/((GIR 0AA)|((([A-PR-UWYZ][0-9][0-9]?)|(([A-PR-UWYZ][A-HK-Y][0-9][0-9]?)|(([A-PR-UWYZ][0-9][A-HJKSTUW])|([A-PR-UWYZ][A-HK-Y][0-9][ABEHMNPRVWXY]))))[0-9][ABD-HJLNP-UW-Z]{2}))/i";
        preg_match($pattern, $row['bookingAddress'], $matches);
        if ($matches) {
            $postcode = $matches[0];
        } else {
            $postcode = 'B928AT';
        }
    }

    $date = substr($row['date'], 8, 2) . "/" . substr($row['date'], 5, 2) . "/" . substr($row['date'], 0, 4);
    $time = substr($row['date'], 11, 5);

    echo " 	<tr>
				<td style='display: none'>" . $row['ID'] . "</td>
				<td class='text-center'>" . $row['regNumber'] . "</td>
				<td>" . $row['businessName'] . "</td>
				<td class='text-center'>" . $postcode . "</td>
				<td class='text-center'>" . $date . " at " . $time . "</td>
			</tr>";
}

?>
    	</tbody>
	</table>
</div>
<script>
     $(document).ready(function() {
      var table = $('#engineerTable').DataTable({
		paging: false,
		dom: '<\"top\"lf>rt<\"clear\">',
	  });
	})
</script>

</body>
</html>
