  <?php

include_once('confi.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){
	
$data = json_decode(file_get_contents('php://input'), true);
$userId = isset($data['useId']) ? mysqli_real_escape_string($conn,$data['useId']) : "";
$message = isset($data['message']) ? mysqli_real_escape_string($conn,$data['message']) : "";


 $sql = "INSERT INTO suggestion_request (user_id, suggestion) VALUES ('" . $userId . "', '" . $message . "');";
$qur = $conn->query($sql);
   $id = $conn->insert_id;
   if($qur){

$json = array("status" => 1, "msg" => "Success");
 }else{
	 $json = array("status" => 0, "msg" => "Error adding Feedback!".$conn->error);
 }
 }else{
	 $json = array("status" => 0, "msg" => "Request method not accepted");
 }


//mysqli_close($conn); 

/* Output header */
 header('Content-type: application/json');
 echo json_encode($json);
 //echo json_encode($json1);
?>