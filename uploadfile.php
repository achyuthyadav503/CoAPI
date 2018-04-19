 <?php

include_once('confi.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){

	$companyId = $_POST['companyId'];
	$fileName = $_FILES["file"]["name"];
	 move_uploaded_file($_FILES["file"]["tmp_name"],'members/'.$_FILES["file"]["name"]);
	 


$sql = "UPDATE company SET company_logo = '".$fileName."' WHERE id = $companyId";
$result = $conn->query($sql);
if($result){
 $json = array("status" => 1, "msg" => "file uploaded");
}else{
 $json = array("status" => 0, "msg" => "Request method not accepted". $conn->error);
}
}else{
 $json = array("status" => 0, "msg" => "Request method not accepted". $conn->error);
} 

//mysqli_close($conn); 

/* Output header */
 header('Content-type: application/json');
 echo json_encode($json);

?>