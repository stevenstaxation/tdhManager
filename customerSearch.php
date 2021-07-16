<?php
session_start();
include('connect.php');


function get_customer($link , $term){ 
    $query = "SELECT * FROM tblCustomer WHERE businessName LIKE '%".$term."%' ORDER BY businessName ASC";
    $result = mysqli_query($link, $query); 
    $data = mysqli_fetch_all($result,MYSQLI_ASSOC);
    return $data; 
   }



if (isset($_GET['term'])) {

    $getCustomer = get_customer($link, $_GET['term']);
    $customerList = array();
    foreach($getCustomer as $customer){
    $customerList[] = $customer['businessName'];
    }
    echo json_encode($customerList);
}


?>