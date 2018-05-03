 <?php

include_once('confi.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){

	$officeId = $_POST['officeId'];
	$fileName = $_FILES["file"]["name"];
	 move_uploaded_file($_FILES["file"]["tmp_name"],'officeImages/'.$_FILES["file"]["name"]);
	 


$sql = "UPDATE register_office SET office_logo = '".$fileName."' WHERE id = $officeId";
$result = $conn->query($sql);


$officeImages = $_FILES["officeFiles"];
$i = 0;
$count = count($officeImages);
for($i=0;$i<$count-2;$i++){
	$fileName = $officeImages["name"][$i];
	$tmp_name = $officeImages["tmp_name"][$i];
	 move_uploaded_file($tmp_name,'officeImages/'.$fileName);
	 
 $officeImagesSql = " INSERT INTO office_images ( image_path, office_id) VALUES ('" . $fileName . "', '" . $officeId . "');";
  $officeImagesQur = $conn->query($officeImagesSql);
   if($officeImagesQur){
   //$json = array("status" => 0, "msg" => "Error adding register company!". $conn->error);
   }else{
    $json = array("status" => 0, "msg" => "Error adding office Images!". $conn->error);
   }
}


if($result){
 //$json = array("status" => 1, "msg" => "file uploaded");
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