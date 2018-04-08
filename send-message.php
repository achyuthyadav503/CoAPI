  <?php

include_once('confi.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){
	
$data = json_decode(file_get_contents('php://input'), true);
$from = isset($data['from']) ? mysqli_real_escape_string($conn,$data['from']) : "";
$to = isset($data['to']) ? mysqli_real_escape_string($conn,$data['to']) : "";
$message = isset($data['message']) ? mysqli_real_escape_string($conn,$data['message']) : "";

//$userId =  $_SESSION['userDetailsObj'];
			
 //echo var_dump($userId) ;  
//exit(); 
date_default_timezone_set('Asia/Kolkata');

		$today = new Datetime();
		$today = $today->format('Y-m-d H:m:s');

//$userId = $userDetailsObj['id'];
 $json1 = array("from" => $from,"to" => $to , "message" => $message,"today" => $today);
 // Insert data into data base
$sql = "INSERT INTO inbox (message_from, message_to,message,read_status,created_at) VALUES ('" . $from . "', '" . $to . "', '" . $message . "',0,'".$today."');";
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