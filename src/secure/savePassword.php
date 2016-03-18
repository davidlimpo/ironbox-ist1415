<?php
	session_start();
?>
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
			$_SESSION["pass"] = $_POST["pass"];
			header("Location: https://192.168.1.1/verifyLogin.php?u=" . $_POST["hiddenUser"] . "&p=" . $_POST["hiddenHash"]);
			exit();
		?>

	</body>
</html>
