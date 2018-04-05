  <?php

include_once('confi.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){
	
$data = json_decode(file_get_contents('php://input'), true);
$UserName = isset($data['UserName']) ? mysqli_real_escape_string($conn,$data['UserName']) : "";
$Email = isset($data['Email']) ? mysqli_real_escape_string($conn,$data['Email']) : "";
$PassWord = isset($data['PassWord']) ? mysqli_real_escape_string($conn,$data['PassWord']) : "";
$MobileNo = isset($data['MobileNo']) ? mysqli_real_escape_string($conn,$data['MobileNo']) : "";
$companyId = (int) isset($data['companyId']) ? mysqli_real_escape_string($conn,$data['companyId']) : 0;
$officeId = (int) isset($data['officeId']) ? mysqli_real_escape_string($conn,$data['officeId']) : 0;
$role = isset($data['role']) ? mysqli_real_escape_string($conn,$data['role']) : "";
$status = 1;
//$companyId = 1;
//echo (file_get_contents('php://input'));
//echo var_dump($data);
//$UserName = $data['UserName'];

/*$name = 'kishan';
$email = "jhgjygj";
$password = 'hgjg';
$status = 1;
*/


 $json1 = array("name" => $UserName , "email" => $Email,"status" => $status, "password" => $PassWord, "MobileNo" => $MobileNo,"companyId"=>$companyId,"officeId"=>$officeId);
 // Insert data into data base
$sql = "INSERT INTO users (name, email, pwd,mobile, status,company_id,office_id,role) VALUES ('" . $UserName . "', '" . $Email . "', '" . $PassWord . "', '" . $MobileNo . "', '" . $status . "','".$companyId."','".$officeId."', '".$role."');";
// echo $sql;
 $qur = $conn->query($sql);
 if($qur){
 $json = array("status" => 1, "msg" => "Done register employee added!",'details'=>$json1);
 }else{
 $json = array("status" => 0, "msg" => "Error adding register employee!". $conn->error);
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