<?php
include_once "includes/header.php";

//filepath to excel logg file
$anleggCsv = 'excel/ovre.csv';
$page_title = 'Øvre Renseanlegg';
$table_name = 'vannprover';
$anleggsid = 4;
$database = new Database();
$db = $database->connect();

$ovreObject = new proveObject($db);
$table = $ovreObject->showDB($anleggsid);

$userHandle = new User($db);
$username = $_SESSION['navn'];
?>
 
    <h1><?php echo $page_title; ?></h1>
</head>
<body>
<?php
  $username = $_SESSION['navn'];
  if($_SESSION['login'] == true){
    echo "";
  }else
  {
  header("Location: login.php?login=false");
  }
	if(isset($_POST['prove'])){
		$ansattnr = $_SESSION['ansattnr'];
		$opprettet = date('Y-m-d H:i:s');
		$signatur = htmlspecialchars(strip_tags($_POST['signatur']));
		$klor = htmlspecialchars(strip_tags($_POST['klor']));
		$ph = htmlspecialchars(strip_tags($_POST['ph']));
		$dpd1 = htmlspecialchars(strip_tags($_POST['dpd1']));
		$dpd3 = htmlspecialchars(strip_tags($_POST['dpd3']));
		$phenol = htmlspecialchars(strip_tags($_POST['phenol']));
		$bundet_klor = $dpd1 - $dpd3;

		if($ovreObject->saveData($ansattnr, $anleggsid, $opprettet, $signatur, $klor, $ph, $dpd1, $dpd3, $bundet_klor, $phenol)){
			echo "";
		}	
  }
  if(isset($_POST['delete_table'])){
		$flowriderobj->deleteTable($table_name, $_SESSION['admin']);
	}
	//Run method when button is pressed
	if(isset($_POST['csvExport'])){
		$database->exportExcelVann($anleggsid);
	}
	if(isset($_POST['csvExportLab'])){
		$database->exportExcelLab($anleggsid);
	}
	//Post to userobject for logout
	if(isset($_POST['logoutBtn'])){
		$userHandle->logout();

	}
	//Takes 1 variable from input field and post this field to the object
	if(isset($_POST['deleteRow'])){
		$rowId = $_POST['chooseTestId'];
		$flowriderobj->deleteRow($rowId);
	}

	$sql = "SELECT klor, ph, dpd1, dpd3, bundet_klor, phenol, opprettet FROM vannprover 
	WHERE anleggsid = 4 ORDER BY opprettet  DESC LIMIT 14" ;
	$result = mysqli_query($db, $sql);
	
	$klor = ' ';
	$ph = ' ';
	$dpd1 = ' ';
	$dpd3 = ' ';
	$bundet_klor = ' ';
	$phenol = ' '; 

	while ($row = $result -> fetch_assoc()) {
	//	var_dump($row);

		$klor = $klor . '"'. $row['klor'].'",';
		$ph = $ph . '"'. $row['ph'] .'",';
		$dpd1 = $dpd1 . '"'. $row['dpd1'].'",';
		$dpd3 = $dpd3 . '"'. $row['dpd3'] .'",';
		$bundet_klor = $bundet_klor . '"'. $row['bundet_klor'].'",';
		$phenol = $phenol . '"'. $row['phenol'] .'",';
//	$opprettet = $opprettet . '"'. $row['opprettet'].'",';
	
	}

	$klor = trim($klor,",");
	$ph = trim($ph,",");
	$dpd1 = trim($dpd1,",");
	$dpd3 = trim($dpd3,",");
	$bundet_klor = trim($bundet_klor,",");
	$phenol = trim($phenol,",");
//  $opprettet = trim($opprettet,",");


	?>
	<!-- henter meny fra layout fil   -->
	<?php include "layout/loggerlayout.php"; ?>
		<?php
	if($_SESSION['admin'] == 1 || $_SESSION['admin'] == 2){
		?>
		<!--legger in graf hentes fra layout biblioteket i mappestrukturen -->
		<?php include "layout/graph.php";?>
</div>
</div> 
<?php } ?>

</table>
<?php
	//When button is pressed, the table will be deleted
	if(isset($_POST['delete_table'])){
		$ovreObject->deleteTable($table_name, $_SESSION['admin']);
	}
	//Run method when button is pressed
	if(isset($_POST['csvExport'])){
		$database->exportDatabaseExcel($table_name);
	}
	//Post to userobject for logout
	if(isset($_POST['logoutBtn'])){
		$userHandle->logout();

	}
	//Takes 1 variable from input field and post this field to the object
	if(isset($_POST['deleteRow'])){
		$rowId = $_POST['chooseTestId'];
		$ovreObject->deleteRow($rowId);
	}
?>
<!--legger til knapper for å overføre sql data (vann/labb), hentes fra layoutfil i mappestrukturen -->
	<?php include "layout/spreadsheet.php"; ?>
	</div>
	<!--legger til footer - hentes fra layoutfil i mappe strukturen -->
