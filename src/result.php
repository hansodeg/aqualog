<?php
require_once 'db_config.php';

$sql = "SELECT bøverstrand_anlegg, klor, ph FROM bøverstranda";
$result = $conn->query($sql);

if($result->num_rows > 0){
	echo "<table name='aquatable'><tr><th>Anlegg</th><th>Klor</th><th>PH</th></tr>";
	while($row = $result->fetch_assoc()){
		echo"<tr><td>" . $row["bøverstrand_anlegg"] . "</td><td> " . $row["klor"] . "</td><td> " . $row["ph"] . "</td></tr>";
	 }
	 echo "</table>";
	}else{
		echo "0 results";
	}

$conn->close();

?>

