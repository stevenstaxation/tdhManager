<div class="navigation-wrap bg-light start-header start-style" id='navbar-wrapper'>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <nav class="navbar navbar-expand-xl navbar-light sticky-top" id='mainNavBar'>

                    <a class="navbar-brand" href="#"><img src="images/logo_swirl.png" alt="DataHub Logo" title='Click to toggle Dark Mode' id='companyLogo' style='margin-right: 10px;'><strong>TDH Manager</strong></a>

                    <!-- <img src='images/fastX.png'><p id="countdown" style='margin-top:14px; margin-left: 10px; color: lightgreen'></p> -->

                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class='navbar-nav ml-auto py-4 py-xl-0'>
                    
                <?php
if ($_SESSION['isInstaller'] == '0' && $_SESSION['isEngineer'] == '0') {
    echo "
                    <ul class='navbar-nav ml-auto py-4 py-xl-0'>
                        <li id='homeMenu' class='nav-item pl-4 pl-xl-0 ml-0 ml-xl-4'>
                            <a class='nav-link willCollapse' href='#'>
                                <i class='bi bi-house-fill h4'></i>
                                Home
                            </a>
                        </li>

                        <li id='fleetMenu' class='nav-item pl-4 pl-xl-0 ml-0 ml-xl-4'>
                            <a class='nav-link willCollapse' href='#'>
                                <i class='bi bi-truck-front-fill h4'></i>
                                Fleets
                            </a>
                        </li>


                        <li id='customerMenu' class='nav-item pl-4 pl-xl-0 ml-0 ml-xl-4'>
                            <a class='nav-link willCollapse' href='#'>
                                <i class='bi bi-person-vcard-fill h4'></i>
                                Customer
                            </a>
                        </li>";
}
?>
                        <li id='showDeviceList' class='nav-item pl-4 l-xl-0 ml-0 ml-xl-4'>
                            <a class='nav-link willCollapse' href='#'>
                                <i class='bi bi-camera-fill h4'></i>
                                Devices
                            </a>
                        </li>
<?php
if ($_SESSION['isInstaller'] == '0' && $_SESSION['isEngineer'] == '0') {
        echo "
                        <li id='showVehicleList' class='nav-item pl-4 pl-xl-0 ml-0 ml-xl-4'>
                            <a class='nav-link willCollapse' href='#'>
                                <i class='bi bi-truck h4'></i> 
                                Vehicles
                            </a>
                        </li>
                        <li id='showFootageList' class='nav-item pl-4 pl-xl-0 ml-0 ml-xl-4'>
                            <a class='nav-link willCollapse' href='#'>
                                <i class='bi bi-camera-reels-fill h4'></i>
                                Footage
                            </a>
                        </li>
                        <li id='showRenewalList' class='nav-item pl-4 pl-xl-0 ml-0 ml-xl-4'>
                            <a class='nav-link willCollapse' href='#'>
                                <i class='bi bi-alarm-fill h4'></i>
                                Renewals
                            </a>
                        </li>
                        ";
}
?>

                        <li id='showJobList' class="nav-item pl-4 pl-xl-0 ml-0 ml-xl-4">
                            <a class="nav-link willCollapse" href="#">
                                <i class='bi bi-inboxes-fill h4'></i>
                                Jobs
                            </a>
                        </li>
<?php
if ($_SESSION['isInstaller'] == '0' && $_SESSION['isEngineer'] == '0') {
    echo "
                        <li id='showEventDashboard' class='nav-item pl-4 pl-xl-0 ml-0 ml-xl-4'>
                            <a class='nav-link willCollapse' href='#' style='text-align: center'>
                                <i class='bi bi-speedometer h4'></i>
                                Events Dashboard
                            </a>
                        </li>
                        <li class='nav-item dropdown pl-4 pl-xl-0 ml-0 ml-xl-4'>
                            <a class='nav-link dropdown-toggle' data-toggle='dropdown' href='#' role='button' aria-haspopup='true' aria-expanded='true' id='dropdownMenuButton'>
                                <i class='bi bi-flag-fill h4'></i>
                                Reports
                            </a>
                            <ul class='dropdown-menu'>
                                <li>
                                    <a class='dropdown-item willCollapse' href='#' id='currentVehicles'> Current Vehicles (customer)</a>
                                    <div class='dropdown-divider'></div>
                                    <a class='dropdown-item willCollapse' href='#' id='barlowVehicles'> Barlow Vehicles (all)</a>
                                    <div class='dropdown-divider'></div>
                                    <a class='dropdown-item willCollapse' href='#' id='somersetVehicles'> Somerset Live Vehicles</a>
                                </li>
                            </ul>
                        </li>
                        <li data-toggle='modal' data-target='#modalShowAlerts' class='nav-item pl-4 pl-xl-0 ml-0 ml-xl-4'>
                            <a class='nav-link willCollapse' href='#'>
                                <i class='bi bi-bell-fill h4'></i>
                                Alerts
                                <a id='alertTotalWrapper'><sup><span class='badge badge-danger'><div id='alertTotal'></div></span></sup></a>
                                <a id='installTotalWrapper'><sup><span class='badge badge-primary'><div id='installTotal'></div></span></sup></a>
                                <a id='renewalTotalWrapper'><sup><span class='badge badge-warning'><div id='renewalTotal'></div></span></sup></a>
                            </a>
                        </li>";
}

if ($_SESSION['isAdmin'] == '1') {
    echo "
                        <li class='nav-item dropdown pl-4 pl-xl-0 ml-0 ml-xl-2'>
                            <a class='nav-link dropdown-toggle' data-toggle='dropdown' href='#' role='button' aria-haspopup='true' aria-expanded='true' id='dropdownMenuButton'>
                                <i class='bi bi-wrench-adjustable h4'></i>
                                Admin
                            </a>
                            <ul class='dropdown-menu'>
                                <li id='showContactList' class='dropdown-submenu pl-0 pl-xl-0 ml-0 ml-xl-0'>
                                    <a class='dropdown-item dropdown-toggle' data-toggle='dropdown' href='#' role='button' aria-haspopup='true' aria-expanded='true'>
                                        <i class='bi bi-telephone-fill h5'></i>
                                        Partners
                                    </a>

                                    <ul class='dropdown-menu'>
                                        <a class='dropdown-item willCollapse' href='#' id='showInsurers'>
                                            <i class='bi bi-person-lines-fill h5'></i>
                                            Insurers
                                        </a>
                                        <div class='dropdown-divider'></div>
                                        <a class='dropdown-item willCollapse' href='#' id='showSuppliers'>
                                            <i class='bi bi-person-lines-fill h5'></i>
                                            Suppliers
                                        </a>
                                        <div class='dropdown-divider'></div>
                                        <a class='dropdown-item willCollapse' href='#' id='showBrokers'>
                                            <i class='bi bi-person-lines-fill h5'></i> 
                                            Brokers
                                        </a>
                                         <div class='dropdown-divider'></div>
                                        <a class='dropdown-item willCollapse' href='#' id='showInstallers'>
                                            <i class='bi bi-person-lines-fill h5'></i> 
                                            Installers
                                        </a>
                                        <div class='dropdown-divider'></div>
                                        <a class='dropdown-item willCollapse' href='#' id='showOthers'>
                                            <i class='bi bi-person-lines-fill h5'></i>
                                            Others
                                        </a>
                                    </ul>
                                </li>
                                <li>
                                    <div class='dropdown-divider'></div>
                                </li>
                                <li>
                                    <a class='dropdown-item willCollapse' href='#' id='showGlobalSettings'>
                                        <i class='bi bi-gear-fill h5'></i> 
                                        Settings
                                    </a>
                                </li>
                                <li>
                                    <div class='dropdown-divider'></div>
                                </li>
                                <li>
                                    <a class='dropdown-item willCollapse' href='#' id='showJobRates'>
                                        <i class='bi bi-currency-pound h5'></i> 
                                        Job Rates
                                    </a>
                                </li>
                                <li>
                                    <div class='dropdown-divider'></div>
                                </li>
                                <li>
                                    <a class='dropdown-item willCollapse' href='#' id='importHealthChecks'>
                                        <i class='bi bi-bandaid h5'></i>
                                        Healthchecks
                                    </a>
                                </li>
                                <li>
                                    <div class='dropdown-divider'></div>
                                </li>
                                <li>
                                    <a class='dropdown-item willCollapse' href='#' id='showEventLog'>
                                        <i class='bi bi-journal-text h5'></i> 
                                        Event Log
                                    </a>
                                </li>
                                <li>
                                    <div class='dropdown-divider'></div>
                                </li>
                                <li>
                                    <a class='dropdown-item willCollapse' href='#' id='bulkUpload' style='padding-bottom:10px;'>
                                        <i class='bi bi-upload h5'></i>
                                        Bulk Upload</a>
                                </li>
                                <li>
                                    <div class='dropdown-divider'></div>
                                </li>
                                <li>
                                    <a class='dropdown-item willCollapse' href='#' id='showSystemInfo' style='padding-bottom:10px;'>
                                        <i class='bi bi-info-circle-fill h5'></i>
                                        System Info
                                    </a>
                                </li>
                            </ul>
                        </li>
                        ";
}

if ($_SESSION['isInstaller'] == '0' && $_SESSION['isEngineer'] == '0') {
    echo "
                            <li class='nav-item pl-4 pl-xl-0 ml-0 ml-xl-4'>
                            <a id='myAccount' class='nav-link willCollapse' value='";
    echo $_SESSION['userID'];
    echo "' href='#'><i class='bi bi-person-fill h4'></i> ";
    echo $_SESSION['userName'];
    echo "</a></li>";
}

?>

                        <li class="nav-item pl-4 pl-xl-0 ml-0 ml-xl-4">
                            <a id='logOut' class='nav-link willCollapse' href='#'>
                                <i class='bi bi-box-arrow-right h4'></i>
                                Logout</a>
                        </li>
                    </ul>

               </div>

            </nav>
        </div>
    </div>
</div>
</div>
<!-- <script>
// Set the date we're counting down to
var countDownDate = new Date("May 19, 2023 00:00:00").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();

  // Find the distance between now and the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Display the result in the element with id="countdown"
  document.getElementById("countdown").innerHTML = "Time until Fast X release: " + days + " days " + hours + " hrs "
  + minutes + " mins " + seconds + " secs";

  // If the count down is finished, write some text
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("countdown").innerHTML = "FastX is here.  When you going to see it? <a target='_blank' href='https://www.cineworld.co.uk/films/fast-x/ho00009623#/buy-tickets-by-film?in-cinema=056&at=2023-05-19&for-movie=ho00009623&view-mode=list'>Cineworld Solihull</a>";
  }
}, 1000);
</script> -->


