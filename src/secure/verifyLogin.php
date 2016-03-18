<?php
	session_start();
	$conn = new mysqli('localhost','root','passworddabd','server_database');
	$conn2 = new mysqli('localhost','root','passworddabd','server_database');

	$_SESSION["user"] = $_GET['u'];

		$stmt = $conn->prepare("SELECT * FROM users WHERE user=? AND password=?");	//verifica se está registado e pass correcta
		$stmt->bind_param("ss", $_GET['u'], $_GET['p']);
		$stmt->execute();
		if($stmt->fetch()){	//a pass e o user estao correctos
			$stmt2 = $conn2->prepare("SELECT * FROM users WHERE user=? AND active=1");
			$stmt2->bind_param("s", $_GET['u']);
			$stmt2->execute();
			if($stmt2->fetch()){	//está activo
				header("Location: https://192.168.1.1/index.html"); /* Redirect browser */
			}
			else{	//n está activo
					echo '<html>';
						echo '<script>alert("Active a conta apartir do seu email.")</script>';
						echo '<meta HTTP-EQUIV="REFRESH" content="0; url=https://192.168.1.1/login.html">';
					echo '</html>';
			}
			$stmt2->close();
			$conn2->close();
		}
		else{	//a pass ou o user estao errados
			$stmt2 = $conn2->prepare("SELECT * FROM users WHERE user=?"); //ver se o user existe
			$stmt2->bind_param("s", $_GET['u']);
			$stmt2->execute();
			if($stmt2->fetch()){	//existe, logo falhou a pass => incrementar contador
				$conn3 = new mysqli('localhost','root','passworddabd','server_database');
				$stmt3 = $conn3->prepare("SELECT tries FROM users WHERE user=?");
				$stmt3->bind_param("s", $_GET['u']);
				$stmt3->execute();
				$stmt3->bind_result($tries);
				$stmt3->fetch();
				$conn4 = new mysqli('localhost','root','passworddabd','server_database');
				if($tries > 2){	//BLOQUEIA
						$stmt4 = $conn4->prepare("UPDATE users SET tries=?, active=? WHERE user=?");
						$stmt4->bind_param("iis", $tries = 0, $active = 0, $_GET['u']);
						$stmt4->execute();

						$conn5 = new mysqli('localhost','root','passworddabd','server_database');
						$stmt5 = $conn5->prepare("SELECT code FROM users WHERE USER=?");
						$stmt5->bind_param("s", $_GET['u']);
						$stmt5->execute();
						$stmt5->bind_result($codigo);
						$stmt5->fetch();
						$stmt5->close();
						$conn5->close();

						$from    = 'From: ironboxnoreply@gmail.com';
						$to      = $_GET['u'];
						$subject = 'Registration';
						$message = 'Click on the link bellow to reactivate your ironbox account.'."\r\n";
						$message .= 'https://192.168.1.1/authorize.php?code=';
						$message .= $codigo;
						mail($to, $subject, $message, 'From: ironboxnoreply@gmail.com');

						echo '<html>';
							echo '<script>alert("Conta bloqueada. Aceda ao email para desbloquear a conta.")</script>';
							echo '<meta HTTP-EQUIV="REFRESH" content="0; url=https://192.168.1.1/login.html">';
						echo '</html>';
				}
				else{	//INCREMENTA
						$stmt4 = $conn4->prepare("UPDATE users SET tries=? WHERE user=?");
						$stmt4->bind_param("is", $tries = $tries+1, $_GET['u']);
						$stmt4->execute();

						echo '<html>';
							echo '<script>alert("Utilizador ou password incorrectos.")</script>';
							echo '<meta HTTP-EQUIV="REFRESH" content="0; url=https://192.168.1.1/login.html">';
						echo '</html>';
				}

				$stmt3->close();
				$conn3->close();

				$stmt4->close();
				$conn4->close();
			}
			else{	//n existe
				echo '<html>';
					echo '<script>alert("Utilizador ou password incorrectos.")</script>';
					echo '<meta HTTP-EQUIV="REFRESH" content="0; url=https://192.168.1.1/login.html">';
				echo '</html>';
			}

			$stmt2->close();
			$conn2->close();
		}

		$stmt->close();
		$conn->close();
?>
