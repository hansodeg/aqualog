<?php
class ProveObject{
	private $conn;

	public $proveid;
	public $ansattnr;
	public $klor;
	public $ph;
	public $dpd1;
	public $dpd3;
	public $bundet_klor;
	public $timestamp;
	

	public function __construct($db){
		$this->conn = $db;
	}

	//Sends data to table

	function saveData($ansattnr, $anleggsid, $opprettet, $signatur, $klor, $ph, $dpd1, $dpd3, $bundet_klor, $phenol){
		$db = $this->conn;
		if(ctype_alpha($signatur)){
		$sql = "INSERT INTO vannprover(vannproveid, anleggsid, labproveid, signatur, ansattnr, opprettet, klor, ph, dpd1, dpd3, bundet_klor, phenol, addLab) 
				VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt = mysqli_prepare($db, $sql);

		$this->ansattnr = $ansattnr;
		$this->proveid=1;
		//Placeholder variable to save the input
		$this->labid = 1;
		$addLab = 1;
		$this->anleggsid = $anleggsid;
		$this->signatur = $signatur;
		$this->klor = $klor;
		$this->ph = $ph;
		$this->dpd1 = $dpd1;
		$this->dpd3 = $dpd3;
		$this->phenol = $phenol;
		$this->bundet_klor = $bundet_klor;
		$this->opprettet = $opprettet;
		
		$stmt->bind_param("iiisisddddddi", $proveid, $anleggsid, $labid, $signatur, $ansattnr, $opprettet, $klor, $ph, $dpd1, $dpd3, $bundet_klor, $phenol, $addLab);
		if($stmt->execute()){
			return true;
		}else{
			echo var_dump($stmt);
			return false;
		}
	}else{
		?><script>alert("Error: Sjekk signatur")</script><?php
		return false;
	}

		}
	
	function saveLab($vannproveid, $ansattnr, $kimtall, $pseudomas, $koliformebakt, $pH1, $temp, $fargetall, $turbiditet){
		$db = $this->conn;
		$sql = "INSERT INTO labprover(labproveid, vannproveid, ansattnr, kimtall, 
		pa, koliform, ph, temp_v_ph, fargetall, turbiditet) 
		VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt = mysqli_prepare($db, $sql);
			$this->ansattnr = $ansattnr;
			$this->vannproveid = $vannproveid;
			$this->labproveid = 0; //Placeholder value
			$this->kimtall = $kimtall;
			$this->pseudomas = $pseudomas;
			$this->koliformebakt = $koliformebakt;
			$this->pH1 = $pH1;
			$this->temp = $temp;
			$this->fargetall = $fargetall;
			$this->turbiditet = $turbiditet;
	
			$stmt->bind_param("iiiiiiddid", $labproveid, $vannproveid, $ansattnr, $kimtall, $pseudomas, $koliformebakt, $pH1, $temp, $fargetall, $turbiditet);
			if($stmt->execute()){
				$sql2 = "UPDATE vannprover SET addLab=2 WHERE vannproveid=?";
				$result = mysqli_prepare($db, $sql2);
				$result->bind_param("i", $vannproveid);
				if($result->execute()){
					return true;
				}
			}else{
				echo var_dump($stmt);
				return false;
			}
			
			}
	
	
	public function showLab($vannproveid){
		$db = $this->conn;
		$sql = "SELECT kimtall, pa, koliform, ph, temp_v_ph, fargetall, turbiditet
		FROM labprover WHERE vannproveid=?";
		$stmt = mysqli_prepare($db, $sql);
		$stmt->bind_param("i", $vannproveid);
		$stmt->execute();
		$result = $stmt->get_result();
		$labShowArray = array();
		while($row = mysqli_fetch_assoc($result)){
			$labShowArray[] = $row;
		}
		return $labShowArray;	
		mysqli_close($db);
		$this->db = null;
	}

	//displays each row from selected table
	public function showDB($anleggsid){
		$db = $this->conn;
		$this->anleggsid = $anleggsid;
		if(empty($db)){
			$this->connect();
			$db = $this->conn;
		}
		try{
			$sql = "SELECT * FROM vannprover WHERE anleggsid=?";
			$stmt = mysqli_prepare($db, $sql);
			$stmt->bind_param("i", $anleggsid);
			$stmt->execute();
			$result = $stmt->get_result();
			$dataArray = array(); //array for radene i tabellen
			while($row = $result->fetch_assoc()){
				$dataArray[] = $row;
				json_encode($dataArray); //sender data til JSON. sjekk med echo foran
			}
		
		return $dataArray;		
		mysqli_close($db);
		$this->db = null;
	}catch(Exception $e){
		echo $e->errorMessage();
	}

	}

	//Oversikt table where we show every test
	public function showOverview($offset, $limit){
		$db = $this->conn;
		$sql = "SELECT anleggsnavn, klor, ph, dpd1, dpd3, bundet_klor, phenol, opprettet, addLab, vannproveid FROM vannprover
		INNER JOIN anlegg ON  vannprover.anleggsid = anlegg.anleggsid ORDER BY opprettet DESC ";
		$limit = "LIMIT $offset, $limit";
		$sql .= $limit;
		$stmt = mysqli_prepare($db, $sql);
		$stmt->execute();
		$result = $stmt->get_result();
		$vannproveOverview = array();
		while($row = $result->fetch_assoc()){
			$vannproveOverview[] = $row;
		}
		return $vannproveOverview;
		mysqli_close($db);
		$this->db = null;
	}

	public function clickableTableProve($max, $min){
		$db = $this->conn;
		$sql = "SELECT vannproveid, anleggsnavn, klor, ph, dpd1, dpd3, bundet_klor, phenol, opprettet, signatur, addLab FROM vannprover
		INNER JOIN anlegg ON  vannprover.anleggsid = anlegg.anleggsid ORDER BY opprettet DESC LIMIT " . $max . " OFFSET " . $min;
		$stmt = mysqli_prepare($db, $sql);
		$stmt->execute();
		$result = $stmt->get_result();
		$resultArray = array();
		while($row = $result->fetch_assoc()){
			if($row['addLab'] == 1){
				$resultArray[] = $row;
		}
		}
		return $resultArray;
		mysqli_close($db);
		$this->db = null;
	}
	//Check if labtest is added too vannprove
	public function checkIfLab($vannproveid){
		$db = $this->conn;
		$sql = "SELECT vannproveid FROM vannprover WHERE addLab=2 AND vannproveid=?";
		$stmt = mysqli_prepare($db, $sql);
		$stmt->bind_param("i", $vannproveid);
		$stmt->execute();
		$result = $stmt->get_result();
		$rowCount = mysqli_num_rows($result);
		return $rowCount;
		mysqli_close($db);
		$this->db = null;
	}


	public function lab_og_vann(){
		$db = $this->conn;
		$sqlVann = "SELECT v.anleggsid, a.anleggsnavn, v.labproveid, l.kimtall, l.pa, l.koliform, l.ph, l.temp_v_ph, l.fargetall, l.turbiditet, v.klor, v.ph AS vannPh, v.dpd1, v.dpd3, v.bundet_klor, v.phenol, v.opprettet, v.addLab 
		FROM vannprover AS v 
		INNER JOIN labprover AS l ON v.labproveid = l.labproveid 
		INNER JOIN anlegg AS a ON v.anleggsid = a.anleggsid
		ORDER BY v.opprettet DESC";
		$stmt = mysqli_prepare($db, $sqlVann);
		$stmt->execute();
		$result = $stmt->get_result();
		$proveArray = array();
		while($row = mysqli_fetch_assoc($result)){
			if($row['addLab'] == 2){
				$proveArray[] = $row;
			}
		}
		return $proveArray;
		mysqli_close($db);
		$this->db = null;
	}

	public function showSpecifiedProve($proveid){
		$db = $this->conn;
		$sql = "SELECT vannproveid, anleggsnavn, klor, ph, dpd1, dpd3, bundet_klor, phenol, opprettet, signatur 
		FROM vannprover INNER JOIN anlegg ON  vannprover.anleggsid = anlegg.anleggsid WHERE vannproveid=?";
		$stmt = mysqli_prepare($db, $sql);
		$stmt->bind_param("i", $proveid);
		$stmt->execute();
		$result = $stmt->get_result();
		echo "<table style='float: right; background: #328CC1; color: black; width: 90%; 
		border-collapse: collapse; font-size: 25px; margin-bottom: 25px; margin-right: 2vw'>";
		echo "<tr style='font-family:Ubuntu,
		sans-serif;'>";
		echo "<td>Klor</td>";
		echo "<td>Ph</td>";
		echo "<td>Dpd1</td>";
		echo "<td>Dpd3</td>";
		echo "<td>Bundet Klor</td>";
		echo "<td>Phenol</td>";
		echo "</tr>";
		while($row = mysqli_fetch_assoc($result)){
			echo "<tr>";
			echo "<td>" . $row['klor'] . "</td>";
			echo "<td>" . $row['ph'] . "</td>";
			echo "<td>" . $row['dpd1'] . "</td>";
			echo "<td>" . $row['dpd3'] . "</td>";
			echo "<td>" . $row['bundet_klor'] . "</td>";
			echo "<td>" . $row['phenol'] . "</td>";

			echo "</tr>";
		echo "</table>";

	}
}

	public function getAnlegg($vannproveid){
		$db = $this->conn;
		$sql = "SELECT anleggsnavn, vannproveid
		FROM vannprover
		INNER JOIN anlegg ON vannprover.anleggsid = anlegg.anleggsid
		WHERE vannproveid=?";
		$stmt = mysqli_prepare($db, $sql);
		$stmt->bind_param("i", $vannproveid);
		$stmt->execute();
		$result = $stmt->get_result();
		while($row=mysqli_fetch_assoc($result)){
			echo "<h3 style='color: #328CC1;'>" . utf8_encode($row['anleggsnavn']) . "</h3>";
		}
	}

	public function totalVannprover(){
		$sql = "SELECT COUNT(*) FROM vannprover";
		$result = mysqli_prepare($this->conn, $sql);
		$result->execute();
		$r = mysqli_fetch_row($result->get_result());
		$numRows = $r[0];
		return $numRows;		
	}

	public function getOpprettet($vannproveid){
		$db = $this->conn;
		$sql = "SELECT opprettet, vannproveid
		FROM vannprover
		WHERE vannproveid=?";
		$stmt = mysqli_prepare($db, $sql);
		$stmt->bind_param("i", $vannproveid);
		$stmt->execute();
		$result = $stmt->get_result();
		while($row=mysqli_fetch_assoc($result)){
			echo "<h3 style='color: #328CC1;'>" . utf8_encode($row['opprettet']) . "</h3>";
		}
	}

	public function deleteTest($vannproveid){
		$db = $this->conn;
		$sql = "DELETE FROM vannprover WHERE vannproveid=?";
		$stmt = mysqli_prepare($db, $sql);
		$stmt->bind_param("i", $vannproveid);
		if($stmt->execute()){
			header("Location: oversikt.php?test=deleted");
		}else{
			echo var_dump($stmt);
		}
	}

	public function deleteAllLab($db){
		$sql = "DELETE FROM labprover;";
		$stmt = mysqli_query($db, $sql);
		if(!$stmt){
			die("Klarte ikke p slette labprøver " . mysqli_error());
		}else{
			echo "";
		}
	}

	public function deleteAllVann($db){
		$sql = "DELETE FROM vannprover;";
		$stmt = mysqli_query($db, $sql);
		if(!$stmt){
			die("Klarte ikke p slette vannprøver " . mysqli_error());
		}else{
			echo "";
		}
}

}


?>