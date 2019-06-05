<?php
class User{
	private $conn;

	public function __construct($db){
		$this->conn = $db;
	}

	public function register($name, $ansattnr, $pass, $admin){
		$pregName = "/^[a-åA-Å]*$/";
		$pregNr = "/^[0-9]*$/";
		$pregAdmin = "/^[0-2]*$/";
		$pregPass = "^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$^";

		$this->name = $name;
		$this->ansattnr = $ansattnr;
		$this->pass = $pass;
		$this->admin = $admin;

		//Invalid input if it does not match criteria
		if(!preg_match($pregName, $name) || !preg_match($pregNr, $ansattnr) || !preg_match($pregAdmin, $admin) || !preg_match($pregPass, $pass)){
			echo '';
		}
		else{
			//Check if ansattnr is unique
			$sql = "SELECT ansattnr FROM bruker WHERE ansattnr=?";
			$check = mysqli_prepare($this->conn, $sql);
			$check->bind_param("i", $ansattnr);
			$check->execute();
			$checkRow = mysqli_num_rows($check->get_result());
			if($checkRow>0){
				echo '<script language="javascript">';
				echo 'alert("Noe gikk galt, bruker ble ikke opprettet")';
				echo '</script>';
			exit();
			}else{
				//prepared statment for registering user
				$stmt = mysqli_prepare($this->conn, "INSERT INTO bruker(navn, ansattnr, passord, admin) Values(?, ?, ?, ?)");
				$password = strip_tags($pass);
				$inName = strip_tags(utf8_encode($name));
				$inAnsattnr = strip_tags($ansattnr);
				$inAdmin = strip_tags($admin);

				//hash password
				$hashedPws = password_hash($password, PASSWORD_DEFAULT);
				$stmt->bind_param("sisi", $inName, $inAnsattnr, $hashedPws, $inAdmin);
	
				//executes the statement
			if($stmt->execute()){
				return true;
			}
			else{
				return false;
				echo var_dump($stmt);
			}
		}
	}
}

	//Change password for admin user
	//Change password for admin user
	public function changePwAdmin($ansattnr, $pwd1, $pwd2){
		$passwordregex = '^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$^';
		$this->ansattnr = $ansattnr;
		$this->pwd1 = $pwd1;
		$this->pwd2 = $pwd2;

		if($pwd1 == $pwd2){
			$sql = "SELECT * FROM bruker WHERE ansattnr=?";
			$stmt = mysqli_prepare($this->conn, $sql);
			$stmt->bind_param("i", $ansattnr);
			if($stmt->execute()){
				$result = $stmt->get_result();
				$row = $result->fetch_assoc();
				if(preg_match($passwordregex, $pwd1)){
					$sql2 = "UPDATE bruker SET passord=? WHERE ansattnr=?";
					$stmt2 = mysqli_prepare($this->conn, $sql2);
					$hashNewPw = password_hash($pwd1, PASSWORD_DEFAULT);
					$stmt2->bind_param("si", $hashNewPw, $ansattnr);
					if($stmt2->execute()){
						header("Location: ansatte.php?changepassword=success");
					}
			}else{
		}
		}
	}else{
		echo "Fikk ikke endret passord";
	}
	}
	public function showUsername($username){
		$db = $this->conn;
		$sql = "SELECT navn FROM bruker WHERE navn ='$username'";
		$result = mysqli_query($db, $sql);
		if($result){
			echo $username;
		}
	}
	
	public function check_login($ansattnr, $password){
		$password = md5($password);
		$sql = "SELECT ansattnr FROM bruker WHERE ansattnr='$ansattnr' and passord='$password'";
		$result = mysqli_query($this->conn, $sql);
		$userData = mysqli_fetch_array($result);
		$countRow = $result->num_rows;
		if($countRow == 1){
			$_SESSION['login'] = true;
			$_SESSION['ansattnr'] = $data['ansattnr'];
			return true;
		}else{
			return false;
		}

	}


	public function session(){
			if($_SESSION['login'] == true){
				return true;
			}else{
				header("Location: login.php");
				return false;
			}
		}
	


	
	public function showAllUsers(){
		$db = $this->conn;
		if(empty($db)){
			$this->connect();
			$db = $this->conn;
		}
		try{
			$stmt = $this->conn->prepare("SELECT * FROM bruker");
			$stmt->execute();
			$result = $stmt->get_result();
			$dataArray = array(); //array for radene i tabellen
			while($row = $result->fetch_assoc()){
				$dataArray[] = $row;
			}
		
		return ($dataArray);
		mysqli_close($db);
		$this->db = null;
	}catch(Exception $e){
		echo $e->errorMessage();
	}
	}

	public function setAnsattnrAsNullVann($ansattnr){
		$db = $this->conn;
		$this->ansattnr = $ansattnr;
		$stmt = $db->prepare("UPDATE vannprover SET ansattnr = null WHERE ansattnr = ?;");
		$stmt->bind_param("i", $this->ansattnr);
		if($stmt->execute()){
			$stmt2 = $db->prepare("UPDATE labprover SET ansattnr = null WHERE ansattnr = ?;");
			$stmt2->bind_param("i", $this->ansattnr);
			$stmt2->execute();
		}else{
			echo var_dump($stmt);
		}
	}

	public function setAnsattnrAsNullLab($ansattnr){
		$db = $this->conn;
		$this->ansattnr = $ansattnr;
		$stmt2 = $db->prepare("UPDATE labprover SET ansattnr = null WHERE ansattnr = ?;");
		$stmt2->bind_param("i", $this->ansattnr);
		if($stmt2->execute()){
			echo "Labprove as null";
		}else{
			echo var_dump($stmt2);
		}
	}

	public function deleteUser($ansattnr){
			$db = $this->conn;
			$this->ansattnr = $ansattnr;
			$stmt2 = $this->conn->prepare("DELETE FROM bruker WHERE ansattnr=?");
			$stmt2->bind_param("i", $ansattnr);
			if($stmt2->execute()){
				header("Location:ansatte.php?delete=success");
			}else{
				echo var_dump($stmt2);
			}
			
		}
	

	//logout user
	public function logout(){
		$_SESSION['login'] = false;
		header("Location: login.php?login=false");
		session_destroy();
	}

	public function getName($ansattnr){
		$this->ansattnr = $ansattnr;
		$sql = "SELECT navn FROM bruker WHERE ansattnr=?";
		$stmt = mysqli_prepare($this->conn, $sql);
		$stmt->bind_param("i", $this->ansattnr);
		$stmt->execute();
		$result = $stmt->get_result();
		while($row = $result->fetch_assoc()){
		$name = $row['navn'];
		}
		return $name;
	}
	//Display roles in string
	public function getRole($ansattnr){
		$this->ansattnr = $ansattnr;
		$sql = "SELECT admin FROM bruker WHERE ansattnr=?";
		$stmt = mysqli_prepare($this->conn, $sql);
		$stmt->bind_param("i", $this->ansattnr);
		$stmt->execute();
		$result = $stmt->get_result();
		while($row = $result->fetch_assoc()){
		//Display string depending on admin rights
		if($row['admin'] == 0){
			$role = 'Vaktleder';
		}
		elseif($row['admin'] == 1){
			$role = 'Teknisk';
		}else{
			$role = 'Administrator';
		}
		}
		return $role;
	}
	//Simple return of ansattnr when called
	public function getAnsattnr($ansattnr){
		$this->ansattnr = $ansattnr;
		return $ansattnr;
	}

}
?>