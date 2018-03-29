 <?php
include_once('confi.php');


$sql = "SELECT s.service_name,u.name,us.service_id,us.user_id FROM services_mater s,user_services us,users u where s.id=us.service_id and u.id=us.user_id";
//secho $sql;

 //$result = $conn->query($sql);
 $result = mysqli_query($conn,$sql);
 $rows = array();
  $res = array();
 // $res = $result->fetch_array();
 if ($result) {
 if (mysqli_num_rows($result) > 0) {
 while($row = $result->fetch_array()){
    $json1['serviceName'] = $row['service_name'];
	 $json1['name'] = $row['name'];
	  $json1['userId'] = $row['user_id'];
	   $json1['serviceId'] = $row['service_id'];
	
	$rows[] = $json1;
}
$json = array("status" => 1, "msg" => "Success",'serviceList'=>$rows);
 }else{
	 $json = array("status" => 1, "msg" => "No services available",'serviceList'=>$rows);
 }
 }else{
	 $json = array("status" => 1, "msg" => "No services available",'serviceList'=>$rows);
 }

 


mysqli_close($conn); 

/* Output header */
 header('Content-type: application/json');
echo json_encode($json);
 //echo json_encode($json1);
?>