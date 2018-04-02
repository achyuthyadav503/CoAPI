  <?php

include_once('confi.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){
	
$data = json_decode(file_get_contents('php://input'), true);
$location = isset($data['location']) ? mysqli_real_escape_string($conn,$data['location']) : "";
$city = isset($data['city']) ? mysqli_real_escape_string($conn,$data['city']) : "";
$active = 1;

//$userId =  $_SESSION['userDetailsObj'];
			
 //echo var_dump($userId) ;  
//exit(); 
			

//$userId = $userDetailsObj['id'];
 $json1 = array("location" => $location , "city" => $city , "active" => $active);
 // Insert data into data base
$sql = "INSERT INTO user_services (location, city,active) VALUES ('" . $location . "', '" . $city . "','". $active ."');";
 $qur = $conn->query($sql);
 if($qur){
 $json = array("status" => 1, "msg" => "Location adding done",'details'=>$json1);
 }else{
 $json = array("status" => 0, "msg" => "Error adding Location!". $conn->error);
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