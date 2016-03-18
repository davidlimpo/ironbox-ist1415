<?php

  $conn = new mysqli('localhost','root','passworddabd','server_database');

  $stmt = $conn->prepare("UPDATE users SET salt=?, password=? WHERE user=?");
  $stmt->bind_param("sss", $_GET['s'], $_GET['p'], $_GET['u']);
  $stmt->execute();
  $stmt->fetch();

  $stmt->close();
  $conn->close();

  echo '<html>';
    echo '<script>alert("Password actualizada com sucesso.")</script>';
    echo '<meta HTTP-EQUIV="REFRESH" content="0; url=https://192.168.1.1/home.html">';
  echo '</html>';
?>
