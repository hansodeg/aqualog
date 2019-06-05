<?php
include_once "includes/header.php";
include_once "objects/user.php";

$user = new User($db);
$table = $user->showAllUsers();
$page_title = "Ansatte";

?>
<h1 style="margin: 0 auto; padding: 50px;"><?php echo $page_title; ?></h1>
<body>
<?php
    if($_SESSION['login'] == true){
        echo "";
    }else{
        header("Location: login.php?login=false");
    }

    if(isset($_POST['logoutBtn'])){
        $user->logout();
    }
?>
<div class="table_show">
        <form method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>">
		<table style="background: #328CC1; color: black; width: 20%; 
		margin: 0 auto; border-collapse: collapse; font-size: 18px;'">
			<tr>
			<td>Ansattnr</td>
            <td>Navn</td>
            <td>Rolle</td>
  
			</tr>
<?php

	if(!empty($table)){
		foreach($table as $row){
			echo "<tr name='table_row'>";
			echo "<td style='padding: 10px;'>" . $row['ansattnr'] . "</td>";
            echo "<td style='padding: 10px;'>" . $row['navn'] . "</td>";
            if($row['admin'] == 0){
                echo "<td style='padding: 10px;'>Vaktleder</td>"; 
            }
            else if($row['admin'] == 1){
                echo "<td style='padding: 10px;'>Teknisk</td>"; 
            }else{
                echo "<td style='padding: 10px;'>Administrator</td>";
            }
            echo '<td><input type="button" name="edit" value="Rediger" onclick="window.location=\'edit.php?ansattnr=' . $row['ansattnr'] . '\'" style="
            border-radius: 5px;
            background:#D9B310;
            color:#1D2731;
            cursor: pointer;
            font-family: Ubuntu, sans-serif;
            font-weight: bold;
            height: 35px;
            border: none;
            text-transform: uppercase;
            "></td>';
			echo "</tr>";
		}
	}	
    ?>
    </table>
</form>
    
</body>
</html>