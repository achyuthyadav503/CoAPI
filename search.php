  <?php
include_once('confi.php');
$host = $_SERVER['HTTP_HOST'];
 $rows = array();

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$data = json_decode(file_get_contents('php://input'), true);
$city = (int) isset($data['City']) ? mysqli_real_escape_string($conn,$data['City']) : "";
$location = (int) isset($data['location']) ? mysqli_real_escape_string($conn,$data['location']) : "";
$NoSeats = (int) isset($data['NoSeats']) ? mysqli_real_escape_string($conn,$data['NoSeats']) : "";
$lat = isset($data['lat']) ? $data['lat'] : "";
$lng = isset($data['lng']) ? $data['lng'] : "";



 
 // get data into data base
 $sql = "SELECT ro.id,ro.OfficeName,ro.Address,ro.description,l.location Location,c.city City,ro.lat,ro.lng  FROM register_office ro, location l, city c where c.id=ro.City and l.id=ro.Location and lat.id=ro.lat and lng.id=ro.lng";
$sql = "SELECT ro.id,ro.OfficeName,ro.Address,ro.description,ro.Location,ro.City FROM register_office ro";
/*if($city>0)
$sql = $sql." AND ro.City='".$city."'";
if($location>0)
$sql = $sql." AND ro.Location='".$location."'"; */
if($lat!=''){
$sql = "SELECT ro.id,ro.OfficeName,ro.Address,ro.description,ro.Location,ro.City, ( 7959 * acos( cos( radians(".$lat.") ) * cos( radians( ro.lat ) ) 
    * cos( radians( ro.lng ) - radians(".$lng.") ) + sin( radians(".$lat.") ) * sin(radians(ro.lat)) ) ) AS distance FROM register_office ro HAVING distance < 3 ";

//$sql = $sql." AND ro.lat='".$lat."'";
}
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
	   $json1['Description'] = $row['description'];
	   $types = array();
	   $id = $row['id'];
	   $typesql = "SELECT * from office_seats where office_id=$id";
	    $typeresult = mysqli_query($conn,$typesql);
		 if ($typeresult) {
		 if (mysqli_num_rows($typeresult) > 0) {
			 while($typerow = $typeresult->fetch_array()){
			 
				 $type['id'] = $typerow['id'];
				$type['typeOfSeats'] = $typerow['type_of_seats'];
				 $type['noOfSeats'] = $typerow['no_of_seats'];
				  $type['pricePerSeats'] = $typerow['price_per_seats'];
				 $types[] = $type;
			 }
			
			  
		 }
		 }
		 
		  $json1['officeSeats'] = $types;
		   $images = array();
		  $imagessql = "SELECT * from office_images where office_id=$id";
	    $imagesresult = mysqli_query($conn,$imagessql);
		 if ($imagesresult) {
		 if (mysqli_num_rows($imagesresult) > 0) {
		
			 while($imagesrow = $imagesresult->fetch_array()){
				
				//echo var_dump($amenitiesrow);
			
				 $image['id'] = $imagesrow['id'];
				//$image['imagePath'] = $imagesrow['image_path'];
				 $image['imagePath'] = "http://".$host.'/CoAPI/officeImages/'.$imagesrow['image_path'];
				
				 $images[] =  $image;
			 }
			  
		 }
		  
		 //	exit();
			}
 $json1['officeImages'] = $images;
		 
		/* $amenitiessql = "SELECT * office_amenities where office_id=$id";
	    $amenitiesresult = mysqli_query($conn,$typesql);
		 if ($amenitiesresult) {
		 if (mysqli_num_rows($amenitiesresult) > 0) {
			 while($amenitiesrow = $amenitiesresult->fetch_array()){
			 
				 $amenities['id'] = $amenitiesrow['id'];
				$amenities['amenities'] = $amenitiesrow['amenities'];
				
				
			 }
			   $json1['officeAmenities'] = $amenities;
		 }
 }*/
	
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