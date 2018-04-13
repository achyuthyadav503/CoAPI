<?php
include_once('confi.php');


$data = json_decode(file_get_contents('php://input'), true);
$office = isset($data['office']) ? mysqli_real_escape_string($conn,$data['office']) : 0;
 
 // get data into data base
$sql = "SELECT * FROM users";

if($office>0)
$sql .= " where office_id=$office";
 $result = mysqli_query($conn,$sql);
 $rows = array();
  $res = array();

 if ($result) {
 if (mysqli_num_rows($result) > 0) {
 while($row = $result->fetch_array()){
    $json1['id'] = $row['id'];
    $json1['name'] = $row['name'];
	$json1['email'] = $row['email'];
	$json1['mobile'] = $row['mobile'];
	$json1['status'] = (int) $row['status'];
	$json1['role'] = $row['role'];
	
	 
	$rows[] = $json1;
}

$json = array("status" => 1, "msg" => "Success",'employeeList'=>$rows);
 }else{
	 $json = array("status" => 1, "msg" => "No companys available",'employeeList'=>$rows);
 }
 }else{
	 $json = array("status" => 1, "msg" => "No companys available",'employeeList'=>$rows);
 }

 


mysqli_close($conn); 

/* Output header */
 header('Content-type: application/json');
echo json_encode($json);
 //echo json_encode($json1);
?>