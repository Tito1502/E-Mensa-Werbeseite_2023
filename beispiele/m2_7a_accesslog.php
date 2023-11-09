<?php
// Pfad zur Log-Datei


$fp = fopen('accesslog.txt', 'a');

$txt = date("d.m.Y h:i") . " | " . $_SERVER['HTTP_USER_AGENT'] . " | " . $_SERVER['REMOTE_ADDR'];

fwrite($fp, $txt);
fclose($fp);

// Bestätigungsnachricht
echo "Eintrag erfolgreich hinzugefügt.";
?>