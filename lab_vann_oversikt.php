<?php
include_once "includes/header.php";

$proveUser = new User($db);
$page_title = "Lab og vann";
$vann_og_lab_prover = new proveObject($db);

$table = $vann_og_lab_prover->lab_og_vann();

//Post to userobject for logout
if(isset($_POST['logoutBtn'])){
    $proveUser->logout();
}
?>
<body>
<h1><?php echo $page_title; ?></h1>
<table style='background: #328CC1; color: black; width: 80%;
		margin: 0 auto; border-collapse: collapse; font-size: 25px; cursor: pointer;'>
        <colgroup>
            <col width="5%"><col width="5%">
            <col width="5%"><col width="5%">
            <col width="5%"><col width="5%">
            <col width="5%"><col width="5%">
        </colgroup>
        <?php
        if(!empty($table)){
            foreach($table as $row){
                echo '<thead><tr><th colspan=5>Vannprøve med Lab fra: ' . utf8_encode($row['anleggsnavn']) . ' - Dato: ' . $row['opprettet'] . '</th></tr></thead>';
                echo '<tbody><tr><td>Klor</td><td>Dpd1</td><td>Dpd3</td><td>Ph</td><td>Bundet Klor</td><td>Phenol</td></tr>';
                echo '<td colspan=1>' . $row['klor'] . '</td>';
                echo '<td>' . $row['vannPh'] . '</td>';
                echo '<td>' . $row['dpd1'] . '</td>';
                echo '<td>' . $row['dpd3'] . '</td>';
                echo '<td>' . $row['bundet_klor'] . '</td>';
                echo '<td>' . $row['phenol'] . '</td></tr>';
                echo '<tr><td>Kimtall</td><td>Pa</td><td>Koliform</td><td>Ph</td><td>Temp v/ph</td><td>Fargetall</td><td>Turbiditet</td></tr>';
                echo '<td>' . $row['kimtall'] . '</td>';
                echo '<td>' . $row['pa'] . '</td>';
                echo '<td>' . $row['koliform'] . '</td>';
                echo '<td>' . $row['ph'] . '</td>';
                echo '<td>' . $row['temp_v_ph'] . '</td>';
                echo '<td>' . $row['fargetall'] . '</td>';
                echo '<td>' . $row['turbiditet'] . '</td>';
                echo '</tbody>';
            }
        }
    ?>
</body>
