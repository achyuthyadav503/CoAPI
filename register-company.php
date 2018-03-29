  <?php

include_once('confi.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){
	
$data = json_decode(file_get_contents('php://input'), true);
$CompanyName = isset($data['CompanyName']) ? mysqli_real_escape_string($conn,$data['CompanyName']) : "";
$description = isset($data['Description']) ? mysqli_real_escape_string($conn,$data['Description']) : "";
$joining_date = isset($data['joiningDate']) ? mysqli_real_escape_string($conn,$data['joiningDate']) : "";
$Total_monthly_rent = isset($data['Tmrent']) ? mysqli_real_escape_string($conn,$data['Tmrent']) : "";


//echo (file_get_contents('php://input'));
//echo var_dump($data);
//$UserName = $data['UserName'];



 $json1 = array("CompanyName" => $CompanyName , "description" => $description, "joining_date" => $joining_date, "Total_monthly_rent" => $Total_monthly_rent);
 // Insert data into data base
$sql = "INSERT INTO company (company_name, description, joining_date,Total_monthly_rent) VALUES ('" . $CompanyName . "', '" . $description . "', '" . $joining_date . "', '" . $Total_monthly_rent . "');";
 $qur = $conn->query($sql);
   $id = $conn->insert_id;
 $json1['companyId'] = $id;
 if($qur){
 $json = array("status" => 1, "msg" => "Done register company added!",'details'=>$json1);
 }else{
 $json = array("status" => 0, "msg" => "Error adding register company!". $conn->error);
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