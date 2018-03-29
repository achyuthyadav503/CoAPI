 <?php
include_once('confi.php');


 
 // get data into data base
$sql = "SELECT * FROM company";
//echo $sql;

 //$result = $conn->query($sql);
 $result = mysqli_query($conn,$sql);
 $rows = array();
  $res = array();
 // $res = $result->fetch_array();
 if ($result) {
 if (mysqli_num_rows($result) > 0) {
 while($row = $result->fetch_array()){
    $json1['id'] = $row['id'];
    $json1['companyName'] = $row['company_name'];
	 $json1['companyLogo'] = $row['company_logo'];
	  $json1['coverPic'] = $row['cover_pic'];
	   $json1['description'] = $row['description'];
	
	$rows[] = $json1;
}
$json = array("status" => 1, "msg" => "Success",'memberList'=>$rows);
 }else{
	 $json = array("status" => 1, "msg" => "No Office available",'memberList'=>$rows);
 }
 }else{
	 $json = array("status" => 1, "msg" => "No Office available",'memberList'=>$rows);
 }

 


mysqli_close($conn); 

/* Output header */
 header('Content-type: application/json');
echo json_encode($json);
 //echo json_encode($json1);
?>