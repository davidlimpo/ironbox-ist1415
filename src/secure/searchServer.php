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

</head>
<body>

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="zeroclipboard-master/dist/ZeroClipboard.js"></script>

	<?php
		include('phpseclib0.3.9/Crypt/AES.php');

		$salt = $_SESSION["pass"];
		$key = hash('sha512', $_SESSION['user'] . $salt);	//cria a key do user

		$cipher = new Crypt_AES();
		$cipher->setKey($key);

		$conn = new mysqli('localhost','root','passworddabd','server_database');

		if($stmt = $conn->prepare("SELECT * FROM serverspass WHERE USER=? AND SERVICE=?")){
			$stmt->bind_param("ss", $_SESSION['user'], $_POST['searchService']);
			$stmt->execute();
			$stmt->bind_result($user, $service, $password);
			if($stmt->fetch()){
				echo '<html>';
				echo '<body>';
				echo		'<button id="copy-button" data-clipboard-text="' . $cipher->decrypt($password) . '" title="Click to copy password.">Click to copy password to clipboard</button>';
				echo		'<script src="ZeroClipboard.js"></script>';
				echo		'<script>';
				echo		 'var client = new ZeroClipboard( document.getElementById("copy-button") );';
				echo			'client.on( "ready", function( readyEvent ) {';
				echo				'client.on( "aftercopy", function( event ) {';
				echo					'alert("Password copied to clipboard!");';
				echo				'} );';
				echo			'} );';
				echo		'</script>';
				echo	'</body>';
				echo '</html>';
			}

			$stmt->close();
			$conn->close();
			//echo
		}
	?>

	<form action="index.html" method="post">
    	<input type="submit" value="Home"</button>
	</form>












</body>
</html>
