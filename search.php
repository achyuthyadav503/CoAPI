  <?php
include_once('confi.php');

 $rows = array();

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$data = json_decode(file_get_contents('php://input'), true);
$city = (int) isset($data['location']) ? mysqli_real_escape_string($conn,$data['City']) : "";
$location = (int) isset($data['location']) ? mysqli_real_escape_string($conn,$data['location']) : "";
$NoSeats = (int) isset($data['NoSeats']) ? mysqli_real_escape_string($conn,$data['NoSeats']) : "";



 
 // get data into data base
$sql = "SELECT ro.id,ro.OfficeName,ro.Address,l.location Location,c.city City  FROM register_office ro, location l, city c where c.id=ro.City and l.id=ro.Location";
if($city>0)
$sql = $sql." AND ro.City='".$city."'";
if($location>0)
$sql = $sql." AND ro.Location='".$location."'";
//echo $sql;

 //$result = $conn->query($sql);
 $result = mysqli_query($conn,$sql);

  $res = array();
 // $res = $result->fetch_array();
 if ($result) {
 if (mysqli_num_rows($result) > 0) {
 while($row = $result->fetch_array()){
    $json1['id'] = $row['id'];
    $json1['OfficeName'] = $row['OfficeName'];
	 $json1['Address'] = $row['Address'];
	  $json1['Location'] = $row['Location'];
	   $json1['City'] = $row['City'];
	
	$rows[] = $json1;
}
$json = array("status" => 1, "msg" => "Success",'list'=>$rows);
 }else{
	 $json = array("status" => 1, "msg" => "No Office available",'list'=>$rows);
 }
 }else{
	 $json = array("status" => 1, "msg" => "No Office available",'list'=>$rows);
 }

 
}else{
 $json = array("status" => 0, "msg" => "Request method not accepted". $conn->error,'list'=>$rows);
} 

mysqli_close($conn); 

/* Output header */
 header('Content-type: application/json');
echo json_encode($json);
 //echo json_encode($json1);
?>