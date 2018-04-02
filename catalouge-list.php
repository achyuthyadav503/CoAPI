<?php
include_once('confi.php');


 
 // get data into data base
$sql = "SELECT * FROM location";

 $result = mysqli_query($conn,$sql);
 $rows = array();
  $res = array();
  
  

 if ($result) {
 if (mysqli_num_rows($result) > 0) {
 while($row = $result->fetch_array()){
    $json1['id'] = $row['id'];
    $json1['location'] = $row['location'];
	$json1['city'] = $row['city'];
	$json1['active'] = $row['active'];
	$city = $row['city'];
	
	
	if(array_key_exists($city, $rows))
    $locations = $rows[$city];
   else
    $locations = array();
   
   $locations[]=$json1;
   
   $rows[$city]=$locations;
}

 // get data into data base
$sql = "SELECT * FROM city";

 $result = mysqli_query($conn,$sql);
 $cities = array();
  $res = array();

 if ($result) {
 if (mysqli_num_rows($result) > 0) {
 while($row = $result->fetch_array()){
    $json2['id'] = $row['id'];
	$json2['city'] = $row['city'];
	$json2['active'] = $row['active'];
	$city = $row['id'];
	if(!array_key_exists($city, $rows))
     $rows[$city] = array();
	 
	$cities[] = $json2;
}
 }}

$json = array("status" => 1, "msg" => "Success",'locationList'=>$rows,'cityList'=>$cities);
 }else{
	 $json = array("status" => 1, "msg" => "No location available",'locationList'=>$rows,'cityList'=>$cities);
 }
 }else{
	 $json = array("status" => 1, "msg" => "No location available",'locationList'=>$rows,'cityList'=>$cities);
 }

 


mysqli_close($conn); 

/* Output header */
 header('Content-type: application/json');
echo json_encode($json);
 //echo json_encode($json1);
?>