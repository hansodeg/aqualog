
<div class="logger">
	<?php
	//Session global variables to determin access to delete and create functions
	if($_SESSION['admin'] == 1){
	echo "<form method=post action=" . htmlspecialchars($_SERVER['PHP_SELF']) . ">";
	echo "<input type='submit' name='csvExport' value='Excel Vann' style='display: block; 
	padding: 5px; margin: 10px; cursor: pointer; background: #008000; 
	border: none; color: white; border-radius: 2px; font-weight: bold'>";
	echo "<input type='submit' name='csvExportLab' value='Excel Lab' style='display: block; 
	padding: 5px; margin: 10px; cursor: pointer; background: #008000; border: none; color: white; 
	border-radius: 2px; font-weight: bold'>";
	echo "</form>";
	echo "<form method=post action=" . htmlspecialchars($_SERVER['PHP_SELF']) . ">";
	echo "<input type='number' placeholder='Skriv prove id' name='chooseTestId'>";
	echo "<input type='submit' name='deleteRow' value='Slett rad'>";
	echo "</form>";
	;}
		if($_SESSION['admin'] == 2){
			echo "<form method=post action=" . htmlspecialchars($_SERVER['PHP_SELF']) . ">";
			echo "<input type='submit' name='csvExport' value='Excel Vannprøve'style='display: block; padding: 15px; width: 60%; margin: 10px; cursor: pointer; background: #F5DEB3; border: 0; color: #1D2731; border-radius: 10px; font-weight: bold; font-size:20px'>";
			echo "<input type='submit' name='csvExportLab' value='Excel Labprøve' style='display: block; padding: 15px; width: 60%; margin: 10px; cursor: pointer; background: #F5DEB3; border: 0; color: #1D2731; border-radius: 10px; font-weight: bold; font-size:20px'>";
			echo "</form>";
		}
	?>
	</div>