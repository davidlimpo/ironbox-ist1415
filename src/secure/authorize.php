<?php

  if(!empty($_GET['code'])){

    $conn = new mysqli('localhost','root','passworddabd','server_database');
    $conn2 = new mysqli('localhost','root','passworddabd','server_database');

    if($stmt = $conn->prepare("SELECT * FROM users WHERE code=?")){
      $stmt->bind_param("s", $_GET['code']);
      $stmt->execute();
      if($stmt->fetch()){
        if($stmt2 = $conn2->prepare("UPDATE users SET active=1 WHERE code=?")){
          $stmt2->bind_param("s", $_GET['code']);
          $stmt2->execute();

          $stmt2->close();
          $conn2->close();

          echo '<html>';
            echo '<script>alert("Conta activada com sucesso.")</script>';
            echo '<meta HTTP-EQUIV="REFRESH" content="0; url=https://192.168.1.1/login.html">';
          echo '</html>';
        }
      }
      $stmt->close();
      $conn->close();
    }
  }
?>
