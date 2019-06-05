<?php
include_once "includes/header.php";
$proveUser = new User($db);
$max = 16;
$min = 0;
$page_title = "Vann- og Labprøve";
$vann_og_lab_prover = new proveObject($db);
$vannproveid = $_GET['vannproveid'];

if(isset($_POST['deleteProve'])){
    $vann_og_lab_prover->deleteTest($vannproveid);           
}

//Post to userobject for logout
if(isset($_POST['logoutBtn'])){
    $proveUser->logout();

}
?>
<body>
<h1><?php echo $page_title; ?></h1>
<div style="display: inline-block; margin-left: 20px; font-size: 16px; font-family:'Ubuntu',
  sans-serif;">
  <div class="logger">
<?php
echo "<h3 style='color: #328CC1;'>Anlegg: </h3>";
echo "<h3>" . $vann_og_lab_prover->getAnlegg($vannproveid) . "</h3>";
echo "<h3 style='color: #328CC1;'>Opprettet: </h3>";
echo "<h3>" . $vann_og_lab_prover->getOpprettet($vannproveid) . "</h3>";
?>
<?php
if($_SESSION['admin'] == 1 || $_SESSION['admin'] == 2){ ?>
    <form method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>">
    <input type="submit" name="deleteProve" style="font-size: 20px; 
    align-text: center; 
    background: #A31C1C;
    font-family: 'Ubuntu';
    display: block;
    font-weight: bold;
    border-radius: 10px;
    color: #0b0e07;
    cursor:pointer;
    border:1px solid #0b0e07;
    padding: 15px;  
    margin: 10px;
    width: 60%;" onclick="return alertDelete()" value="Slett">
</form>
<?php } ?>
</div>
<?php 
if($vann_og_lab_prover->checkIfLab($vannproveid)==0){
?>
<!--<div class="logger">                         
    <form class="prove_form" method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <h2>Legg inn labprøve</h2>                                                 
        <input type="number" name="kimtall" class="form-control" placeholder="Kimtall" required></td>
        <input type="number" name="pseoudomas" class="form-control" placeholder="Pseudomonas Aer" required></td>                                                                                     
        <input type="number" name="koliformebakt"class="form-control" placeholder="Koliforme bakterier" required></td>                                                                               
        <input type="number" name="pH1" class="form-control" step="0.01" placeholder="pH" required></td>                                                                               			
        <input type="number" name="temp" class="form-control" step="0.01" placeholder="temp v/ pH-måling" required></td>                                                                                                                                                                            			
        <input type="number" name="fargetall" step="0.01" class="form-control" placeholder="Fargetall" required></td>
        <input type="number" name="turbiditet" class="form-control" step="0.01" placeholder="Turbiditet" required></td>   
    <button type="submit" name="labLagre">Lagre</button>
</form>        
</div>-->
<?php
}
?>
<div class="present">
    <form class="prove_form" method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>">
<?php
echo "<h3 style='float: center; color: #D9B310'</h3>" . $vann_og_lab_prover->showSpecifiedProve($vannproveid);

	if(isset($_POST['labLagre'])){
		$ansattnr = $_SESSION['ansattnr'];
		$kimtall = htmlspecialchars(strip_tags($_POST['kimtall']));
		$pseudomas = htmlspecialchars(strip_tags($_POST['pseoudomas']));
		$koliformebakt = htmlspecialchars(strip_tags($_POST['koliformebakt']));
		$pH1 = htmlspecialchars(strip_tags($_POST['pH1']));
		$temp = htmlspecialchars(strip_tags($_POST['temp']));
		$fargetall = htmlspecialchars(strip_tags($_POST['fargetall']));
		$turbiditet = htmlspecialchars(strip_tags($_POST['turbiditet']));
		//$signatur = htmlspecialchars(strip_tags($_POST['signatur']));
        $vann_og_lab_prover->saveLab($vannproveid, $ansattnr, $kimtall, $pseudomas, $koliformebakt, $pH1, $temp, $fargetall, $turbiditet);
    }?>
 
    <?php
    if($vann_og_lab_prover->checkIfLab($vannproveid)==1){
        $table = $vann_og_lab_prover->showLab($vannproveid);
    ?>

    <table style='float: right; background: #328CC1; color: black; width: 90%; 
	border-collapse: collapse; font-size: 25px; margin-bottom: 25px; margin-right: 2vw'>
        <tr>
        <td>Kimtall</td>
        <td>Pa</td>
        <td>Koliform</td>
        <td>pH</td>
        <td>Temp v/ph</td>
        <td>Fargetall</td>
        <td>Turbiditet</td>
        </tr>        
        <?php
        if(!empty($table)){
            foreach($table as $row){
                echo '<tr>';
                echo '<td>' . $row['kimtall'] . '</td>';
                echo '<td>' . $row['pa'] . '</td>';
                echo '<td>' . $row['koliform'] . '</td>';
                echo '<td>' . $row['ph'] . '</td>';
                echo '<td>' . $row['temp_v_ph'] . '</td>';
                echo '<td>' . $row['fargetall'] . '</td>';
                echo '<td>' . $row['turbiditet'] . '</td>';
                echo '</tr>';
            }
        }
        ?>
        </table>
        <?php 
        {
            ?>
        </form>
        <?php }
     }?>
    

<?php 
if($vann_og_lab_prover->checkIfLab($vannproveid)==0){
?>
<div class="logger">                         
    <form class="prove_form" method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <h2>Legg inn labprøve</h2>                                                 
        <input type="number" name="kimtall" class="form-control" placeholder="Kimtall" required>
        <input type="number" name="pseoudomas" class="form-control" placeholder="Pseudomonas Aer" required>                                                                                   
        <input type="number" name="koliformebakt"class="form-control" placeholder="Koliforme bakterier" required>                                                                               
        <input type="number" name="pH1" class="form-control" step="0.01" placeholder="pH" required>                                                                              			
        <input type="number" name="temp" class="form-control" step="0.01" placeholder="temp v/ pH-måling" required>                                                                                                                                                                            			
        <input type="number" name="fargetall" step="0.01" class="form-control" placeholder="Fargetall" required>
        <input type="number" name="turbiditet" class="form-control" step="0.01" placeholder="Turbiditet" required>  
    <button type="submit" name="labLagre">Lagre</button>
</form>        
</div>
<?php
}
?>



