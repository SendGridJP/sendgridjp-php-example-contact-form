<?php
require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createMutable(__DIR__);
$dotenv->load();

$sendgrid_apikey   = $_ENV['SENDGRID_APIKEY'];
$from              = $_ENV['FROM'];
$bcc               = $_ENV['BCC'];

$name = $_POST['name'];
$emailadd = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

$sendgrid = new SendGrid($sendgrid_apikey, array("turn_off_ssl_verification" => true));
$email    = new SendGrid\Mail\Mail();
$email->addTo($emailadd);
$email->addBcc($bcc);
$email->setFrom($from, "問合せフォーム");
$email->setSubject("[ContactForm] $subject");
$email->addContent("text/plain", "Name: $name \r\nEmail: $emailadd \r\nSubject: $subject \r\nMessage: $message \r\n");
$email->addContent("text/html", "<strong>Name:</strong> $name<br /> <strong>Email:</strong> $emailadd<br /> <strong>Subject:</strong> $subject<br /> <strong>Message:</strong> $message<br /> ");
$email->addCategory('contact');

$response = $sendgrid->send($email);
//var_dump($response);

// 正常終了時にthanks.htmlへリダイレクト
header('Location: thanks.html');
exit();

