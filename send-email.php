<?php
require 'vendor/autoload.php';

use Dotenv\Dotenv as Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
$sendgrid_key = $_ENV['SENDGRID_API_KEY'];

// * SENDGRID CODE FOR SENDING EMAIL

$email = new \SendGrid\Mail\Mail();
$email->setFrom("faisalchaudhry1133@gmail.com", "Faisal Chaudhry");
$email->setSubject("Sending with Twilio SendGrid is Fun");
$email->addTo("robilaqaiser@gmail.com", "Robila Qaiser");
$email->addContent("text/plain", "and easy to do anywhere, even with PHP");
$email->addContent(
  "text/html",
  "<strong>and easy to do anywhere, even with PHP</strong>"
);
$sendgrid = new \SendGrid($sendgrid_key);
try {
  $response = $sendgrid->send($email);
  print $response->statusCode() . "\n";
  print_r($response->headers());
  print $response->body() . "\n";
} catch (Exception $e) {
  echo 'Caught exception: ' . $e->getMessage() . "\n";
}


?>