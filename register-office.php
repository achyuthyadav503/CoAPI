  <?php

include_once('confi.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){
	
$data = json_decode(file_get_contents('php://input'), true);
$OfficeName = isset($data['OfficeName']) ? mysqli_real_escape_string($conn,$data['OfficeName']) : "";
$Address = isset($data['Address']) ? mysqli_real_escape_string($conn,$data['Address']) : "";
$Location = isset($data['Location']) ? mysqli_real_escape_string($conn,$data['Location']) : "";
$City = isset($data['City']) ? mysqli_real_escape_string($conn,$data['City']) : "";



//echo (file_get_contents('php://input'));

//$UserName = $data['UserName'];



 $json1 = array("OfficeName" => $OfficeName , "Address" => $Address, "Location" => $Location, "City" => $City);
 // Insert data into data base
$sql = "INSERT INTO register_office (OfficeName, Address, Location,City) VALUES ('" . $OfficeName . "', '" . $Address . "', '" . $Location . "', '" . $City . "');";
 $qur = $conn->query($sql);
   $id = $conn->insert_id;
 $json1['officeID'] = $id;
 if($qur){
 $json = array("status" => 1, "msg" => "Done User added!",'details'=>$json1);
 }else{
 $json = array("status" => 0, "msg" => "Error adding user!". $conn->error);
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