  <?php

include_once('confi.php');

if($_SERVER['REQUEST_METHOD'] == "GET"){

	  $to      = "baddala.venugopalreddy@gmail.com";

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
	 
 
 
} 


?>