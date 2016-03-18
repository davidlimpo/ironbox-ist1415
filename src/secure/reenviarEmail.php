<?php

  function generateRandomString($length = 20) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    $randomString .= $_GET['u'];
    return $randomString;
  }

  $conn = new mysqli('localhost','root','passworddabd','server_database');
  if($stmt = $conn->prepare("SELECT code FROM users WHERE USER=?")){
    $stmt->bind_param("s", $_GET['u']);
    $stmt->execute();
    $stmt->bind_result($codigo);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
  }

  $from    = 'From: ironboxnoreply@gmail.com';
  $to      = $_GET['u'];
  $subject = 'Registration';
  $message = 'Click on the link bellow to activate your ironbox account.'."\r\n";
  $message .= 'https://192.168.1.1/authorize.php?code=';
  $message .= $codigo;
  mail($to, $subject, $message, 'From: ironboxnoreply@gmail.com');

  echo '<html>';
    echo '<script>alert("Verifique o seu email para activar a conta.")</script>';
    echo '<meta HTTP-EQUIV="REFRESH" content="0; url=https://192.168.1.1/home.html">';
  echo '</html>';

?>
