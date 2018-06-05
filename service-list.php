<?php
include_once('confi.php');


 
 // get data into data base
$sql = "SELECT * FROM services_mater";

 $result = mysqli_query($conn,$sql);
 $rows = array();
  $res = array();

 if ($result) {
 if (mysqli_num_rows($result) > 0) {
 while($row = $result->fetch_array()){
    $json1['id'] = $row['id'];
    $json1['serviceName'] = $row['service_name'];
	 
	$rows[] = $json1;
}
 $json1['id'] = 0;
    $json1['serviceName'] = 'Other';
	$rows[] = $json1;
$json = array("status" => 1, "msg" => "Success",'servicesList'=>$rows);
 }else{
	 $json = array("status" => 1, "msg" => "No services available",'servicesList'=>$rows);
 }
 }else{
	 $json = array("status" => 1, "msg" => "No services available",'servicesList'=>$rows);
 }

 


mysqli_close($conn); 

/* Output header */
 header('Content-type: application/json');
echo json_encode($json);
 //echo json_encode($json1);
?>