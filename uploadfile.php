 <?php

include_once('confi.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){
	
	 move_uploaded_file($_FILES["file"]["tmp_name"],$_FILES["file"]["name"]);
	  $json = array("status" => 1, "msg" => "file uploaded");



}else{
 $json = array("status" => 0, "msg" => "Request method not accepted". $conn->error);
} 

//mysqli_close($conn); 

/* Output header */
 header('Content-type: application/json');
 echo json_encode($json);

?>