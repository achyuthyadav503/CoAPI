  <?php
header('Access-Control-Allow-Origin: *');
include_once('confi.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){
$Location = isset($_POST['Location']) ? mysqli_real_escape_string($conn,$_POST['Location']) : "";
$NoSeats = isset($_POST['NoSeats']) ? mysqli_real_escape_string($conn,$_POST['NoSeats']) : "";



 
 // get data into data base
$sql = "SELECT * FROM office where Location='".$Location."' and NoSeats>=$NoSeats";
//echo json_encode($sql);

 $result = $conn->query($sql);
 $rows = array();
  $res = array();
  $res = $result->fetch_array();
 while($row = $result->fetch_array()){
   $rows[] = $row;
}


}else{
 $json = array("status" => 0, "msg" => "Request method not accepted". $conn->error);
} 

mysqli_close($conn); 

/* Output header */
 header('Content-type: application/json');
echo json_encode($rows);
 //echo json_encode($json1);
?>