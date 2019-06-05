<?php
include_once "includes/header.php";

$proveUser = new User($db);
$max = 660;
$min = 0;
$page_title = "Vannprøver";
$vannprover = new proveObject($db);

$table = $vannprover->clickableTableProve($max, $min);
?>
<h1><?php echo $page_title; ?></h1>
<body>
    <table style='background: #328CC1; color: black; width: 80%; 
		margin: 0 auto; border-collapse: collapse; font-size: 25px; cursor: pointer;'>
        <tr>
            <td>Prøve ID</td>
            <td>Anlegg</td>
            <td>Opprettet</td>
<?php
        if(!empty($table)){
            foreach($table as $row){
                echo '<tr style="text-align: center;" name="table_row" onclick="window.location=\'addlab.php?vannproveid=' . $row['vannproveid'] . '\'">';
                echo '<td style="padding: 5px;">' . $row['vannproveid'] . '</td>';
                echo '<td>' . utf8_encode($row['anleggsnavn']) . '</td>';
                echo '<td>' . $row['opprettet'] . '</td>';
                //echo '<td>' . $row['labproveid'] . '</td>';

                echo '</tr>';
            }
        }
    ?>
    </table>
