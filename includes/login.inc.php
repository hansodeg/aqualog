<?php

session_start();

if(isset($_POST['submit'])){
	include_once '../config/database.php';
	$database = new Database();
	$db = $database->connect();

	$ansattnr = mysqli_real_escape_string($db, $_POST['ansattnr']);
	$password = mysqli_real_escape_string($db, $_POST['passord']);

	//error handler
	if(empty($ansattnr) || empty($password)){
		header("Location: ../index.php?login=empty");
		exit();
	}else{
		$sql = "SELECT * FROM bruker WHERE ansattnr = " . $ansattnr;
		$result = mysqli_query($db, $sql);
		$rowCheck = mysqli_num_rows($result);
		if($rowCheck<1){
			header("Location: ../login.php?login=error");
			exit();
		} else{
			if($row=mysqli_fetch_assoc($result)){
				//Dehash password
				$hashedPwdCheck = password_verify($password, $row['passord']);
				if($hashedPwdCheck == false){
					header("Location: ../login.php?login=error");
					exit();
				}elseif($hashedPwdCheck == true){
					//Login the user here
					$_SESSION['navn'] = $row['navn'];
					$_SESSION['ansattnr'] = $row['ansattnr'];
					$_SESSION['password'] = $row['passord'];
					$_SESSION['admin'] = $row['admin'];
					$_SESSION['login'] = true;
					header("Location: ../aquacontrol.php?login=success");
					exit();
				}
			}
		}
	}
	}else{
		header("Location: ../login.php?login=error");
		exit();
}
?>