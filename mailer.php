<?php
require 'vendor/autoload.php';
Dotenv::load(__DIR__);

$api_key           = $_ENV['API_KEY'];
$from              = $_ENV['FROM'];
$to                = $_ENV['TO'];

$name = $_POST['name'];
$emailadd = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

$sendgrid = new SendGrid($api_key);
$email    = new SendGrid\Email();
$email->addTo($to)->
       setFrom($from)->
       setFromName("問合せフォーム")->
       setSubject("[ContactForm] $subject")->
       setText("Name: $name \r\nEmail: $emailadd \r\nSubject: $subject \r\nMessage: $message \r\n")->
       setHtml("<strong>Name:</strong> $name<br /> <strong>Email:</strong> $emailadd<br /> <strong>Subject:</strong> $subject<br /> <strong>Message:</strong> $message<br /> ")->
       addCategory('contact');

try {
  $response = $sendgrid->send($email);
  if ($response->code !== 200) {
    var_dump($response);
  }
  // 正常終了時にthanks.htmlへリダイレクト
  header('Location: thanks.html');
} catch (Exception $e) {
  var_dump($e);
}
exit();
