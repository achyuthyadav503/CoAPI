  <?php

include_once('confi.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){
	
$data = json_decode(file_get_contents('php://input'), true);
$UserName = isset($data['UserName']) ? mysqli_real_escape_string($conn,$data['UserName']) : "";
$Email = isset($data['Email']) ? mysqli_real_escape_string($conn,$data['Email']) : "";
$PassWord = isset($data['PassWord']) ? mysqli_real_escape_string($conn,$data['PassWord']) : "";
$MobileNo = isset($data['MobileNo']) ? mysqli_real_escape_string($conn,$data['MobileNo']) : "";
$OfficeId = (int) isset($data['OfficeId']) ? mysqli_real_escape_string($conn,$data['OfficeId']) : "";
$role = isset($data['role']) ? mysqli_real_escape_string($conn,$data['role']) : "";
$status = 1;

//echo (file_get_contents('php://input'));
//echo var_dump($data);
//$UserName = $data['UserName'];

/*$name = 'kishan';
$email = "jhgjygj";
$password = 'hgjg';
$status = 1;
*/


 $json1 = array("name" => $UserName , "email" => $Email,"status" => $status, "password" => $PassWord, "MobileNo" => $MobileNo);
 // Insert data into data base
$sql = "INSERT INTO users (name, email, pwd,mobile, status,office_id,role) VALUES ('" . $UserName . "', '" . $Email . "', '" . $PassWord . "', '" . $MobileNo . "', '" . $status . "','".$OfficeId."','".$role."');";
 $qur = $conn->query($sql);
 if($qur){
	 
	  $to      = $Email;
	 $email      = $Email;
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
	 
 $json = array("status" => 1, "msg" => "Done User added!",'details'=>$json1);
 }else{
 $json = array("status" => 0, "msg" => "Error adding user!". $conn->error);
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