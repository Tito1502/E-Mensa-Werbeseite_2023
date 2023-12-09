<?php

function dbgetnlsubcount()
{
    $link =connectdb();
    // Funktion zum Abrufen der Anzahl der gespeicherten Newsletter-Anmeldungen
    $sql = "SELECT count(*) as count FROM newsletter_anmeldung";

    // Query ausführen
    $result = mysqli_query($link, $sql);

    // Überprüfen, ob die Abfrage erfolgreich war
    if (!$result) {
        echo "Fehler während der Abfrage:  ", mysqli_error($link);
        exit();
    }

    // Ergebnis abrufen und die Anzahl der Gerichte speichern
    $row = $result->fetch_assoc();
    $newsletterCount = $row['count'];

    // Ergebnis freigeben
    mysqli_free_result($result);
    return $newsletterCount;
}

