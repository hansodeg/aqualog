
<?php
include_once "includes/header.php";

$user = new User($db);

$page_title = "Registrer";
?>
<h1><?php echo $page_title; ?></h1>
<?php
	$username = $_SESSION['navn'];
	if($_SESSION['login'] == true){
	  echo "";
	}else
	{
	header("Location: login.php?login=false");
	}
	//Post to userobject for logout
	if(isset($_POST['logoutBtn'])){
		$user->logout();
	}
	if(isset($_POST['submit'])){
	
	$navn = mysqli_real_escape_string($db, $_POST['navn']);
	$ansattnr = mysqli_real_escape_string($db, $_POST['ansattnr']);
	$passord = mysqli_real_escape_string($db, $_POST['passord']);
	$admin = mysqli_real_escape_string($db, $_POST['admin']);
	
	if($user->register($navn, $ansattnr, $passord, $admin)){
		echo "";
	}else{
		echo '<script language="javascript">';
		echo 'alert("Noe gikk galt, bruker ble ikke opprettet")';
		echo '</script>';
	}
}
?>
<body>
	<div class="logger">
		<form action="" method="post" name="reg" class="prove_form">
		<h2>Registrer ny bruker</h2>  
			<input type="text" name="navn" placeholder="Navn" required>
			<br />
			<input type="text" name="ansattnr" placeholder="Ansattnr" required>
			<br />
			<input type="password" name="passord" placeholder="Passord" required>
			<br />
			<!--<input type="text" name="admin" placeholder="Tilgang" required>-->
			<select name="admin" style="padding: 10px; border-radius: 5px; margin-bottom: 10px; width: 60%;">
				<option value="">Velg rettigheter</option>
				<option value="0">Vaktleder</option>
				<option value="1">Teknisk</option>
				<option value="2">Administrator</option>
			</select>
			<br />
			<button type="submit" input onclick= "return submitreg();" type="submit" name="submit" value="Registrer">Lagre</button>
		</form>
	</div>
	