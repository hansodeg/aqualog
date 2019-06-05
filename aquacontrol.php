<?php
session_start();
include_once 'config/database.php';
include_once 'objects/proveObject.php';
include_once 'objects/user.php';


	if($_SESSION['login'] == true){
		echo "";
	}else{
		header("Location: login.php?login=false");
	}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name=viewport content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href='https://fonts.googleapis.com/css?family=Major+Mono+Display' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
    <title>Aqualogg - hovedside</title>
    <h1>AquaControl</h1>
</head>

<body>
    <div class="buttongroup">
    <button onClick="location.href='aqualogg.php'" type="button">AquaLogg</button>
    <button onClick="location.href='workflow.php'" type="button">Workflow</button>
    <button type="button">TimeListe</button>
    <?php
    if($_SESSION['admin'] == 2){ ?>
      <button onClick="location.href='admin.php'" type="button">Admin</button>
    <?php
      }  
    ?>
</div>
</body>

