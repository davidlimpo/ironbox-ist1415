<!doctype html>
<html lang="en">
<head>
	<title>IronBox</title>
	<meta charset="utf-8">
</head>
<body>
	<?php
		$conn = new mysqli('localhost','root','passworddabd','server_database');
		if($conn->connect_errno > 0){
			die('Unable to connect to database [' . $db->connect_error . ']');
		}

		if($stmt = $conn->prepare("SELECT * FROM serverspass WHERE USER=?")){
			$stmt->bind_param("s", $_POST['IdUser']);
			$stmt->execute();
			$stmt->bind_result($user, $service, $password);
			while($stmt->fetch()){
				printf("%s %s %s\n", $user, $service, $password);
			}
			$stmt->close();
			$conn->close();
		}
	?>
	
	<ul id="serverList">
	</ul>

</body>
</html>