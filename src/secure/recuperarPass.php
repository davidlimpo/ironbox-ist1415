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
			$conn = new mysqli('localhost','root','passworddabd','server_database');

			$stmt = $conn->prepare("SELECT user FROM users WHERE USER=?");
			$stmt->bind_param("s", $_POST['user']);
			$stmt->execute();
			if($stmt->fetch()){	//se o user existir
				$from    = 'From: ironboxnoreply@gmail.com';
				$to      = $_POST['user'];
				$subject = 'Password Recovery';
				$message = 'Click on the link bellow to recover your account password .'."\r\n";
				$message .= 'Please ignore this e-mail if you did not ask it.' . "\r\n";
				$message .= 'https://192.168.1.1/renovarPass.html?u=';
				$message .= $_POST['user'];
				mail($to, $subject, $message, 'From: ironboxnoreply@gmail.com');

				echo '<html>';
					echo '<script>alert("Verifique o seu email para recuperar a password.")</script>';
				echo '</html>';
			}
			else{
				echo '<html>';
					echo '<script>alert("Utilizador inexistente.")</script>';
					echo '<meta HTTP-EQUIV="REFRESH" content="0; url=https://192.168.1.1/home.html">';
				echo '</html>';
			}
			$stmt->close();
			$conn->close();
		?>

	</body>
</html>
