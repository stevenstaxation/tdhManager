<?php

include 'connect.php';

/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simple to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

// DB table to use
$table = '(SELECT tblDevice.ID, tblDevice.ownerID, tblDevice.TDHNumber, tblDevice.serialNumber, tblDevice.IMEI, tblDevice.DRIDNumber, tblSupplier.supplierName,
tblDevice.SIMNumber, tblDevice.SIMPhone, tblDevice.SIMDeactivationDate, tblDevice.config, tblDevice.deviceNote, tblDeviceStatus.status, tblVehicle.regNumber,
tblCustomer.businessName, tblDeviceDescription.description, tblSIMStatus.SIMStatus, tblInstaller.installerName, tblDevice.installDate, tblDevice.scheduledDate,
tblDevice.platformUpdated, tblDevice.configUpdated, tblDevice.vcoUpdated

FROM tblDevice LEFT JOIN tblVehicle ON tblDevice.vehicleID = tblVehicle.ID LEFT JOIN tblCustomer ON tblCustomer.ID = tblDevice.ownerID
LEFT JOIN tblDeviceDescription ON tblDevice.deviceDescriptionID =tblDeviceDescription.ID LEFT JOIN tblDeviceStatus ON tblDevice.status
= tblDeviceStatus.ID LEFT JOIN tblSIMStatus ON tblDevice.SIMStatus = tblSIMStatus.ID LEFT JOIN tblInstaller ON tblDevice.installerID = tblInstaller.ID
LEFT JOIN tblSupplier ON tblDevice.supplierID = tblSupplier.ID
ORDER BY tblCustomer.businessName ASC, tblVehicle.regNumber IS NOT TRUE, tblVehicle.regNumber ASC) AS devs';

// Table's primary key
$primaryKey = 'id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes

$columns = array(
    array('db' => 'businessName', 'dt' => 0),
    array('db' => 'regNumber', 'dt' => 1),
    array('db' => 'description', 'dt' => 2),
    array('db' => 'supplierName', 'dt' => 3),
    array('db' => 'serialNumber', 'dt' => 4),
    array('db' => 'IMEI', 'dt' => 5), 
    array('db' => 'DRIDNumber', 'dt' => 6), 
    array('db' => 'config', 'dt' => 7), 
    array('db' => 'status', 'dt' => 8), 
    array('db' => 'SIMNumber', 'dt' => 9),
    array('db' => 'SIMPhone', 'dt' => 10),
    array(
          'db' => 'scheduledDate',
          'dt' => 11,
          'formatter' => function( $d, $row ) {
             return date( 'j/m/Y', strtotime($d));
         }
        ),
    array('db' => 'SIMStatus', 'dt' => 12),
    array('db' => 'installerName', 'dt' => 13),
    array(
        'db' => 'installDate',
        'dt' => 14,
        'formatter' => function( $d, $row ) {
           return date( 'j/m/Y', strtotime($d));
       }
    ),
    array(
        'db' => 'ID',
        'dt' => 15,
        'formatter' => function( $d, $row ) {
           return '<btn class="btn btn-sm btn-warning"><svg xmlns="http://www.w3.org/2000/svg" width="8px" height="8px" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
           <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
           </svg></btn>'; 
       }
    ),
    array(
        'db' => 'ID',
        'dt' => 16,
        'formatter' => function( $d, $row ) {
           return  '<btn class="btn btn-sm btn-warning"><svg xmlns="http://www.w3.org/2000/svg" width="8px" height="8px" fill="currentColor" class="bi bi-journal-check" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M10.854 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 8.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
           <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/><path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/></svg></btn>';
       }
    ),
    array('db' => 'regNumber', 'dt' => 17),
    array('db' => 'deviceNote', 'dt' => 18),
    array('db' => 'platformUpdated', 'dt' => 19),
    array('db' => 'configUpdated', 'dt' => 20),
    array('db' => 'vcoUpdated', 'dt' => 21)

);

// SQL server connection information
$sql_details = array(
    'user' => 'root',
    'pass' => 'W1!!14m%t3v3n5',
    'db' => 'TDHManager',
    'host' => '127.0.0.1:3306',
);

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

require 'ssp.class.php';

echo json_encode(
    SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns)
);

