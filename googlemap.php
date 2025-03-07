<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}
?>

<HTML>

    <HEAD>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <script src='scripts/bootstrap-combobox.js'></script>

        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>

        <link rel="stylesheet" type="text/css" href="styles/styles.css">
        <link rel="stylesheet" type="text/css" href="styles/custombootstrap.css">
        <link rel='stylesheet' type='text/css' href='styles/bootstrap-combobox.css'>

        <script src='scripts/jobs.js'></script>

        <style>
            #map{
                width:100%;
                height:95%;
            }
        </style>
        <title>Jobs Booked Map</title>
    </HEAD>

    <BODY>

        <div class='container-fluid' style='margin: 10px;'>
            <div class='row'>
                <div class='col-3'>
                    <label for='engineerSelector'>Engineer</label>
                    <select id='engineerSelector'>
                        <option value=0>All Engineers</option>
                        <?php
$sql = "SELECT * FROM tblUsers WHERE tblUsers.isEngineer='1'";
$result = mysqli_query($link, $sql);
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    echo "<option value='" . $row['userID'] . "'>" . $row['userName'] . "</option>";
}
?>
                    </select>
                </div>
                <div class='col-6'>
                    <label>Jobs booked from</label>
                    <input type='date' id='startReportDate' value='<?php
$today = date('Y') . "-" . date('m') . "-" . date('d');
echo $today;
?>'>
                    <label> to </label>
                    <input type='date' id='endReportDate' value='<?php
$today = date('Y') . "-" . date('m') . "-" . date('d');
echo $today;
?>'
                </div>
                </div>
                <div class='col-1'>
                    <btn class='btn btn-success' id='updateMapView'>Update Map</btn>
                </div>
                <div class='col-2'>
                    <table>
                        <tbody>
                            <tr>
                                <td style='padding: 4px 5px;'><img src='images/pendingPin.png'></td><td style='padding: 4px 5px;'>Pending</td>
                                <td style='padding: 4px 5px;'><img src='images/bookedPassedPin.png'></td><td style='padding: 4px 5px;'>Booked - Date Passed</td>
                            </tr>
                            <tr>
                                <td style='padding: 4px 5px;'><img src='images/bookedPin.png'></td><td style='padding: 4px 5px;'>Booked</td>
                                <td style='padding: 4px 5px;'><img src='images/approvalPin.png'></td><td style='padding: 4px 5px;'>Awaiting Approval</td>
                            </tr>
                            <tr>
                                <td style='padding: 4px 5px;'><img src='images/completePin.png'></td><td style='padding: 4px 5px;'>Completed</td>
                                <td style='padding: 4px 5px;'><img src='images/cancelPin.png'></td><td style='padding: 4px 5px;'>Cancelled</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class='container-fluid'>
            <div id='map'>

            </div>
        </div>



<script>
    var dataToPost = {};
    var map;
    dataToPost.startDate = document.getElementById('startReportDate').value;
    dataToPost.endDate = document.getElementById('endReportDate').value;
    dataToPost.engineerID = document.getElementById('engineerSelector').value;

    var jobs = [];

$.ajax({
    url: 'getJobCoordinates.php',
    data: dataToPost,
    type: "POST",
    success: function(data) {
        data = $.parseJSON(data);

        $.each(data, function(index, element) {

            if (jobs.length > 0) {
                var matched = false;
                for (ix = 0; ix < jobs.length; ix++) {
                    if (jobs[ix]['latitude']== data[index]['latitude'] && jobs[ix]['longitude']== data[index]['longitude']) {
                        if (data[index]['latitude']==0 && data[index]['longitude']==0) {
                            data[index]['bookingAddress'] = "No Postcode entered, so set to Westbourne Road";
                        }
                        jobs[ix]['notes'] += "<b style='background-color: #DDFF00'>" + data[index]['userName'] + " has a job at " + data[index]['businessName'] + "</b><br>Address: " + data[index]['bookingAddress'] + "<br><br>" + data[index]['description'] + " at <b>" + data[index]['date'].substr(11,5) +" (" + data[index]['date'].substr(8,2) +"/" +  data[index]['date'].substr(5,2) +"/" +  data[index]['date'].substr(0,4)  +")</b><br>" + data[index]['notes'] + "<br>VRM: " + data[index]['regNumber'];
                        jobs[ix]['notes'] += "<br>Status: ";

                        switch (parseInt(data[index]['status'])) {
                            case 1:
                                jobs[ix]['notes'] += "Pending";
                                break;
                            case 2:
                                jobs[ix]['notes'] += "Booked";
                                break;
                            case 4:
                                jobs[ix]['notes'] += "Booked - date passed";
                                break;
                            case 8:
                                jobs[ix]['notes'] += "Awaiting approval";
                                break;
                            case 16:
                                jobs[ix]['notes'] += "Completed";
                                break;
                            case 32:
                                jobs[ix]['notes'] += "Cancelled";
                                break;
                        }
                        jobs[ix]['notes'] += "<hr>";
                        jobs[ix]['status'] = data[index]['status']
                        matched = true;
                    }

                }
                if (!matched) {
                    if (data[index]['latitude']== 0 && data[index]['longitude']==0) {
                            data[index]['bookingAddress'] = "No Postcode entered, so set to Westbourne Road";
                        }
                    newnote =  "<b style='background-color: #DDFF00'>" + data[index]['userName'] + " has a job at " + data[index]['businessName'] + "</b><br>Address: " + data[index]['bookingAddress'] + "<br><br>" + data[index]['description'] + " at <b>" + data[index]['date'].substr(11,5) +" (" + data[index]['date'].substr(8,2) +"/" +  data[index]['date'].substr(5,2) +"/" +  data[index]['date'].substr(0,4)  +")</b><br>" + data[index]['notes'] + "<br>VRM: " + data[index]['regNumber'];
                    newnote += "<br>Status: ";
                    switch (parseInt(data[index]['status'])) {
                        case 1:
                            newnote += "Pending";
                            break;
                        case 2:
                            newnote += "Booked";
                            break;
                        case 4:
                            newnote += "Booked - date passed";
                            break;
                        case 8:
                            newnote += "Awaiting approval";
                            break;
                        case 16:
                            newnote += "Completed";
                            break;
                        case 32:
                            newnote += "Cancelled";
                            break;
                    }
                    newnote +="<hr>";

                    newjob = {'latitude': data[index]['latitude'], 'longitude': data[index]['longitude'], 'notes': newnote, 'status': data[index]['status']};
                    jobs.push(newjob);
                }
            } else {
                if (data[index]['latitude']== 0 && data[index]['longitude']==0) {
                            data[index]['bookingAddress'] = "No Postcode entered, so set to Westbourne Road";
                        }
                newnote = "<b style='background-color: #DDFF00'>" + data[index]['userName'] + " has a job at " + data[index]['businessName'] + "</b><br>Address:" + data[index]['bookingAddress'] + "<br><br>" + data[index]['description'] + " at <b>" + data[index]['date'].substr(11,5) +" (" + data[index]['date'].substr(8,2) +"/" +  data[index]['date'].substr(5,2) +"/" +  data[index]['date'].substr(0,4)  +")</b><br>" + data[index]['notes'] + "<br>VRM: " + data[index]['regNumber'];
                    newnote += "<br>Status: ";
                    switch (parseInt(data[index]['status'])) {
                        case 1:
                            newnote += "Pending";
                            break;
                        case 2:
                            newnote += "Booked";
                            break;
                        case 4:
                            newnote += "Booked - date passed";
                            break;
                        case 8:
                            newnote += "Awaiting approval";
                        break;
                        case 16:
                            newnote += "Completed";
                            break;
                        case 32:
                            newnote += "Cancelled";
                            break;
                    }
                    newnote +="<hr>";

                    newjob = {'latitude': data[index]['latitude'], 'longitude': data[index]['longitude'], 'notes': newnote, 'status': data[index]['status']};
                    jobs.push(newjob);
                }


        // jobs[index] = new Array( data[index]['userName'] + " job at <b>" + data[index]['businessName'] + "</b><br>" + data[index]['bookingAddress'] + "<br><br>" + data[index]['description'] + " at <b>" + data[index]['date'].substr(11,5) +" (" + data[index]['date'].substr(8,2) +"/" +  data[index]['date'].substr(5,2) +"/" +  data[index]['date'].substr(0,4)  +")</b><br><br>" + data[index]['notes'] + "<br><br>VRM: " + data[index]['regNumber'], parseFloat(data[index]['latitude']), parseFloat(data[index]['longitude']), data[index]['userName'], data[index]['status']);

        });

        drawJobs(jobs);
    },
    error: function() {

    }
});

function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 7,
        center: {
            lat: 54.00366,
            lng: -2.547855
        },
    });
}

function drawJobs(jobs) {


    initMap;
    var infowindow = new google.maps.InfoWindow();
    var marker, i;
    var iconString;

    for (var i = 0; i < jobs.length; i++) {

        var job = jobs[i];
       
        switch (parseInt(job['status'])) {
            case 1:
                iconString = "images/pendingPinC.png";
                break;
            case 2:
                iconString = "images/bookedPin.png";
                break;
            case 4:
                iconString = "images/bookedPassedPin.png";
                break;
            case 8:
                iconString = "images/approvalPin.png";
                break;
            case 16:
                iconString = "images/completePin.png";
                break;
            case 32:
                iconString = "images/cancelPin.png";
                break;
            // default:
            //     iconString = "images/red_warning_24.png";
            //     break;
        }


        marker = new google.maps.Marker({
            animation: google.maps.Animation.DROP,
            position: {lat: parseFloat(job['latitude']), lng: parseFloat(job['longitude'])},
            map: map,
            icon: iconString
        });

        google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(jobs[i]['notes']);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }

}



</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDaZnGoSpVJxxv0BlCWreoo7cIqDF4aDFs&callback=initMap"></script>

</body>
</html>
