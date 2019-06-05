<?php
include_once "includes/header.php";
include_once "objects/user.php";

$page_title = "Rediger Database";
$database = new Database();
$user = new User($db);
$prove = new ProveObject($db);
$db = $database->connect();
?>
<body>
<h1><?php echo $page_title; ?> </h1>
<?php
    if($_SESSION['login'] == true){
        echo "";
    }else{
    header("Location: login.php?login=false");
    }
    //logout
    if(isset($_POST['logoutBtn'])){
		$user->logout();
    }
    if(isset($_POST['deleteVANN'])){
        $prove->deleteAllVann($db);
    }
    if(isset($_POST['deleteLAB'])){
        $prove->deleteAllLab($db);
    }
?>
<form method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>">
    <input type="submit" value="Slett Vannprøver" style="font-size: 20px; 
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
    margin: 0 auto;
    width: 30%;" name="deleteVANN" onclick="showConfirmDeleteDB()">
    <input type="submit" value="Slett Labprøver" style="font-size: 20px; 
    align-text: center; 
    background: #A31C1C;
    font-family: 'Ubuntu';
    display: block;
    font-weight: bold;
    border-radius: 10px;
    color: #0b0e07;
    cursor:pointer;
    border:1px solid #0b0e07;
    margin-top: 10px;
    margin: 0 auto;
    padding: 15px;  
    width: 30%;" name="deleteLAB" onclick="showConfirmDeleteDB()">
</form>
</body>
</html>
