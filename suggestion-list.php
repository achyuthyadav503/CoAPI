<?php
include_once('confi.php');


$data = json_decode(file_get_contents('php://input'), true);
$user = isset($data['user']) ? mysqli_real_escape_string($conn,$data['user']) : 0;
//$company = isset($data['company']) ? mysqli_real_escape_string($conn,$data['company']) : 0;
 
 // get data into data base
$sql = "SELECT u.id,u.name,s.suggestion FROM suggestion_request s, users u where u.id=s.user_id";
 $result = mysqli_query($conn,$sql);
 $rows = array();
  $res = array();

 if ($result) {
 if (mysqli_num_rows($result) > 0) {
 while($row = $result->fetch_array()){
    $json1['id'] = $row['id'];
    $json1['name'] = $row['name'];
	$json1['suggestion'] = $row['suggestion'];
	
	 
	$rows[] = $json1;
}

$json = array("status" => 1, "msg" => "Success",'suggestionList'=>$rows);
 }else{
	 $json = array("status" => 1, "msg" => "No companys available",'suggestionList'=>$rows);
 }
 }else{
	 $json = array("status" => 1, "msg" => "No companys available",'suggestionList'=>$rows);
 }

 


mysqli_close($conn); 

/* Output header */
 header('Content-type: application/json');
echo json_encode($json);
 //echo json_encode($json1);
?>