<?php
error_reporting(E_ALL);


require("PHPMailer/class.phpmailer.php");



date_default_timezone_set('Asia/Calcutta');



$dt=date('Y-m-d H:i:s');



$name=$_POST['senderName'];



$company=$_POST['senderCompany'];



$email=$_POST['senderEmail'];



$email_cnt=$_POST['email_cnt'];



$sanitized_a = filter_var($email, FILTER_SANITIZE_EMAIL);



if (filter_var($sanitized_a, FILTER_VALIDATE_EMAIL)) {



	



if($sanitized_a!="" && $name!="")



{



	



	



	$mail = new PHPMailer();



    $mail->Mailer = "smtp";



	$mail->IsSMTP();                           // tell the class to use SMTP



	$mail->SMTPAuth   = "true";                  // enable SMTP authentication



	$mail->SMTPSecure = "tls";                 //TLS 



	$mail->Port       = 587;                    // set the SMTP server port



	$mail->Host       = "smtp.gmail.com"; // SMTP server



	$mail->Username   = "info@kagashin.com";     // SMTP server username



	$mail->Password   = "1nf0.kgn.123";            // SMTP server password



	



	//	$mail->IsSendmail();  // tell the class to use Sendmail



		



$mail->From     = "info@kagashin.com";



$mail->FromName = "Team Kagashin";



$mail->AddAddress($sanitized_a,$name);



              // optional name







$mail->WordWrap = 50;                              // set word wrap







$mail->IsHTML(true);                               // send as HTML







$mail->Subject  =  "Team Kagashin";











$body =  "Dear " .$name.",<br><br>Thank You for Downloading ".$email_cnt.".pdf from Knowledge Base.<br>Kindly check below attachment. <br><br>Thanks and Regards<br>Team Kagashin";



	



$mail->Body=$body;







if($email_cnt=="factbook")



{



	$mail->AddAttachment("India_Factbook.pdf"); 	



}



elseif($email_cnt=="pharma")



{



	$mail->AddAttachment("IndianPharmaceutical_A_Snapshot.pdf"); 	



}



elseif($email_cnt=="agriculture")



{



	$mail->AddAttachment("IndianAgriculture_A_snapshot.pdf"); 	



}



elseif($email_cnt=="financial2013")



{



	$mail->AddAttachment("Financial_Results_Agchem_companies_annual_13.pdf"); 	



}

elseif($email_cnt=="financial2014")



{



	$mail->AddAttachment("Financial_Results_Agchem_companies_annual_14.pdf"); 	



}



elseif($email_cnt=="financialq12015")



{



	$mail->AddAttachment("Financial_Results_Agchem_companies_Q1_15.pdf"); 	



}



elseif($email_cnt=="financialq22015")



{



	$mail->AddAttachment("Financial_Results_Agchem_companies_Q2_15.pdf"); 	



}

elseif($email_cnt=="financialq32015")



{



	$mail->AddAttachment("Financial_Results_Agchem_companies_Q3_15.pdf");



}

elseif($email_cnt=="financialq42015")



{



	$mail->AddAttachment("Financial_Results_Agchem_companies_Q4_15.pdf");



}

elseif($email_cnt=="financialh12015")



{



	$mail->AddAttachment("Financial_Results_Agchem_companies_H1_15.pdf"); 	



}

elseif($email_cnt=="financialq12016")
{



	$mail->AddAttachment("Financial_Results_Agchem_companies_Q1_16.pdf"); 	
						  


}
elseif($email_cnt=="financialq22016")
{



	$mail->AddAttachment("Financial_Results_Agchem_companies_Q2_16.pdf"); 	



}
elseif($email_cnt=="financialh12016")
{



	$mail->AddAttachment("Financial_Results_Agchem_companies_H1_16.pdf"); 	



}
elseif($email_cnt=="financialq32016")
{



	$mail->AddAttachment("Financial_Results_Agchem_companies_Q3_16.pdf"); 	



}
elseif($email_cnt=="financial092015")
{



	$mail->AddAttachment("Financial_Results_Agchem_companies_9months2015.pdf"); 	



}
elseif($email_cnt=="financialfy2016")
{



	$mail->AddAttachment("Financial_Results_Agchem_companies_FY_16.pdf"); 	



}
elseif($email_cnt=="financialq42016")
{



	$mail->AddAttachment("Financial_Results_Agchem_companies_Q4_16.pdf"); 	



}
















$success1=$mail->send();











//Second instance of the mailer function







	$mail = new PHPMailer();



    $mail->Mailer = "smtp";



	$mail->IsSMTP();                           // tell the class to use SMTP



	$mail->SMTPAuth   = "true";                  // enable SMTP authentication



	$mail->SMTPSecure = "tls";                 //TLS 



	$mail->Port       = 587;                    // set the SMTP server port



	$mail->Host       = "smtp.gmail.com"; // SMTP server



	$mail->Username   = "info@kagashin.com";     // SMTP server username



	$mail->Password   = "1nf0.kgn.123";            // SMTP server password



	



	//	$mail->IsSendmail();  // tell the class to use Sendmail



		



$mail->From     = "info@kagashin.com";



$mail->FromName = "Kagashin.com";



$mail->AddAddress("info@kagashin.com","info");



              // optional name







$mail->WordWrap = 50;                              // set word wrap







$mail->IsHTML(true);                               // send as HTML







$mail->Subject  =  "New Mail from Kagashin.com";











$body =  "<table border='1'><tr><td>Name</td><td>".$name."</td></tr><tr><td>Email</td><td>".$sanitized_a."</td></tr><tr><td>Company</td><td>".$company."</td></tr><tr><td>Download Pdf</td><td>".$email_cnt.".pdf</td></tr></table>";



	



$mail->Body=$body;















$success=$mail->send();



















if (isset($_GET["ajax"])){



  echo $success ? "success" : "error";



		}



		else



		{



		



		?>



			<html>



              <head>



                <title>Thanks!</title>



                  </head>



                  <body>



                  <?php if ( $success ) echo "<p>Thank you for Downloading! Kindly Check Your Mail.</p>" ?>



                  <?php if ( !$success ) echo "<p>1There was a problem downloading. Please try again.</p>" ?>



                  <p>Click your browser's Back button to return to the page.</p>



                  </body>



                </html>



		<?php



		}



	



}



else



{



?>



	<script type="text/javascript">



	alert("Blank entries not allowed");



	history.go(-1);



    </script>



<?php



}



}



else



{



?>



	<script type="text/javascript">



	alert("Email ID Not Valid !!!");



	history.go(-1);



    </script>



<?php



}



		



