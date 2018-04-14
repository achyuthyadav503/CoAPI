  <?php

include_once('confi.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){
	
$data = json_decode(file_get_contents('php://input'), true);
$UserName = isset($data['UserName']) ? mysqli_real_escape_string($conn,$data['UserName']) : "";
$PassWord = isset($data['PassWord']) ? mysqli_real_escape_string($conn,$data['PassWord']) : "";

//$UserName = 'kishan@gmail.com';
//$PassWord = 'kaspy';

 $json1 = array("UserName" => $UserName);
  $companyJson = array();
  $paymentJson = array();
 // Insert data into data base

 
  $sql = "SELECT * FROM users WHERE email = '$UserName' and pwd = '$PassWord' and status =1";
 
	$result = mysqli_query($conn,$sql);

 if($result){

 $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
 $count=0;
	   
	  if ($row!=null)
	  {
      $active = $row['status'];
	  $companyId = $row['company_id'];
	  $role = $row['role'];
	   $sqlCompany = "SELECT * FROM company WHERE id ='$companyId'";
	   	$companyResult = mysqli_query($conn,$sqlCompany);
		 if($companyResult){
		$companyRow = mysqli_fetch_array($companyResult,MYSQLI_ASSOC);
		
		if ($companyRow!=null){
		$sqlPayment = "SELECT SUM(amount_paid) amount_paid FROM payment WHERE company_id ='$companyId' AND date_of_payment BETWEEN '2018-04-01' AND '2018-04-30'";
	   	$paymentResult = mysqli_query($conn,$sqlPayment);

		if($paymentResult){
		$paymentRow = mysqli_fetch_array($paymentResult,MYSQLI_ASSOC);
		if ($paymentRow!=null){
		  $companyJson['id'] = $companyRow['id'];
		   $companyJson['company_name'] = $companyRow['company_name'];
		    $companyJson['total_monthly_rent'] = $companyRow['Total_monthly_rent'];
			
			// $paymentJson['id'] = $paymentRow['id'];
		   $paymentJson['amountPaid'] = $paymentRow['amount_paid'];
		    $paymentJson['due'] = $companyRow['Total_monthly_rent'] - $paymentRow['amount_paid'];
			  $paymentJson['dueDate'] = '2018-05-10';
		    //$paymentJson['dateofPayment'] = $paymentRow['date_of_payment'];
			}
			}
			}
			}
	  
	  $count = 1;
      }		
      if($count == 1) {
		 $json1['id'] = $row['id'];
         $json1['name'] = $row['name'];
		  $json1['email'] = $row['email'];
		   $json1['mobile'] = $row['mobile'];
		    $json1['status'] = $row['status'];
			 $json1['officeId'] = $row['office_id'];
			  $json1['companyId'] = $row['company_id'];
			   $json1['role'] = $row['role'];
			 
			   $json1['company'] = $companyJson;
			   $json1['payment'] = $paymentJson;
			   
        
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