<?php include_once "includes/header.php";?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Arbeidsflyt</title>
    <link rel="stylesheet" href="css/wf.css">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
</head>
<body>
	<div id="board" class="board">
        <div class="header">
            <h1>Arbeidsflyt</h1>
            <button class="create-column">+</button>
        </div>
        <div class="column-container"></div>
	</div>
    <script src="https://code.jquery.com/jquery-3.0.0.min.js" integrity="sha256-JmvOoLtYsmqlsWxa7mDSLMwa6dZ9rrIdtrrVYRnDRH0=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"   integrity="sha256-xNjb53/rY+WmG+4L6tTl9m6PpqknWZvRt0rO1SRnJzw="   crossorigin="anonymous"></script>
    <script type="text/javascript" src="script/workflow.js"></script>
