<?php
namespace RecipeSystem;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Controller
{
    
    function __construct() 
    {
        # code...
    }

    public function GetSystemIPAddress() 
    {
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['HTTP_CF_CONNECTING_IP']))
			$ipaddress = $_SERVER['HTTP_CF_CONNECTING_IP'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';

        return $ipaddress;
    }

    public function view($value, $data = "") 
    {
        include __DIR__."/../view/$value.php";
    }

    public function sendMail($fromemail, $fromname, $receiveremail, $ccemail, $bccemail, $receivername, $emailtext, $emailsubject, $attachments)
    {
    	$mail = new PHPMailer(true);
    	try {
	    	//Server settings
		    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
		    $mail->isSMTP();                                      // Set mailer to use SMTP
		    $mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
		    $mail->SMTPAuth = true;                               // Enable SMTP authentication
		    $mail->Username = 'user@example.com';                 // SMTP username
		    $mail->Password = 'secret';                           // SMTP password
		    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		    $mail->Port = 587;                                    // TCP port to connect to


			if($fromemail == "") {
				$mail->setFrom('test@test.com', 'Test');
				//$mail->AddReplyTo($fromemail,$fromname);
			}
			else {
				$mail->setFrom($fromemail, $fromname);
				$mail->setFrom('test@test.com', 'Test');
				$mail->AddReplyTo($fromemail,$fromname);
			}
	    	
			if($ccemail != "") {
				$ccemails = explode(',', $ccemail);
				foreach ($ccemails as $key => $value) {
					$mail->addCC($value);
				}
			}
			if($bccemail != "") {
				$bccemails = explode(',', $bccemail);

				foreach ($bccemails as $key => $value) {
					$mail->addBCC($value);
				}
			}
			if($receiveremail != "") {
				$receiveremails = explode(',', $receiveremail);
				foreach ($receiveremails as $key => $value) {
					if($receivername != "") {
						$mail->addAddress($value, $receivername);     // Add a recipient
					}
					else {
						$mail->addAddress($value, "");     // Add a recipient
					}
				}
			}
			if($attachments != "") {
				foreach ($attachments as $key => $value) {
					$mail->addAttachment($value);         // Add attachments
				}
			}
	    			
			$mail->isHTML(true);                                  // Set email format to HTML

			$mail->Subject = $emailsubject;
			$mail->Body    = $emailtext;
			//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			if(!$mail->send()) {
			    echo 'Message could not be sent. Mailer Error: '. $mail->ErrorInfo;
			} else {
			    return true;
			}
		} catch (Exception $e) {
		    echo 'Message could not be sent. Mailer Error: '. $mail->ErrorInfo;
		}
    }
}