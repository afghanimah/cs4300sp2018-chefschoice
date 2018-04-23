<?php
$mood = htmlspecialchars($_GET["q"]);
$command = escapeshellcmd("python3 scripts/parser.py '" . $mood . "'");
$output = shell_exec($command);
echo($output);
?>