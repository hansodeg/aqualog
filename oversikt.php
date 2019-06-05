<?php
session_start();
include_once 'config/database.php';
include_once 'objects/proveObject.php';
include_once 'objects/user.php';

$table_name = 'vannprover';
$database = new Database();
$db = $database->connect();
$oversiktobj = new ProveObject($db);

$userHandle = new User($db);
$username = $_SESSION['navn'];
//Number of rows inn vannprover
$numberofrows = $oversiktobj->totalVannprover();

//How many rows we want to display in table
$rowsprpage = 12;
//Get total pages 
$totalpages = ceil($numberofrows/$rowsprpage);

if(isset($_GET['page']) && is_numeric($_GET['page'])){
  //Get var as int
  $currentpage = (int) $_GET['page'];
}else{
  //Default pagenum
  $currentpage = 1;
}

//Run database.php export method when button is pressed
if(isset($_POST['csvExportAll'])){
  $database->exportExcelAllVann();
}

if(isset($_POST['csvExportAllLab'])){
  $database->exportExcelAllLab();
}

//Number of rows to skip
$offset = ($currentpage - 1) * $rowsprpage;

$table = $oversiktobj->showOverview($offset, $rowsprpage);

//How many links to show
$numOfLinks = 30;


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name=viewport content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="10">
    <link rel="stylesheet" type="text/css" href="css/style.css">
		<link href='https://fonts.googleapis.com/css?family=Major+Mono+Display' rel='stylesheet'>
		<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
	<title>Oversikt</title>
	<div id="main">
	<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a href="aquacontrol.php">AquaControl</a>
  <a href="oversikt.php <?php echo "?page=1";?>">Oversikt</a>
  <a href="lab_vann_oversikt.php">Lab og Vann</a>
  <a href="barneanlegget.php">Barneanlegget</a>
  <a href="nedrenedre.php">Nedre nedre</a>
  <a href="nedreovre.php">Nedre Øvre</a>
  <a href="ovre.php">Øvre</a>
  <a href="flowrider.php">Flowrider</a>
  <a href="boverstranda.php">Bøverstranda</a>
  <a href="splash.php">Splash</a>
  <a href ="workflow.php">Workflow</a>
  <a href ="#">Timeliste</a>

  <form class="prove_form" method="post" action="" >
	<h3> <?php $userHandle->showUsername($username); ?> </h3>
		<button type="submit" name="logoutBtn" >Logg ut</button>
	</form>
  
</div>

  <span style="font-size:50px;cursor:pointer" onclick="openNav()">&#9776</span>

  <script src = "script/menu.js"></script>
<h1>Oversikt</h1>

<script type="text/javascript" src="table.js"></script>
</head>
<body>
	<?php
	if($_SESSION['login'] == true){
		echo "";
	}else{
		header("Location: login.php?login=false");
	}

	//Post to userobject for logout
	if(isset($_POST['logoutBtn'])){
		$userHandle->logout();

    }
    
 ?>
 <div class="presentTest">
 <table style='background: #328CC1; color: black; width: 90%;
		margin: 0 auto; border-collapse: collapse; font-size: 20px; cursor: pointer;' id="overviewTable">

    <?php
    echo '<tbody><tr>
    <td>Anlegg</td>
    <td>Klor</td>
    <td>PH</td>
    <td>Dpd1</td>
    <td>Dpd3</td>
    <td>D3-D1</td>
    <td>Phenol</td>
    <td>Opprettet</td>
    <td>LabPrøve</td>
    </tr>';
    ?>
  
        <?php
        if(!empty($table)){
          foreach($table as $row){
              echo '<tr onclick="window.location=\'addlab.php?vannproveid=' . $row['vannproveid'] . '\'">';
              echo '<td>' . utf8_encode($row['anleggsnavn']) . '</td>';
              echo '<td>' . $row['klor'] . '</td>';
              //Check values for ph
              if($row['ph']>7.2 and $row['ph']<7.99){
                echo '<td>' . $row['ph'] . '</td>';
              }else{
                echo '<td style="background-color: #A31C1C;">' . $row['ph'] . '</td>';
              }
              if($row['dpd1']>0 and $row['dpd1']<10){
                echo '<td>' . $row['dpd1'] . '</td>';
              }else{
                echo '<td style="background-color: #A31C1C;">' . $row['dpd1'] . '</td>';
              }
              echo '<td>' . $row['dpd3'] . '</td>';
              echo '<td>' . $row['bundet_klor'] . '</td>';
              //Check values for phenol
              if($row['phenol']>0 and $row['phenol']<10){
                echo '<td>' . $row['phenol'] . '</td>';
              }else{
                echo '<td style="background:red">' . $row['phenol'] . '</td>';
              }
              echo '<td>' . $row['opprettet'] . '</td>';
              if($row['addLab'] == 2){
                echo '<td style="background: green"></td>';
              }else{
                echo '<td style="background-color: #D9B310;"></td></tr>';
              }
              echo '</tbody>';
          }
      }

  ?>
  </table>
    </div>
 
  <div id="paginator" style="margin-left: 45vw">
  <?php
  for($i = ($currentpage-$numOfLinks); $i<(($currentpage + $numOfLinks) + 1); $i++){
    if(($i>0) && ($i<=$totalpages)){
      //Current page
      if($i == $currentpage){
        //bold text without link
        echo "<p style='font-size: 25px; text-decoration: none; display: inline-block;'>[<b>$i</b>]</p>";
      }
      //If not current page
      else{
        echo "<a href='{$_SERVER['PHP_SELF']}?page=$i' style='font-size: 25px; text-decoration: none; color: black;'>$i</a>";
      }
    }
  }
  ?>
  </div>
  </div>
<div class="logger">
  <?php

  //Session global variables to determin access to delete and create functions
  if($_SESSION['admin'] == 1 || $_SESSION['admin'] == 2){
    echo "<form method=post action=" . htmlspecialchars($_SERVER['PHP_SELF']) . ">";
    echo "<input type='submit' name='csvExportAll' value='Excel Vann' style='display: block;
    background: #F5DEB3; border: none; color: #1D2731; border-radius: 10px; font-weight: bold; 
    padding: 15px; margin-top: 10px;  width: 60%;  cursor: pointer; font-size: 20px;'>";
    echo "<input type='submit' name='csvExportAllLab' value='Excel Lab' style='display: block;
    background: #F5DEB3; border: none; color: #1D2731; border-radius: 10px; font-weight: bold; 
    padding: 15px; margin-top: 10px;  width: 60%;  cursor: pointer; font-size: 20px;'>";
    echo "</form>";}
  ?>
  </div>
