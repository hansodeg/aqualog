


<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name=viewport content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href='https://fonts.googleapis.com/css?family=Major+Mono+Display' rel='stylesheet'>
	<title>Login</title>
	<h1>Logg Inn<h1>
</head>
<body>
	<div class="login_page">
	<form class="form" action="includes/login.inc.php" method="post">
		<input type="text" name="ansattnr" placeholder="Ansattnr" required>
		<input type="password" name="passord" placeholder="Passord" required>
		<button type="submit" name="submit">Login</button>
		</div>
	</form>
</body>
</html>

