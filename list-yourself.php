  <?php

include_once('confi.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){
	
$data = json_decode(file_get_contents('php://input'), true);
$userId = isset($data['user']) ? mysqli_real_escape_string($conn,$data['user']) : "";
$serviceId = isset($data['service']) ? mysqli_real_escape_string($conn,$data['service']) : "";
$serviceName = isset($data['serviceName']) ? mysqli_real_escape_string($conn,$data['serviceName']) : "";

//$userId =  $_SESSION['userDetailsObj'];
			
 //echo var_dump($userId) ;  
//exit(); 


if($serviceId==0){
	$sql = "INSERT INTO services_mater (service_name,active) VALUES ('" . $serviceName . "','1');";
	$qur = $conn->query($sql);
	$serviceId = mysqli_insert_id($conn);
	
}
			

//$userId = $userDetailsObj['id'];
 $json1 = array("user_id" => $userId , "service_id" => $serviceId);
 // Insert data into data base
$sql = "INSERT INTO user_services (user_id, service_id) VALUES ('" . $userId . "', '" . $serviceId . "');";
 $qur = $conn->query($sql);
 if($qur){
 $json = array("status" => 1, "msg" => "Done User listed in our services!",'details'=>$json1);
 }else{
 $json = array("status" => 0, "msg" => "Error adding User Services!". $conn->error);
 } 
}else{
 $json = array("status" => 0, "msg" => "Request method not accepted". $conn->error);
} 

//mysqli_close($conn); 

/* Output header */
 header('Content-type: application/json');
 echo json_encode($json);
 //echo json_encode($json1);
?>