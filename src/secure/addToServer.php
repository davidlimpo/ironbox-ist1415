<?php
session_start();
?>
<!doctype html>
<html lang="en">
	<head>
		<title>IronBox</title>
		<meta charset="utf-8">

		<!-- Bootstrap -->
	    <link href="css/bootstrap.min.css" rel="stylesheet">
	    <link href="index.css" rel="stylesheet">

	    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->

	</head>
	<body>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	    <!-- Include all compiled plugins (below), or include individual files as needed -->
	    <script src="js/bootstrap.min.js"></script>

		<?php
			include('phpseclib0.3.9/Crypt/AES.php');

			$salt = $_SESSION["pass"];
			$key = hash('sha512', $_SESSION['user'] . $salt);	//cria a key do user

			$cipher = new Crypt_AES();
			$cipher->setKey($key);
			$plaintext = $_POST['addPassword'];
			$passCiphered = $cipher->encrypt($plaintext);

			$conn = new mysqli('localhost','root','passworddabd','server_database');
			$conn2 = new mysqli('localhost','root','passworddabd','server_database');

			if($stmt = $conn->prepare("SELECT * FROM serverspass WHERE USER=? AND SERVICE=?")){
				$stmt->bind_param("ss", $_SESSION['user'], $_POST['addService']);
				$stmt->execute();
				if($stmt->fetch()){
					if($stmt2 = $conn2->prepare("UPDATE serverspass SET password=? WHERE user=? AND service=?")){
						$stmt2->bind_param("sss", $passCiphered, $_SESSION['user'], $_POST['addService']);
						$stmt2->execute();

						$stmt->close();
						$conn->close();

						$stmt2->close();
						$conn2->close();
					}
				}
				else {
					$conn3 = new mysqli('localhost','root','passworddabd','server_database');

					if($stmt3 = $conn3->prepare("INSERT INTO serverspass (user,service,password) VALUES (?,?,?)")){
						$stmt3->bind_param("sss", $_SESSION['user'], $_POST['addService'], $passCiphered);
						$stmt3->execute();

						$stmt->close();
						$conn->close();

						$stmt3->close();
						$conn3->close();
					}
				}
			}
		?>

		<form action="index.html" method="post">
	    	<input type="submit" class="button myButton custom" value="Home"</button>
		</form>

	</body>
</html>
