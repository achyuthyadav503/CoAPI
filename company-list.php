<?php
include_once('confi.php');


$data = json_decode(file_get_contents('php://input'), true);
$office = isset($data['office']) ? mysqli_real_escape_string($conn,$data['office']) : 0;
 
 // get data into data base
$sql = "SELECT * FROM company";

if($office>0)
$sql .= " where office_id=$office";
 $result = mysqli_query($conn,$sql);
 $rows = array();
  $res = array();

 if ($result) {
 if (mysqli_num_rows($result) > 0) {
 while($row = $result->fetch_array()){
    $json1['id'] = $row['id'];
    $json1['companyName'] = $row['company_name'];
	$json1['description'] = $row['description'];
	 
	$rows[] = $json1;
}
$json = array("status" => 1, "msg" => "Success",'companyList'=>$rows);
 }else{
	 $json = array("status" => 1, "msg" => "No companys available",'companyList'=>$rows);
 }
 }else{
	 $json = array("status" => 1, "msg" => "No companys available",'companyList'=>$rows);
 }

 


mysqli_close($conn); 

/* Output header */
 header('Content-type: application/json');
echo json_encode($json);
 //echo json_encode($json1);
?>