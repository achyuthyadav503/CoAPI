<?php
include_once('confi.php');


$data = json_decode(file_get_contents('php://input'), true);
$office = isset($data['office']) ? mysqli_real_escape_string($conn,$data['office']) : 0;
$company = isset($data['company']) ? mysqli_real_escape_string($conn,$data['company']) : 0;
 
 // get data into data base
$sql = "SELECT p.id,f.OfficeName,p.office_id,p.company_id,c.company_name,p.amount_paid,p.date_of_payment,p.mode_of_payment,p.tran_cheq_number  FROM payment p, register_office f, company c where c.id=p.company_id and f.id=p.office_id";
if($company>0)
$sql = $sql." AND p.company_id='".$company."'";

if($office>0)
$sql .= " AND office_id=$office";
 $result = mysqli_query($conn,$sql);
 $rows = array();
  $res = array();

 if ($result) {
 if (mysqli_num_rows($result) > 0) {
 while($row = $result->fetch_array()){
    $json1['id'] = $row['id'];
    $json1['OfficeName'] = $row['OfficeName'];
	$json1['company_name'] = $row['company_name'];
	$json1['amount_paid'] = $row['amount_paid'];
	$json1['date_of_payment'] = (int) $row['date_of_payment'];
	$json1['mode_of_payment'] = $row['mode_of_payment'];
	$json1['tran_cheq_number'] = $row['tran_cheq_number'];
	
	 
	$rows[] = $json1;
}

$json = array("status" => 1, "msg" => "Success",'paymentList'=>$rows);
 }else{
	 $json = array("status" => 1, "msg" => "No companys available",'paymentList'=>$rows);
 }
 }else{
	 $json = array("status" => 1, "msg" => "No companys available",'paymentList'=>$rows);
 }

 


mysqli_close($conn); 

/* Output header */
 header('Content-type: application/json');
echo json_encode($json);
 //echo json_encode($json1);
?>