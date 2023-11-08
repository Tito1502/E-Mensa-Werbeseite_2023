<?php
include('m2_5a_standardparameter.php');

// Verwendung der Funktion addieren
$result1 = add(5, 3);
$result2 = add(10);

// Ausgabe der Ergebnisse
echo "Das Ergebnis von 5 + 3 ist: $result1<br>";
echo "Das Ergebnis von 10 + 0 (Standardwert) ist: $result2";
?>