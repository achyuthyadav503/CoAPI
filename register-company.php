  <?php

include_once('confi.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){
	
$data = json_decode(file_get_contents('php://input'), true);
$CompanyType = isset($data['CompanyType']) ? mysqli_real_escape_string($conn,$data['CompanyType']) : "";
$CompanyName = isset($data['CompanyName']) ? mysqli_real_escape_string($conn,$data['CompanyName']) : "";
$description = isset($data['Description']) ? mysqli_real_escape_string($conn,$data['Description']) : "";
$joining_date = isset($data['joiningDate']) ? mysqli_real_escape_string($conn,$data['joiningDate']) : "";
$Total_monthly_rent = isset($data['Tmrent']) ? mysqli_real_escape_string($conn,$data['Tmrent']) : "";
$officeId = (int) isset($data['officeId']) ? mysqli_real_escape_string($conn,$data['officeId']) : 0;
$file = isset($data['logo']) ? $data['logo'] : "";
$companySeats = isset($data['typesofseats']) ? $data['typesofseats'] : "";

//echo (file_get_contents('php://input'));
//echo var_dump($data);
//$UserName = $data['UserName'];

//$file =   $_FILES;

//echo var_dump($file);
//echo var_dump($_FILES);
//exit();

 $json1 = array("CompanyName" => $CompanyName , "description" => $description, "joining_date" => $joining_date, "Total_monthly_rent" => $Total_monthly_rent, "company_type" => $CompanyType,"officeId"=>$officeId);
 // Insert data into data base
$sql = "INSERT INTO company (company_name, description, joining_date,Total_monthly_rent,company_type,office_id) VALUES ('" . $CompanyName . "', '" . $description . "', '" . $joining_date . "', '" . $Total_monthly_rent . "', '" . $CompanyType . "','".$officeId."');";
 $qur = $conn->query($sql);
   $id = $conn->insert_id;
 $json1['companyId'] = $id;
 if($qur){
 foreach($companySeats as $companySeat){
// echo var_dump($companySeat);
//exit();
 $typesOfSeat =  isset($companySeat['typesOfSeats']) ? mysqli_real_escape_string($conn,$companySeat['typesOfSeats']) : '';
  $numberofseats = (int) isset($companySeat['numberofseats']) ? mysqli_real_escape_string($conn,$companySeat['numberofseats']) : 0;
  $companySeatSql = " INSERT INTO company_seats ( type_of_seats, no_of_seats,company_id) VALUES ('" . $typesOfSeat . "', '" . $numberofseats . "', '" . $id . "');";
  $copanyQur = $conn->query($companySeatSql);
   if($copanyQur){
   // $json = array("status" => 0, "msg" => "Error adding register company!". $conn->error);
   }else{
    $json = array("status" => 0, "msg" => "Error adding register company!". $conn->error);
   }
 }
 
 $to      = "baddala.venugopalreddy@gmail.com";
  $email      = "baddala.venugopalreddy@gmail.com";
 $messageBody = '';

                                     $subject = "Registration success";
                                     $message ="Your registration has been successfull.

                                            Please click on the following link to activate you account.
											
											<a href='http://members.cospaze.in/activate-account'>Activate</a>


															Regards,
															Team Cospaze";
                                    $headers = "From: " .$email. "\r\n";
                                    $headers .= "Reply-To: ".$email. "\r\n";
                                    
                                    $headers .= "MIME-Version: 1.0\r\n";
                                    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                                    
                                    $messageBody .= '<body>
                                    <div class="div2" style=" width: 609px;  padding: 50px; background-color:#CCC;">
                                                                        <div class="div1" style=" background-color:white; border: 1px solid white;  margin-left: 30px; width: 550px; font-size:14px;">
                                                                                
                                                                                
                                          <h1>Contact Person  Message</h1>
                                          
										  <p>
                                         <b> subject </b> :'. $subject .' </p>
                                          <p>
                                        <b>message </b> : '. $message .' </p>';
                                            
                                            $messageBody .=' 
                                            </div>
                                    </div>
                                    </body>';
                              
                              mail($to, $subject, $messageBody, $headers);
 
 $json = array("status" => 1, "msg" => "Done register company added!",'details'=>$json1);
 }else{
 $json = array("status" => 0, "msg" => "Error adding register company!". $conn->error);
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