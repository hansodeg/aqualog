<?php
session_start();

include_once 'config/database.php';
include_once 'objects/proveObject.php';
include_once 'objects/user.php';

$database = new Database();
$db = $database->connect();
$allTables = new User($db);
$username = $_SESSION['navn'];

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
    <script type="text/javascript" src="../table.js"></script>
	<title></title>
	<div id="main">
	<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a href="aquacontrol.php">AquaControl</a>
	<a href="oversikt.php">Oversikt</a>
  <a href="lab_vann_oversikt.php">Lab og Vann</a>
  <a href="barneanlegget.php">Barneanlegget</a>
  <a href="nedrenedre.php">Nedre nedre</a>
  <a href="nedreovre.php">Nedre Øvre</a>
  <a href="ovre.php">Øvre</a>
  <a href="flowrider.php">Flowrider</a>
  <a href="boverstranda.php">Bøverstranda</a>
  <a href ="workflow.php">Arbeidsflyt</a>
  <a href ="#">Timeliste</a>
  <a href="https://www.yr.no/sted/Norge/Telemark/B%C3%B8/B%C3%B8/" target="_blank"> Været</a>
   <a href="https://lovdata.no/dokument/SF/forskrift/1996-06-13-592" target="_blank">Lovverk</a>
   <a href="https://lyn.met.no/" target="_blank">Tordenvarsel</a>

  <form class="prove_form" method="post" action="" >
  <h3> <?php $allTables->showUsername($username); ?> </h3>
    <button type="submit" name="logoutBtn" >Logg ut</button>
	</form>
</div>
  <span style="font-size:50px;cursor:pointer" onclick="openNav()">&#9776</span>
	<script src="script/menu.js"></script> 
	<script type="text/javascript" src="table.js"></script>
</head>