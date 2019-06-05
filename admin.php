<?php
session_start();

include_once 'config/database.php';
include_once 'objects/proveObject.php';
include_once 'objects/user.php';

$page_title = 'Admin';
$table_name = '*';

$database = new Database();
$db = $database->connect();
$allTables = new User($db);
$oversikt = new proveObject($db);
$table = $allTables->showAllUsers();

$username = $_SESSION['navn'];

$max = 360;
$min = 0;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name=viewport content="width=device-width, initial-scale=1.0">
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css">
		<link href='https://fonts.googleapis.com/css?family=Major+Mono+Display' rel='stylesheet'>
		<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
	<title>Admin</title>
	<div id="main">
	<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
	<a href="oversikt.php">Oversikt</a>
  <a href="barneanlegget.php">Barneanlegget</a>
  <a href="nedrenedre.php">Nedre nedre</a>
  <a href="nedreovre.php">Nedre Øvre</a>
  <a href="ovre.php">Øvre</a>
  <a href="flowrider.php">Flowrider</a>
  <a href="boverstranda.php">Bøverstranda</a>
  <a href="splash.php">Splash</a>
  <a href="aquacontrol.php">AquaControl</a>
  <a href ="workflow.php">Workflow</a>
  <a href ="timeplan.php">Timeliste</a>
  <form class="prove_form" method="post" action="" >
	<button id ="logout" type="submit" name="logoutBtn">Logg ut</button>
		<h3> <?php $allTables->showUsername($username); ?> </h3>
	</form>
  
</div>
  <span style="font-size:50px;cursor:pointer" onclick="openNav()">&#9776</span>
	<script src="script/menu.js"></script> 
<h1><?php echo $page_title; ?></h1>
	<script type="text/javascript" src="table.js"></script>
</head>
<body>
<?php
	if($_SESSION['login'] == true){
    echo "";
	}else{
		header("Location: login.php?login=false");
    }

    if(isset($_POST['logoutBtn'])){
		$allTables->logout();

	}

    if(isset($_POST['delete'])){
        $allTables->deleteUser($_POST['delId']);
    }
    ?>
    <div class ="logger">
        <button class="admin" onClick="location.href='register.php'">Registrer</button>
    
    <button class="admin" onclick="window.location.href='ansatte.php'">Brukere</button>
    <button class="admin" onclick="window.location.href='edit_database.php'">DatabaseAdm</button>
    </div>
    <div class ="present">
    <!--<?php
        $oversikt->showAll($max, $min);
    ?>-->
</div> 
</body>
</html>