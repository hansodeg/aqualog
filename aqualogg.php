<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name=viewport content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href='https://fonts.googleapis.com/css?family=Major+Mono+Display' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
    <title>Aqualogg - hovedside</title>
    <h1>AquaLogg</h1>
</head>

<body>
    <div class="buttongroup">
    <!-- skilt "geografisk" anleggene øverst er samlet innenfor relativt liten radius mens anleggene nederst er lissom litt oppi der-->
    <button onClick="location.href='barneanlegget.php'" type="button">Barneanlegget</button>
    <button onClick="location.href='nedrenedre.php'" type="button">Nedre Nedre</button>
    <button onClick="location.href='nedreovre.php'" type="button">Nedre Øvre</button>
    <button onClick="location.href='ovre.php'" type="button">Øvre</button>
    </div>

    <div class="buttongroup">
    <button onClick="location.href='boverstranda.php'" type="button">Bøverstranda</button>
    <button onClick="location.href='flowrider.php'" type="button">FlowRider</button>
   
    </div>
    


