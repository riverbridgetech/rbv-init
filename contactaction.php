<?php

error_reporting(E_ALL);

// var_dump("test");exit();

require("PHPMailer/class.phpmailer.php");

date_default_timezone_set('Asia/Calcutta');

if($_POST['name'] != "" && isset($_POST['name']))
{
    $name = $_POST['name']; 
}
else
{
   echo '<div class="error_message">You must enter your name.</div>';
   exit();
}

if($_POST['email'] != "" && isset($_POST['email']))
{
    $email = $_POST['email']; 
    // $sanitized_a = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // echo("$email is a valid email address");
    } 
    else 
    {
        // echo("$email is not a valid email address");
        echo '<div class="error_message">You have enter an invalid e-mail address, try again.</div>';
        exit();
        
    }
}
else
{
   echo '<div class="error_message">You have enter an invalid e-mail address, try again.</div>';
   exit();
}


// if($_POST['subject'] != "" && isset($_POST['subject']))
// {
//     $subject = $_POST['subject']; 
// }
// else
// {
//    echo '<div class="error_message">Please enter your subject.</div>';
//    exit();
// }


if($_POST['comments'] != "" && isset($_POST['comments']))
{
    $comments = $_POST['comments']; 
}
else
{
   echo '<div class="error_message">Please enter your message.</div>';
   exit();
}


	$mail = new PHPMailer();

    $mail->IsSMTP();                           // tell the class to use SMTP

	$mail->SMTPAuth   = "true";                  // enable SMTP authentication

	$mail->Port       = 587;                    // set the SMTP server port

	$mail->Host       = "mail.riverbridgeventures.com"; // SMTP server

 	$mail->Username   = "mail@riverbridgeventures.com";     // SMTP server username

 	$mail->Password   = "M2020ail@!rbv";  

	$mail->From     = "info@riverbridgeventures.com";

	$mail->FromName = "Contact @ riverbridgeventures";


	$mail->AddAddress("punit@riverbridgeventures.com","Contact Form");

	$mail->WordWrap = 50;                              // set word wrap

	$mail->IsHTML(true);                               // send as HTML

	$mail->Subject  =  "Riverbridgeventures - Contact Form Enquiry";

	$body =  "<table border='1'><tr><td>Name</td><td>".$name."</td></tr><tr><td>Email</td><td>".$email."</td></tr><tr><td>Mobile No</td><td>".$_POST['phone']."</td></tr><tr><td>Message</td><td>".$comments."</td></tr></table>";

	
	
	

	$mail->Body=$body;

	$success=$mail->send();

		if ($success)
		{
			echo '<div class="success">Thank you, your message has been submitted to us.</div>';
			exit();
		}
		else
		{
		    echo '<div class="error_message">Something Went Wrong! Please try Later.</div>';
			exit();
		}
			


