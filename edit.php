<?php
include_once "includes/header.php";
include_once "objects/user.php";

$page_title = "Rediger Ansatt";

$user = new User($db);
$ansattnr = intval($_GET['ansattnr']);
?>
<body>
<h1><?php echo $page_title; ?> </h1>
<?php
    if($_SESSION['login'] == true){
        echo "";
    }else{
    header("Location: login.php?login=false");
    }
    //Send data for changing password
    if(isset($_POST['changePwd'])){
        $pwd1 = htmlentities($_POST['pwd1']);
        $pwd2 = htmlentities($_POST['pwd2']);
        if($user->changePwAdmin($ansattnr, $pwd1, $pwd2)){
            echo "<h3>Passord er endret</h3>";
        }else{
            echo "<h3 style='text-align: center;'>Passordet må inneholde minimum 1 stor bokstav, et siffer, <br>og en lengde på 8 tegn</h3>";
        }
    }
    //logout
    if(isset($_POST['logoutBtn'])){
		$user->logout();

    }
    //delete user
    if(isset($_POST['deleteUserBtn'])){
        $user->setAnsattnrAsNullVann($ansattnr);
        $user->setAnsattnrAsNullLab($ansattnr);
        $user->deleteUser($ansattnr);
    }
?>
<div id="editPwdChange">
<form name="pwdChange" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
    <input type="password" name="pwd1" placeholder="Endre Password" style="
    height: 25px;
    margin-top: 25px;
    margin-left: 35vw;
    ">
    <input type="password" name="pwd2" placeholder="Gjenta Password" style="
    height: 25px;
    ">
    <input type="submit" name="changePwd" value="Endre" style="
    border-radius: 5px;
    background:#D9B310;
    color:#1D2731;
    cursor: pointer;
    font-family: Ubuntu, sans-serif;
    font-weight: bold;
    height: 35px;
    border: none;
    text-transform: uppercase;
    ">
</form>
</div>
<div id="deleteUser">
    <form method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <input type="submit" value="Slett Ansatt" name="deleteUserBtn">
    </form>
</div>
</body>
</html>