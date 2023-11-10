
/**
* Praktikum DBWT. Autoren:
* Bol, Daudov, 3539110
* Vorname2, Nachname2, Matrikelnummer2
*  Vorname2, Nachname2, Matrikelnummer2
*/

<!DOCTYPE html>
<html>
<head>
    <title>Rechner</title>
</head>
<body>

<h1>Rechner</h1>

<form action="" method="post">
    <label for="a">a:</label>
    <input type="text" id="a" name="a"><br><br>

    <label for="b">b:</label>
    <input type="text" id="b" name="b"><br><br>

    <input type="submit" name="addieren" value="Addieren">
    <input type="submit" name="multiplizieren" value="Multiplizieren">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $a = $_POST["a"];
    $b = $_POST["b"];

    if (isset($_POST["addieren"])) {
        $ergebnis = $a + $b;
        echo "Ergebnis der Addition: $ergebnis";
    }

    if (isset($_POST["multiplizieren"])) {
        $ergebnis = $a * $b;
        echo "Ergebnis der Multiplikation: $ergebnis";
    }
}
?>

</body>
</html>
