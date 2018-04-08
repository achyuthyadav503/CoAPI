<?php
include_once('confi.php');

$data = json_decode(file_get_contents('php://input'), true);
$from = isset($_GET['from']) ? mysqli_real_escape_string($conn,$_GET['from']) : "";
$to = isset($_GET['to']) ? mysqli_real_escape_string($conn,$_GET['to']) : 0;
 $json = array("from" => $from,"to" => $to);
//$from = 22;
//$to = 0;
 
 // get data into data base
$sql = "SELECT
  m.id AS `message_id`, m.message, m.`created_at`, m.`read_status`,
  m.message_from, x.name AS `from_user`,  m.message_to, y.name AS `to_user`
 FROM inbox m 
  INNER JOIN users x    ON (m.message_from = x.id)";
 
if($to>0)
$sql .=  "INNER JOIN users y ON (m.message_to = y.id) where (x.id=$from and y.id=$to) or (x.id=$to and y.id=$from);";
else
$sql .=  "INNER JOIN users y ON (m.message_to = y.id) where (x.id=$from or y.id=$from)";

 $result = mysqli_query($conn,$sql);
 $rows = array();
  $res = array();

 if ($result) {
 if (mysqli_num_rows($result) > 0) {
 while($row = $result->fetch_array()){
    $json1['id'] = $row['message_id'];
	$userfrom = $row['message_from'];
	$userto = $row['message_to'];
	$json1['message'] = $row['message'];
	
	$json1['message_from'] = $row['message_from'];
	$json1['fromUser'] = $row['from_user'];
	$json1['message_to'] = $row['message_to'];
	$json1['toUser'] = $row['to_user'];
	if($from==$userfrom){
		 $json1['isFrom'] = 1;	
		 $userby = $userto;
	}else{
		$json1['isFrom'] = 0;
		$userby = $userfrom;
	}
	
	if($to>0)
		$rows[] = $json1;
	else
	 $rows[$userby] = $json1;
	 
	 
	
	 
	
}
//echo var_dump($rows);
//exit();
$json = array("status" => 1, "msg" => "Success",'messages'=>$rows);
 }else{
	 $json = array("status" => 1, "msg" => "No services available",'messages'=>$rows);
 }
 }else{
	 $json = array("status" => 1, "msg" => "No services available",'messages'=>$rows);
 }

 


mysqli_close($conn); 

/* Output header */
 header('Content-type: application/json');
echo json_encode($json);
 //echo json_encode($json1);
?>