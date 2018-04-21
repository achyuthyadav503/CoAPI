  <?php
include_once('confi.php');

 $rows = array();
	//$officeId = $_GET['officeId'];


$officeId = isset($_GET['officeId']) ? mysqli_real_escape_string($conn,$_GET['officeId']) : 0;

 
 // get data into data base
$sql = "SELECT ro.id,ro.OfficeName,ro.Address,ro.description,l.location Location,c.city City  FROM register_office ro, location l, city c where c.id=ro.City and l.id=ro.Location AND ro.id = $officeId";


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
				
			 }
			 $types[] = $type;
			  
		 }
		 }
		 
		  $json1['officeSeats'] = $types;
		 
		 $amenitiessql = "SELECT * from office_amenities where office_id=$id";
	    $amenitiesresult = mysqli_query($conn,$amenitiessql);
		 if ($amenitiesresult) {
		 if (mysqli_num_rows($amenitiesresult) > 0) {
		 $amenities = array();
			 while($amenitiesrow = $amenitiesresult->fetch_array()){
				
				//echo var_dump($amenitiesrow);
			
				 $amenitie['id'] = $amenitiesrow['id'];
				$amenitie['amenities'] = $amenitiesrow['amenities'];
				
				 $amenities[] =  $amenitie;
			 }
			   $json1['officeAmenities'] = $amenities;
		 }
		 //	exit();
 }
	
	$rows[] = $json1;
}

$json = array("status" => 1, "msg" => "Success",'office'=>$json1);
 }else{
	 $json = array("status" => 1, "msg" => "No Office available",'list'=>$rows);
 }
 }else{
	 $json = array("status" => 1, "msg" => "No Office available",'list'=>$rows);
 }

mysqli_close($conn); 

/* Output header */
 header('Content-type: application/json');
echo json_encode($json);
 //echo json_encode($json1);
?>