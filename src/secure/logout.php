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

    <?php
      session_unset();
      session_destroy();
      header("Location: https://192.168.1.1/home.html"); /* Redirect browser */
    ?>

  </body>
</html>
