<?php
require_once('includes/class.smtp.php');
require_once('includes/class.phpmailer.php');
require('includes/config.php');

// Change $prod to 1 if the deploying to production.
$prod = 0;
$mport = 25;

if (!empty($prod))
  $mserver = 'mta1.tavant.com';
else
  $mserver = 'blrcswexv01.in.corp.tavant.com';



$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
$phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
$path = filter_input(INPUT_POST, 'path', FILTER_SANITIZE_STRING);
$company = filter_input(INPUT_POST, 'company', FILTER_SANITIZE_STRING);

if (empty($name) && empty($email) && empty($phone)) {
  echo "0";
  exit;
}

$subject = "Tavant Velox - Demo Request";
$message = "";
$message .= '<table>';
$message .= '<tr>';
$message .= '<td>Name:</td>';
$message .= '<td>' . $name . '</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td>Email:</td>';
$message .= '<td>' . $email . '</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td>Phone:</td>';
$message .= '<td>' . $phone . '</td>';
$message .= '</tr><tr>';
$message .= '<td>Company:</td>';
$message .= '<td>' . $company . '</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td>Path:</td>';
$message .= '<td>' . $path . '</td>';
$message .= '</tr>';
$message .= '</table>';
/* $headers = "MIME-Version: 1.0" . "\r\n";
  $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
  $headers .= 'From: <admin@velox.com>' . "\r\n";
  $send = mail($to,$subject,$message,$headers);
  if($send){
  echo 'done';
  } */

$mail = new PHPMailer();

$mail->SMTPSecure = '';  // sets the prefix to the server

$mail->Host = $mserver; // SMTP Host

$mail->Port = $mport;
$mail->IsSMTP(); // use SMTP
//$mail->SMTPDebug = true;
$mail->FromName = 'No Reply'; // readable name
$mail->From = 'noreply@tavant.com';
$mail->Subject = $subject;

//$to = array('swaroop.bs@tavant.com', 'suchi.goyal@tavant.com', 'arun.balaraman@tavant.com', 'anirudh.lokkur@tavant.com');
//$cc = array('revathy.arumugam@tavant.com', 'ganesan.g@tavant.com');
//$to = array('revathy.arumugam@tavant.com', 'ganesan.g@tavant.com', 'swaroop.bs@tavant.com', 'suchi.goyal@tavant.com');
$to = array('mahesh.pusala@tavant.com');
foreach ($to as $to_email) {
  $mail->AddAddress($to_email); // recipients email
}

if (!empty($cc)) {
  foreach ($cc as $cc_email) {
    $mail->AddCC($cc_email); // CC email
  }
}


$mail->MsgHTML($message);
$status = "";
if (!$mail->Send()) {
  ob_clean();
  error_log('Couldn\'t send email.Details are subject: ' . $subject . ' ' . 'Message: ' . $message, 0);
  echo "0";
  $status = "Couldn\'t send email";
}
else {
  ob_clean();
  error_log('Mail sent successfully!');
  echo "1";
  $status = "Mail sent successfully!";
}
// insert log into database
$stmt = $db->prepare("INSERT INTO `email_log` (`email`, `phone`, `company`, `source`, `status`) VALUES (:email, :phone, :company, :source, :status)");
$stmt->execute(array(
							':email' => $email,
							':phone' => $phone,
							':company' => $company,
							':source' => $path,
							':status' => $status
			));




