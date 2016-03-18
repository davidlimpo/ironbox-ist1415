<!doctype html>
<html lang="en">
	<head>
		<title>IronBox</title>
		<meta charset="utf-8">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="index.css" rel="stylesheet">
		<script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/aes.js"></script>

	</head>
	<body>

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
			$conn2 = new mysqli('localhost','root','passworddabd','server_database');

			if($stmt = $conn->prepare("SELECT * FROM users WHERE USER=?")){
				$stmt->bind_param("s", $_GET['u']);
				$stmt->execute();
				if($stmt->fetch()){	//ja existe
					$stmt->close();
					$conn->close();

					echo '<html>';
						echo '<script>alert("O utilizador ja se encontra registado.")</script>';
						echo '<meta HTTP-EQUIV="REFRESH" content="0; url=https://192.168.1.1/home.html">';
					echo '</html>';

					return;
				}
				else{	//n existe e portanto adiciona á bd

					$codigo = generateRandomString();

					if($stmt2 = $conn2->prepare("INSERT INTO users (user,password,code,active,salt,tries) VALUES (?,?,?,?,?,?)")){
						$stmt2->bind_param("sssisi", $_GET['u'], $_GET['p'], $codigo, $active = 0, $_GET['s'], $tries = 0);
						$stmt2->execute();

						$stmt2->close();
						$conn2->close();

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
					}
				}
			}
		?>

	</body>
</html>
