<div class="navigation-wrap bg-light start-header start-style">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <nav class="navbar navbar-expand-xl navbar-light" id='mainNavBar'>
 
                    <a class="navbar-brand" href="#"><img src=<?php echo $_SESSION['navbarImage'];?> alt="DataHub Logo" title='Click to toggle Dark Mode' id='companyLogo' style='margin-right: 10px;'><strong>TDH Manager</strong></a> 
 
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
 
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
 
                    <ul class="navbar-nav ml-auto py-4 py-xl-0">
                        <li id='homeMenu' class="nav-item pl-4 pl-xl-0 ml-0 ml-xl-4">
                            <a class="nav-link willCollapse" href="#"><svg width='20px' xmlns='http://www.w3.org/2000/svg' class='bi bi-house-fill' viewBox="0 0 16 16"><path fill-rule="evenodd" d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/><path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/></svg> Home</a>
                        </li>

                        <li id='customerMenu' class="nav-item pl-4 pl-xl-0 ml-0 ml-xl-4">
                            <a class="nav-link willCollapse" href="#"><svg width='20px' aria-hidden="true" focusable="false" data-prefix="fas" data-icon="address-card" class="svg-inline--fa fa-address-card fa-w-18" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M528 32H48C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48 48h480c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48zm-352 96c35.3 0 64 28.7 64 64s-28.7 64-64 64-64-28.7-64-64 28.7-64 64-64zm112 236.8c0 10.6-10 19.2-22.4 19.2H86.4C74 384 64 375.4 64 364.8v-19.2c0-31.8 30.1-57.6 67.2-57.6h5c12.3 5.1 25.7 8 39.8 8s27.6-2.9 39.8-8h5c37.1 0 67.2 25.8 67.2 57.6v19.2zM512 312c0 4.4-3.6 8-8 8H360c-4.4 0-8-3.6-8-8v-16c0-4.4 3.6-8 8-8h144c4.4 0 8 3.6 8 8v16zm0-64c0 4.4-3.6 8-8 8H360c-4.4 0-8-3.6-8-8v-16c0-4.4 3.6-8 8-8h144c4.4 0 8 3.6 8 8v16zm0-64c0 4.4-3.6 8-8 8H360c-4.4 0-8-3.6-8-8v-16c0-4.4 3.6-8 8-8h144c4.4 0 8 3.6 8 8v16z"></path></svg> Customer</a>
                        </li>

                        <li id='reportMenuButton' class="nav-item dropdown pl-4 pl-xl-0 ml-0 ml-xl-4">
                            <a class="nav-link dropdown-toggle" data-toggle='dropdown' aria-expanded='false' href="#">
                                <svg width='20px' aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chart-bar" class="svg-inline--fa fa-chart-bar fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M332.8 320h38.4c6.4 0 12.8-6.4 12.8-12.8V172.8c0-6.4-6.4-12.8-12.8-12.8h-38.4c-6.4 0-12.8 6.4-12.8 12.8v134.4c0 6.4 6.4 12.8 12.8 12.8zm96 0h38.4c6.4 0 12.8-6.4 12.8-12.8V76.8c0-6.4-6.4-12.8-12.8-12.8h-38.4c-6.4 0-12.8 6.4-12.8 12.8v230.4c0 6.4 6.4 12.8 12.8 12.8zm-288 0h38.4c6.4 0 12.8-6.4 12.8-12.8v-70.4c0-6.4-6.4-12.8-12.8-12.8h-38.4c-6.4 0-12.8 6.4-12.8 12.8v70.4c0 6.4 6.4 12.8 12.8 12.8zm96 0h38.4c6.4 0 12.8-6.4 12.8-12.8V108.8c0-6.4-6.4-12.8-12.8-12.8h-38.4c-6.4 0-12.8 6.4-12.8 12.8v198.4c0 6.4 6.4 12.8 12.8 12.8zM496 384H64V80c0-8.84-7.16-16-16-16H16C7.16 64 0 71.16 0 80v336c0 17.67 14.33 32 32 32h464c8.84 0 16-7.16 16-16v-32c0-8.84-7.16-16-16-16z"></path></svg> 
                                Reports</a>


                            <ul class='dropdown-menu'>
                                <a class="dropdown-item willCollapse" href="#">
                                <svg xmlns='http://www.w3.org/2000/svg' width='20px' height='16' fill='currentColor' class='bi bi-diagram-2-fill' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M6 3.5A1.5 1.5 0 0 1 7.5 2h1A1.5 1.5 0 0 1 10 3.5v1A1.5 1.5 0 0 1 8.5 6v1H11a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0v-1A.5.5 0 0 1 5 7h2.5V6A1.5 1.5 0 0 1 6 4.5v-1zm-3 8A1.5 1.5 0 0 1 4.5 10h1A1.5 1.5 0 0 1 7 11.5v1A1.5 1.5 0 0 1 5.5 14h-1A1.5 1.5 0 0 1 3 12.5v-1zm6 0a1.5 1.5 0 0 1 1.5-1.5h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1A1.5 1.5 0 0 1 9 12.5v-1z'/></svg> 
                                Report Writer</a>
                            <div class="dropdown-divider"></div>
                                <li class='dropdown-submenu'>
                                    <a class='dropdown-item dropdown-toggle' href='#'><svg width='20px' aria-hidden="true" focusable="false" data-prefix="fas" data-icon="truck" class="svg-inline--fa fa-truck fa-w-20" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M624 352h-16V243.9c0-12.7-5.1-24.9-14.1-33.9L494 110.1c-9-9-21.2-14.1-33.9-14.1H416V48c0-26.5-21.5-48-48-48H48C21.5 0 0 21.5 0 48v320c0 26.5 21.5 48 48 48h16c0 53 43 96 96 96s96-43 96-96h128c0 53 43 96 96 96s96-43 96-96h48c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16zM160 464c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm320 0c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm80-208H416V144h44.1l99.9 99.9V256z"></path></svg> Vehicles</a>
                                    <ul class='dropdown-menu'>
                                        <li><a class='dropdown-item' href='#'>By Fleet</a></li>
                                        <li><a class='dropdown-item' href='#'>By Insurer</a></li>                                    
                                    </ul>
                                </li>
                                <li class='dropdown-submenu'>
                                    <a class='dropdown-item dropdown-toggle' href='#'><svg width='20px' aria-hidden="true" focusable="false" data-prefix="fas" data-icon="camera" class="svg-inline--fa fa-camera fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M512 144v288c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V144c0-26.5 21.5-48 48-48h88l12.3-32.9c7-18.7 24.9-31.1 44.9-31.1h125.5c20 0 37.9 12.4 44.9 31.1L376 96h88c26.5 0 48 21.5 48 48zM376 288c0-66.2-53.8-120-120-120s-120 53.8-120 120 53.8 120 120 120 120-53.8 120-120zm-32 0c0 48.5-39.5 88-88 88s-88-39.5-88-88 39.5-88 88-88 88 39.5 88 88z"></path></svg> Devices</a>
                                    <ul class='dropdown-menu'>
                                        <li><a class='dropdown-item' href='#'>By Fleet</a></li>
                                        <li><a class='dropdown-item' href='#'>By Insurer</a></li>                                    
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        
                        <li id='showDeviceList' class="nav-item pl-4 pl-xl-0 ml-0 ml-xl-4">
                            <a class="nav-link willCollapse" href="#"><svg width='20px' aria-hidden="true" focusable="false" data-prefix="fas" data-icon="camera" class="svg-inline--fa fa-camera fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M512 144v288c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V144c0-26.5 21.5-48 48-48h88l12.3-32.9c7-18.7 24.9-31.1 44.9-31.1h125.5c20 0 37.9 12.4 44.9 31.1L376 96h88c26.5 0 48 21.5 48 48zM376 288c0-66.2-53.8-120-120-120s-120 53.8-120 120 53.8 120 120 120 120-53.8 120-120zm-32 0c0 48.5-39.5 88-88 88s-88-39.5-88-88 39.5-88 88-88 88 39.5 88 88z"></path></svg> Devices</a>
                        </li>
                        <li id='showVehicleList' class="nav-item pl-4 pl-xl-0 ml-0 ml-xl-4">
                            <a class="nav-link willCollapse" href="#"><svg width='20px' aria-hidden="true" focusable="false" data-prefix="fas" data-icon="truck" class="svg-inline--fa fa-truck fa-w-20" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M624 352h-16V243.9c0-12.7-5.1-24.9-14.1-33.9L494 110.1c-9-9-21.2-14.1-33.9-14.1H416V48c0-26.5-21.5-48-48-48H48C21.5 0 0 21.5 0 48v320c0 26.5 21.5 48 48 48h16c0 53 43 96 96 96s96-43 96-96h128c0 53 43 96 96 96s96-43 96-96h48c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16zM160 464c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm320 0c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm80-208H416V144h44.1l99.9 99.9V256z"></path></svg> Vehicles</a>
                        </li>
                        <li id='showFootageList' class="nav-item pl-4 pl-xl-0 ml-0 ml-xl-4">
                            <a class="nav-link willCollapse" href="#"><svg width='20px' aria-hidden="true" focusable="false" data-prefix="fas" data-icon="video" class="svg-inline--fa fa-video fa-w-18" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M336.2 64H47.8C21.4 64 0 85.4 0 111.8v288.4C0 426.6 21.4 448 47.8 448h288.4c26.4 0 47.8-21.4 47.8-47.8V111.8c0-26.4-21.4-47.8-47.8-47.8zm189.4 37.7L416 177.3v157.4l109.6 75.5c21.2 14.6 50.4-.3 50.4-25.8V127.5c0-25.4-29.1-40.4-50.4-25.8z"></path></svg> Footage</a>
                        </li>
                        <li id='showRenewalList' class="nav-item pl-4 pl-xl-0 ml-0 ml-xl-4">
                            <a class="nav-link willCollapse" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="20px" fill="currentColor" class="bi bi-alarm-fill" viewBox="0 0 16 16"><path d="M6 .5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1H9v1.07a7.001 7.001 0 0 1 3.274 12.474l.601.602a.5.5 0 0 1-.707.708l-.746-.746A6.97 6.97 0 0 1 8 16a6.97 6.97 0 0 1-3.422-.892l-.746.746a.5.5 0 0 1-.707-.708l.602-.602A7.001 7.001 0 0 1 7 2.07V1h-.5A.5.5 0 0 1 6 .5zm2.5 5a.5.5 0 0 0-1 0v3.362l-1.429 2.38a.5.5 0 1 0 .858.515l1.5-2.5A.5.5 0 0 0 8.5 9V5.5zM.86 5.387A2.5 2.5 0 1 1 4.387 1.86 8.035 8.035 0 0 0 .86 5.387zM11.613 1.86a2.5 2.5 0 1 1 3.527 3.527 8.035 8.035 0 0 0-3.527-3.527z"/></svg> Renewals</a>
                        </li>
                        <li id='showJobList' class="nav-item pl-4 pl-xl-0 ml-0 ml-xl-4">
                            <a class="nav-link willCollapse" href="#"><svg width="20px" class="bi bi-inboxes-fill" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><path d="M4.98 1a.5.5 0 0 0-.39.188L1.54 5H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0A.5.5 0 0 1 10 5h4.46l-3.05-3.812A.5.5 0 0 0 11.02 1H4.98zM3.81.563A1.5 1.5 0 0 1 4.98 0h6.04a1.5 1.5 0 0 1 1.17.563l3.7 4.625a.5.5 0 0 1 .106.374l-.39 3.124A1.5 1.5 0 0 1 14.117 10H1.883A1.5 1.5 0 0 1 .394 8.686l-.39-3.124a.5.5 0 0 1 .106-.374L3.81.563zM.125 11.17A.5.5 0 0 1 .5 11H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0 .5.5 0 0 1 .5-.5h5.5a.5.5 0 0 1 .496.562l-.39 3.124A1.5 1.5 0 0 1 14.117 16H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .121-.393z"/></svg> Jobs</a>
                        </li>
                        <li id='showContactList' class="nav-item pl-4 pl-xl-0 ml-0 ml-xl-4">
                            <a class="nav-link dropdown-toggle" data-toggle='dropdown' href="#" role='button' aria-haspopup='true' aria-expanded='true'><svg xmlns="http://www.w3.org/2000/svg" width="20px" class="bi bi-telephone-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/></svg> Partners</a>
                            <div class='dropdown-menu'>
                                <!-- <a class='dropdown-item willCollapse' href='#' id='showCustomers'><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-lines-fill" viewBox="0 0 16 16"><path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z"/></svg> Customers</a> -->
                                <a class='dropdown-item willCollapse' href='#' id='showInsurers'><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-lines-fill" viewBox="0 0 16 16"><path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z"/></svg> Insurers</a>
                                <a class='dropdown-item willCollapse' href='#' id='showInstallers'><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-lines-fill" viewBox="0 0 16 16"><path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z"/></svg> Installers</a>
                                <a class='dropdown-item willCollapse' href='#' id='showSuppliers'><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-lines-fill" viewBox="0 0 16 16"><path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z"/></svg> Suppliers</a>
                                <a class='dropdown-item willCollapse' href='#' id='showBrokers'><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-lines-fill" viewBox="0 0 16 16"><path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z"/></svg> Brokers</a>
                                <a class='dropdown-item willCollapse' href='#' id='showOthers'><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-lines-fill" viewBox="0 0 16 16"><path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z"/></svg> Others</a> 
                            </div>
                        </li>
                        
                        <li data-toggle='modal' data-target='#modalShowAlerts' class="nav-item pl-4 pl-xl-0 ml-0 ml-xl-4">
                            <a class="nav-link willCollapse" href="#"><svg width='20px' aria-hidden="true" focusable="false" data-prefix="fas" data-icon="bell" class="svg-inline--fa fa-bell fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224 512c35.32 0 63.97-28.65 63.97-64H160.03c0 35.35 28.65 64 63.97 64zm215.39-149.71c-19.32-20.76-55.47-51.99-55.47-154.29 0-77.7-54.48-139.9-127.94-155.16V32c0-17.67-14.32-32-31.98-32s-31.98 14.33-31.98 32v20.84C118.56 68.1 64.08 130.3 64.08 208c0 102.3-36.15 133.53-55.47 154.29-6 6.45-8.66 14.16-8.61 21.71.11 16.4 12.98 32 32.1 32h383.8c19.12 0 32-15.6 32.1-32 .05-7.55-2.61-15.27-8.61-21.71z"></path></svg> Alerts
                                <a id='alertTotalWrapper'><sup><span class='badge badge-danger'><div id='alertTotal'></div></span></sup></a>
                                <a id='installTotalWrapper'><sup><span class='badge badge-primary'><div id='installTotal'></div></span></sup></a>
                                <a id='renewalTotalWrapper'><sup><span class='badge badge-warning'><div id='renewalTotal'></div></span></sup></a>
                            </a>
                        </li>

                        <?php
                        if ($_SESSION['isAdmin']== '1') {
                        echo "
                        <li class='nav-item pl-4 pl-xl-0 ml-0 ml-xl-4'>
                            <a class='nav-link dropdown-toggle' data-toggle='dropdown' href='#' role='button' aria-haspopup='true' aria-expanded='true' id='dropdownMenuButton'>
                            <svg width='20px' aria-hidden='true' focusable='false' data-prefix='fas' data-icon='toolbox' class='svg-inline--fa fa-toolbox fa-w-16' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'><path d='M502.63 214.63l-45.25-45.25c-6-6-14.14-9.37-22.63-9.37H384V80c0-26.51-21.49-48-48-48H176c-26.51 0-48 21.49-48 48v80H77.25c-8.49 0-16.62 3.37-22.63 9.37L9.37 214.63c-6 6-9.37 14.14-9.37 22.63V320h128v-16c0-8.84 7.16-16 16-16h32c8.84 0 16 7.16 16 16v16h128v-16c0-8.84 7.16-16 16-16h32c8.84 0 16 7.16 16 16v16h128v-82.75c0-8.48-3.37-16.62-9.37-22.62zM320 160H192V96h128v64zm64 208c0 8.84-7.16 16-16 16h-32c-8.84 0-16-7.16-16-16v-16H192v16c0 8.84-7.16 16-16 16h-32c-8.84 0-16-7.16-16-16v-16H0v96c0 17.67 14.33 32 32 32h448c17.67 0 32-14.33 32-32v-96H384v16z'></path></svg> Admin
                            </a>
                            <div class='dropdown-menu'>
                                <a class='dropdown-item willCollapse' href='#' id='showGlobalSettings'><svg xmlns='http://www.w3.org/2000/svg' width='20px' class='bi bi-gear-fill' viewBox='0 0 16 16'><path d='M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z'/></svg> Settings</a>
                                <a class='dropdown-item willCollapse' href='#' id='showFullVRNLookup' data-toggle='modal' data-target='#modalGetVRNLookup'><svg xmlns='http://www.w3.org/2000/svg' width='20px' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 122.88 61.11' style='enable-background:new 0 0 122.88 61.11' xml:space='preserve'><style type='text/css'>.st0{fill-rule:evenodd;clip-rule:evenodd;}</style><g><path class='st0' d='M65.22,0h26.54h6.63c0.38,0,0.52,0.34,0.68,0.68l2.66,5.53c0.16,0.34-0.31,0.68-0.68,0.68H55.93 C52.98,6.9,58.02,0,65.22,0L65.22,0z M23.83,45.74v3.74h3.74C27.12,47.65,25.67,46.19,23.83,45.74L23.83,45.74z M27.57,51.93h-3.74 v3.74C25.67,55.22,27.12,53.77,27.57,51.93L27.57,51.93z M21.39,55.67v-3.74h-3.74C18.1,53.77,19.55,55.22,21.39,55.67L21.39,55.67 z M17.64,49.49h3.74v-3.74C19.55,46.2,18.1,47.65,17.64,49.49L17.64,49.49z M90.05,45.74v3.74h3.74 C93.34,47.65,91.89,46.19,90.05,45.74L90.05,45.74z M93.79,51.93h-3.74v3.74C91.89,55.22,93.34,53.77,93.79,51.93L93.79,51.93z M87.61,55.67v-3.74h-3.74C84.31,53.77,85.76,55.22,87.61,55.67L87.61,55.67z M83.86,49.49h3.74v-3.74 C85.76,46.2,84.31,47.65,83.86,49.49L83.86,49.49z M89.66,12.77h3.52c5.08,0.23,7.17,0.05,9.19,1.59 c2.5,1.91,3.48,10.35,4.52,14.25c0.07,0.26-0.23,0.5-0.5,0.5H90.88c-0.27,0-0.47-0.22-0.5-0.5l-1.22-15.35 C89.14,13,89.39,12.77,89.66,12.77L89.66,12.77z M66.09,12.86h-11.5c-5.25,0-13.89,8.63-16.15,15.61 c-0.11,0.34,0.29,0.65,0.65,0.65h25.18c0.36,0,0.6-0.29,0.65-0.65l1.83-14.96C66.78,13.15,66.44,12.86,66.09,12.86L66.09,12.86z M71.07,12.8h14.07c0.27,0,0.48,0.23,0.5,0.5l1.07,15.32c0.02,0.27-0.23,0.5-0.5,0.5H69.24c-0.27,0-0.53-0.23-0.5-0.5l1.83-15.32 C70.6,13.02,70.79,12.8,71.07,12.8L71.07,12.8z M22.61,40.31c5.74,0,10.4,4.66,10.4,10.4c0,5.74-4.66,10.4-10.4,10.4 c-5.74,0-10.4-4.66-10.4-10.4C12.21,44.97,16.87,40.31,22.61,40.31L22.61,40.31z M1.81,40.78c0.53-0.24,1.11-0.35,1.74-0.34 c-0.03-3.28,0.19-6.14,0.95-8.17c0.28-1.17,0.79-2.02,1.47-2.64c2.14-1.91,21.25-3.59,25.28-4.11c4.95-4.84,10.46-9.27,16.33-13.46 c1.63-1.38,3.96-2.06,6.9-2.13l46.41-0.04c3.51-0.02,6.21,1.48,7.93,4.85l3.87,11.15l0.88-0.24v-4.34 c-0.16-1.45,0.41-2.17,1.52-2.35h5.2c1.43,0.06,2.44,0.78,2.6,2.85v15.42c0.01,1.59-0.57,2.63-2.04,2.85h-4.83 c-0.48,0.11-0.33,0.48-0.37,0.99v5.26c-0.35,3.88-1.41,6.88-4.52,7.27h-9.41c0.2-4.56-0.66-8.29-2.75-11.08 c-7.59-10.14-24.06-4.1-22.95,11.11H35.58c0.34-4.86-0.58-8.55-2.59-11.2c-7.57-9.99-25.18-4.6-23.1,11.51H3.64 C-0.13,53.94-1.36,42.19,1.81,40.78L1.81,40.78z M88.83,40.31c5.74,0,10.4,4.66,10.4,10.4c0,5.74-4.66,10.4-10.4,10.4 c-5.74,0-10.4-4.66-10.4-10.4C78.43,44.97,83.08,40.31,88.83,40.31L88.83,40.31z'/></g></svg>
                            VRN Lookup</a>
                                <a class='dropdown-item willCollapse' href='#' id='showEventLog'><svg xmlns='http://www.w3.org/2000/svg' width='20px' class='bi bi-journal-text' viewBox='0 0 16 16'><path d='M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z'/><path d='M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z'/><path d='M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z'/></svg> Event Log</a>
                            </div>
                        </li>
                        ";
                        }

                        // Menu options removed from above block of code for add installer and add supplier
                        // <a class='dropdown-item willCollapse' href='#' id='addInstaller' data-toggle='modal' data-target='#modalAddNewInstaller'><svg xmlns='http://www.w3.org/2000/svg' width='20px' class='bi bi-person-plus' viewBox='0 0 16 16'><path d='M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z'/><path fill-rule='evenodd' d='M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z'/></svg> Add Installer</a>
                        // <a class='dropdown-item willCollapse' href='#' id='addSupplier' data-toggle='modal' data-target='#modalAddNewSupplier'><svg xmlns='http://www.w3.org/2000/svg' width='20px' class='bi bi-person-plus-fill' viewBox='0 0 16 16'><path d='M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z'/><path fill-rule='evenodd' d='M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z'/></svg> Add Supplier</a>
                               
                        ?>

                        <li class="nav-item pl-4 pl-xl-0 ml-0 ml-xl-4">
                            <a id='myAccount' class='nav-link willCollapse' value="<?php echo $_SESSION['userID'];?>" href="#"><svg width='20px' aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user" class="svg-inline--fa fa-user fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"></path></svg> 
                                <?php echo $_SESSION['userName'];?>
                            </a>
                        </li>

                        <li class="nav-item pl-4 pl-xl-0 ml-0 ml-xl-4">
                            <a id='logOut' class='nav-link willCollapse' href='#'><svg width='20px' aria-hidden="true" focusable="false" data-prefix="fas" data-icon="sign-out-alt" class="svg-inline--fa fa-sign-out-alt fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M497 273L329 441c-15 15-41 4.5-41-17v-96H152c-13.3 0-24-10.7-24-24v-96c0-13.3 10.7-24 24-24h136V88c0-21.4 25.9-32 41-17l168 168c9.3 9.4 9.3 24.6 0 34zM192 436v-40c0-6.6-5.4-12-12-12H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h84c6.6 0 12-5.4 12-12V76c0-6.6-5.4-12-12-12H96c-53 0-96 43-96 96v192c0 53 43 96 96 96h84c6.6 0 12-5.4 12-12z"></path></svg> Logout</a>
                        </li>
                    </ul>
 
               </div>
 
            </nav> 
        </div>
    </div>
</div>
</div>



