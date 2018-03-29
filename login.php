  <?php

include_once('confi.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){
	
$data = json_decode(file_get_contents('php://input'), true);
$UserName = isset($data['UserName']) ? mysqli_real_escape_string($conn,$data['UserName']) : "";
$PassWord = isset($data['PassWord']) ? mysqli_real_escape_string($conn,$data['PassWord']) : "";

//$UserName = 'kishan@gmail.com';
//$PassWord = 'kaspy';

 $json1 = array("UserName" => $UserName);
 // Insert data into data base

 
  $sql = "SELECT * FROM users WHERE email = '$UserName' and pwd = '$PassWord' and status =1";
	$result = mysqli_query($conn,$sql);

 if($result){

 $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	   $count = 1;
	  if ($row!=null)
	  {
      $active = $row['status'];
	  $count = 1;
      }		
      if($count == 1) {
		 $json1['id'] = $row['id'];
         $json1['name'] = $row['name'];
        
      }else {
         //$error = "Your Login Name or Password is invalid";
		  $json = array("status" => 0, "msg" => "Your Login Name or Password is invalid");
      }
	  
	  
 $json = array("status" => 1, "msg" => "Login Success",'details'=>$json1);
 }else{
 $json = array("status" => 0, "msg" => "Error with Login!". $conn->error);
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