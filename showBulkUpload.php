<?php
session_start();
include('connect.php');
require_once ('simple_dom_ext/simple_html_dom.php');
if (!isset($_SESSION['userEmail']) || !isset($_SESSION['userName'])) {
    header("Location: index.php");
}

$returnString = "
<div id='bulkUploadMenu' class='settings-dialog'>
    <div class='row'> 
        <div class='col-4'>
            <btn class='btn-lg btn-primary btn-block text-center' id='bulkUploadDevices'>Devices</btn>
        </div>
        <div class='col-4'>
            <btn class='btn-lg btn-primary btn-block text-center' id='bulkUploadHealthChecks'>Healthchecks</btn>
        </div>
        <div class='col-4'>
            <btn class='btn-lg btn-primary btn-block text-center' id='bulkUploadVehicles'>Vehicles</btn>    
        </div>
    </div>
</div>

<div id='uploadDeviceFormatDetails' class='uploadFormatDetails container d-none'>
To upload a bulk batch of <b>devices</b>, create a CSV file to upload here.  The first line should contact column headings as 
detailed below.  If the data for a column is unknown, leave the entry blank:
    <div class='row'>
        <div class='col-8'>
        <ul style='margin: 10px 5px'>
            <li>Model <em>(ensure description is exactly as recorded in TDH Manager)</em></li>
            <li>Platform <em>(ensure name is exactly as recorded in TDH Manager)</em></li>
            <li>Serial</li>
            <li>IMEI</li>
            <li>DeviceStatus</li>
            <li>DRIDNumber</li>
            <li>SimSerialNo</li>
            <li>SimPhone</li>
            <li>Customer <em>(leave empty for DHInstall)</em></li>     
        </ul>
        </div>
        <div class='col-4 my-auto'>
            <p>To download a template click <btn class='btn btn-sm btn-primary' id='downloadDeviceTemplate'>here</btn></p>
        </div>
    </div>
</div>
<div id='uploadHealthcheckFormatDetails' class='uploadFormatDetails container d-none'>
To upload a bulk batch of <b>healthchecks</b>, create a CSV file to upload here.  The first line should contact column headings as 
detailed below.  If the data for a column is unknown, leave the entry blank:
    <div class='row'>
        <div class='col-8'>
        <ul style='margin: 10px 5px'>
            <li>Healthcheck Column</li>
            <li>Healthcheck Column</li>
            <li>Healthcheck Column</li>
            <li>Healthcheck Column</li>
            <li>Healthcheck Column</li>
            <li>Healthcheck Column</li>
            <li>Healthcheck Column</li>
            <li>Healthcheck Column</li>
            <li>Healthcheck Column</li>
        </ul>
        </div>
        <div class='col-4 my-auto'>
            <p>To download a template click <btn class='btn btn-sm btn-primary'>here</btn></p>
        </div>
    </div>
</div>
<div id='uploadVehicleFormatDetails' class='uploadFormatDetails container d-none'>
To upload a bulk batch of <b>vehicles</b>, create a CSV file to upload here.  The first line should contact column headings as 
detailed below.  If the data for a column is unknown, leave the entry blank:
    <div class='row'>
        <div class='col-8'>
        <ul style='margin: 10px 5px'>
            <li>RegNumber</li>
            <li>CameraRequired <em>(0 = No, 1 = Yes)</em></li>
            <li>Status <em>(0 = N/A, 1 = Pending, 2 = Installed)</em></li>
            <li>InstallDate</li>
            <li>Customer</li>     
        </ul>
        </div>
        <div class='col-4 my-auto'>
            <p>To download a template click <btn class='btn btn-sm btn-primary' id='downloadVehicleTemplate'>here</btn></p>
        </div>
    </div>
</div>

<div class='container d-none' id='dropZone'>
    <div class='row'>
        <div class='col-2'></div>
            <div id='fileDropZone' class='col-8' ondrop='uploadFile(event)' ondragover='return false'>
                <div id = 'fileDragUpload'>
                    <img src='images/draganddrop.png' class='d-block' style='width: 100px;'>
                    <h4 style='margin-top: 20px;'>Drop your CSV file here to upload your data</h4>
                    <p>or</p>
                    <p><input type='button' class='btn btn-danger btn-sm' value = 'Select CSV File' id='uploadButton' onclick='fileExplorer();'></p>
                    <input type='file' id='selectFile'>
                </div>   
            </div>
        </div>
    </div>
</div>
<div id='uploadProgress' class='progress-bar' role='progressbar'></div>
<div class='container-fluid'>
<div id='hiddenUploadTypeSelector' class='d-none'></div>
<div class='imageContent' style='margin-top:10px'></div>
</div>


";


echo $returnString;

?>






