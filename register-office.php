  <?php

include_once('confi.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){
	
$data = json_decode(file_get_contents('php://input'), true);
$OfficeName = isset($data['OfficeName']) ? mysqli_real_escape_string($conn,$data['OfficeName']) : "";
$Description = isset($data['Description']) ? mysqli_real_escape_string($conn,$data['Description']) : "";
$Address = isset($data['Address']) ? mysqli_real_escape_string($conn,$data['Address']) : "";
$Location = isset($data['Location']) ? mysqli_real_escape_string($conn,$data['Location']) : "";
$City = isset($data['City']) ? mysqli_real_escape_string($conn,$data['City']) : "";
$officeSeats = isset($data['typesofseats']) ? $data['typesofseats'] : "";


//echo (file_get_contents('php://input'));

//$UserName = $data['UserName'];



 $json1 = array("OfficeName" => $OfficeName , "Address" => $Address, "Location" => $Location, "City" => $City);
 // Insert data into data base
$sql = "INSERT INTO register_office (OfficeName,description, Address, Location,City) VALUES ('" . $OfficeName . "','" . $Description . "', '" . $Address . "', '" . $Location . "', '" . $City . "');";
 $qur = $conn->query($sql);
   $id = $conn->insert_id;
 $json1['officeID'] = $id;
 if($qur){
  foreach($officeSeats as $officeSeat){
// echo var_dump($companySeat);
//exit();
 $typesOfSeat =  isset($officeSeat['typesOfSeats']) ? mysqli_real_escape_string($conn,$officeSeat['typesOfSeats']) : '';
  $numberofseats = (int) isset($officeSeat['numberOfSeats']) ? mysqli_real_escape_string($conn,$officeSeat['numberOfSeats']) : 0;
  $pricePerSeat = (int) isset($officeSeat['pricePerSeat']) ? mysqli_real_escape_string($conn,$officeSeat['pricePerSeat']) : 0;
  $officeSeatSql = " INSERT INTO office_seats ( type_of_seats, no_of_seats, price_per_seats, office_id) VALUES ('" . $typesOfSeat . "', '" . $numberofseats . "', '" . $pricePerSeat . "', '" . $id . "');";
  $officeQur = $conn->query($officeSeatSql);
   if($officeQur){
   //$json = array("status" => 0, "msg" => "Error adding register company!". $conn->error);
   }else{
    $json = array("status" => 0, "msg" => "Error adding register company!". $conn->error);
   }
 }
 $json = array("status" => 1, "msg" => "Done Office added!",'details'=>$json1);
 }else{
 $json = array("status" => 0, "msg" => "Error adding office!". $conn->error);
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