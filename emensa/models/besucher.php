<?php

function dbcountvisitorbydate($date)
{
    $link = connectdb();
    // Anzahl der Besucher für das aktuelle Datum zählen
    $sql = "SELECT count(*) as count FROM besucher Where DatumBesuch = '$date'";
    $result = mysqli_query($link, $sql);

    // Überprüfen, ob die Abfrage erfolgreich war
    if (!$result) {
        echo "Fehler während der Abfrage:  ", mysqli_error($link);
        exit();
    }

    // Ergebnis abrufen und die Anzahl der Besucher für das aktuelle Datum speichern
    $row = $result->fetch_assoc();
    $visitorCount = $row['count'];

    // Ergebnis freigeben
    mysqli_free_result($result);

    // MySQL-Verbindung schließen
    mysqli_close($link);
    return $visitorCount;
}