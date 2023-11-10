<?php
/**
 * Praktikum DBWT. Autoren:
 * Bol, Daudov, 3539110
 * Vorname2, Nachname2, Matrikelnummer2
 *  Vorname2, Nachname2, Matrikelnummer2
 */

// Pfad zur Log-Datei
$logs= fopen('accesslog.txt', 'a');

$txt = date("d.m.Y h:i") . " | " . $_SERVER['HTTP_USER_AGENT'] . " | " . $_SERVER['REMOTE_ADDR']."\n";

fwrite($logs, $txt);
fclose($logs);

// Bestätigungsnachricht
echo "Eintrag erfolgreich hinzugefügt.";
?>