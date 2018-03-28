  <?php

include_once('confi.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){
$name = isset($_POST['name']) ? mysqli_real_escape_string($conn,$_POST['name']) : "";
$email = isset($_POST['email']) ? mysqli_real_escape_string($conn,$_POST['email']) : "";
$password = isset($_POST['pwd']) ? mysqli_real_escape_string($conn,$_POST['pwd']) : "";
$status = isset($_POST['status']) ? mysqli_real_escape_string($conn,$_POST['status']) : "";


 $json1 = array("name" => $name , "email" => $email,"status" => $status, "password" => $password);
 // Insert data into data base
$sql = "INSERT INTO users (name, email, pwd, status) VALUES ('" . $name . "', '" . $email . "', '" . $password . "', '" . $status . "');";
 $qur = $conn->query($sql);
 if($qur){
 $json = array("status" => 1, "msg" => "Done User added!");
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