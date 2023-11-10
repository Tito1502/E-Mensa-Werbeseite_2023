<!--
- Praktikum E-Mensa Werbeseite. Autoren:
- Jeremy, Mainka, 3567706
- Philip, Engels, 3569528
- Bol, Daudov, 3539110
-->
<?php


// Pfad zur Log-Datei
$logs= fopen('accesslog.txt', 'a');

$txt = date("d.m.Y h:i") . " | " . $_SERVER['HTTP_USER_AGENT'] . " | " . $_SERVER['REMOTE_ADDR']."\n";

fwrite($logs, $txt);
fclose($logs);

// Bestätigungsnachricht
echo "Eintrag erfolgreich hinzugefügt.";
?>