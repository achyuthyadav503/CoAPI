  <?php

include_once('confi.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){
	
$data = json_decode(file_get_contents('php://input'), true);
$Office_id = isset($data['Office']) ? mysqli_real_escape_string($conn,$data['Office']) : "";
$Company_id = isset($data['Company']) ? mysqli_real_escape_string($conn,$data['Company']) : "";
$Amountpaid = isset($data['Amountpaid']) ? mysqli_real_escape_string($conn,$data['Amountpaid']) : "";
$dateOfPayment = isset($data['dateOfPayment']) ? mysqli_real_escape_string($conn,$data['dateOfPayment']) : "";
$modeOfPayment = (int) isset($data['modeOfPayment']) ? mysqli_real_escape_string($conn,$data['modeOfPayment']) : 0;
$TransCheqNO = (int) isset($data['TransCheqNO']) ? mysqli_real_escape_string($conn,$data['TransCheqNO']) : 0;





 $json1 = array("Officeid" => $Office_id , "Companyid" => $Company_id,"Amountpaid" => $Amountpaid, "dateOfPayment" => $dateOfPayment, "modeOfPayment" => $modeOfPayment,"TransCheqNO"=>$TransCheqNO);
 // Insert data into data base
$sql = "INSERT INTO payment (office_id, company_id, amount_paid,date_of_payment, mode_of_payment,	tran_cheq_number) VALUES ('" . $Office_id . "', '" . $Company_id . "', '" . $Amountpaid . "', '" . $dateOfPayment . "','".$modeOfPayment."','".$TransCheqNO."');";
// echo $sql;
 $qur = $conn->query($sql);
 if($qur){
 $json = array("status" => 1, "msg" => "Done register employee added!",'details'=>$json1);
 }else{
 $json = array("status" => 0, "msg" => "Error adding register employee!". $conn->error);
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