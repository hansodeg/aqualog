<?php
class Database{
	private $host = 'localhost';
	private $db_name = 'aquacontrol';
	private $username = 'root';
	private $password = '';
	public $conn;

	public function connect(){
		$this->conn = null;
		try{
			$this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
		}catch(Exception $e){
			$error = $e->getMessage();
			echo $error;
		}
		return $this->conn;
	}
	
	public function exportDatabaseExcel($anleggsid){
		$this->anleggsid = $anleggsid;
		$date = ('m/d/Y');
		/*$delimeter = ';';*/
		date_default_timezone_set("EST5EDT");
		header("Content-type: text/x-csv");
		header("Content-Disposition: attachment; filename=data.csv");
		$output = fopen("php://output", "w");
		ob_end_clean();
		fputcsv($output, array('ID', 'Signatur', 'Klor', 'Ph', 'Dpd1', 'Dpd3', 'BundetKlor', 'Phenol', 'Opprettet'));
		$query = "SELECT vannproveid, signatur, klor, ph, dpd1, dpd3, bundet_klor, phenol, opprettet FROM vannprover WHERE anleggsid=". $anleggsid ;
		$result = mysqli_query($this->conn, $query);
		
		while($row = mysqli_fetch_assoc($result)){
			fputcsv($output, $row);
		}
		fclose($output);
		exit();
			
	}
	public function exportExcelVann($anleggsid){
		$this->anleggsid = $anleggsid;
		$delimiter = ';';
		$enclosure = '"';
		header("Content-type: text/x-csv");
		header("Content-Disposition: attachment; filename=" . $this->displayAnleggCsv($this->anleggsid));
		$output = fopen("php://output", "w");
		ob_end_clean();
		fputcsv($output, array('ID;Signatur;Klor;Ph;Dpd1;Dpd3;BundetKlor;Phenol;Opprettet'));
		$query = "SELECT vannproveid, signatur, klor, ph, dpd1, dpd3, bundet_klor, phenol, opprettet FROM vannprover WHERE anleggsid=?";
		$stmt = mysqli_prepare($this->conn, $query);
		$stmt->bind_param("i", $anleggsid);
		$stmt->execute();
		$result = $stmt->get_result();
		while($row = $result->fetch_assoc()){
			fputcsv($output, $row, $delimiter, $enclosure);
		}
		fclose($output);
		exit();
			
	}

	public function exportExcelAllVann(){
		$delimiter = ';';
		$enclosure = '"';
		header("Content-type: text/x-csv");
		header("Content-Disposition: attachment; filename=oversiktVann.csv");
		$output = fopen("php://output", "w");
		ob_end_clean();
		fputcsv($output, array('ProveID;Anlegg;Signatur;Klor;Ph;Dpd1;Dpd3;BundetKlor;Phenol;Opprettet'));
		$query = "SELECT vannproveid, anlegg.anleggsnavn, signatur, klor, ph, dpd1, dpd3, bundet_klor, phenol, opprettet 
		FROM vannprover
		INNER JOIN anlegg ON  vannprover.anleggsid = anlegg.anleggsid";
		$stmt = mysqli_prepare($this->conn, $query);
		$stmt->execute();
		$result = $stmt->get_result();
		while($row = $result->fetch_assoc()){
			fputcsv($output, $row, $delimiter, $enclosure);
		}
		fclose($output);
		exit();
			
	}

	public function exportExcelAllLab(){
		$db = $this->conn;
		$delimiter = ';';
		$enclosure = '"';
		header("Content-type: text/x-csv");
		header("Content-Disposition: attachment; filename=oversiktLab.csv");
		$output = fopen("php://output", "w");
		ob_end_clean();
		fputcsv($output, array('Kimtall;PA;Koliforme;PH;Temp_v_PH;Fargetall;Turbiditet;Opprettet'));
		$query = "SELECT l.kimtall, l.pa, l.koliform, l.ph, l.temp_v_ph, l.fargetall, l.turbiditet, opprettet FROM vannprover AS v
		INNER JOIN labprover AS l ON v.labproveid = l.labproveid";
		$stmt = mysqli_prepare($db, $query);
		$stmt->execute();
		$result = $stmt->get_result();
		while($row = $result->fetch_assoc()){
			fputcsv($output, $row, $delimiter, $enclosure);
		}
		fclose($output);
		exit();
			
	}

	public function exportExcelLab($anleggsid){
		$this->anleggsid = $anleggsid;
		$delimiter = ';';
		$enclosure = '"';
		header("Content-type: text/x-csv");
		header("Content-Disposition: attachment; filename=" . $this->displayAnleggCsv($this->anleggsid));
		$output = fopen("php://output", "w");
		ob_end_clean();
		fputcsv($output, array('Kimtall;PA;Koliforme;PH;Temp_v_PH;Fargetall;Turbiditet;Opprettet'));
		$query = "SELECT l.kimtall, l.pa, l.koliform, l.ph, l.temp_v_ph, l.fargetall, l.turbiditet, opprettet FROM vannprover AS v
		INNER JOIN labprover AS l ON v.labproveid = l.labproveid
		WHERE v.anleggsid=?;";
		$stmt = mysqli_prepare($this->conn, $query);
		$stmt->bind_param("i", $anleggsid);
		$stmt->execute();
		$result = $stmt->get_result();
		while($row = $result->fetch_assoc()){
			fputcsv($output, $row, $delimiter, $enclosure);
		}
		fclose($output);
		exit();
			
	}
	private function displayAnleggCsv($anleggsid){
		if($anleggsid == 0){
			return $anleggsFil = "flowriderExcel.csv";
		}
		elseif($anleggsid == 1){
			return $anleggsFil = "barneanleggetExcel.csv";
		}
		elseif($anleggsid == 2){
			return $anleggsFil = "nedrenedreExcel.csv";
		}
		elseif($anleggsid == 3){
			return $anleggsFil = "nedreovreExcel.csv";
		}
		elseif($anleggsid == 4){
			return $anleggsFil = "ovreExcel.csv";
		}
		elseif($anleggsid == 5){
			return $anleggsFil = "boverstrandaExcel.csv";
		}
	}

	
}
?>