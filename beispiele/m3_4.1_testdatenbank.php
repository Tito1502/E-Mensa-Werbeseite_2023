<?php
$link = mysqli_connect(
    "localhost",
    "root",
    "0000",
    "emensawerbeseite",
    3306
);

if(!$link){
    echo "Verbindung fehlgeschlagen: ", mysqli_connect_error();
    exit();
}

$sql = "select erfasst_am as erfassungsdatum, name as gerichtname from gericht order by gerichtname desc;";

$result = mysqli_query($link, $sql);

if ($result)
{
    if (mysqli_num_rows($result) > 0)
    {
        echo "<table>";
        echo "<tr><th>Erfassungsdatum</th><th>Gerichtname</th></tr>";
        while ($row = mysqli_fetch_assoc($result))
        {
            echo "<tr>";
            echo "<td>" . $row["erfassungsdatum"] . "</td>";
            echo "<td>" . $row["gerichtname"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    else echo "Keine Ergebnisse gefunden";

}
else echo "Fehler beim Ausführen der Abfrage: " . mysqli_error($link);

//select name, preisintern, preisextern from gericht order by name asc limit 5;

mysqli_close($link);