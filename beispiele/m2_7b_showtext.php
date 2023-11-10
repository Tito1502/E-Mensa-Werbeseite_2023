<!--
- Praktikum E-Mensa Werbeseite. Autoren:
- Jeremy, Mainka, 3567706
- Philip, Engels, 3569528
- Bol, Daudov, 3539110
-->
<?php

$file = fopen("en.txt", "r");
$content = fread($file,filesize('en.txt'));

if(isset($_GET["suche"]))
{
    $found = false;
    $suchwort = $_GET['suche'];
    $content2=explode("\n", $content);
    $content3 = [];

    foreach ($content2 as $row) {
        $row=trim($row);
        $row = explode(";", $row);
        foreach ($row as $item) {
            if ($item === $suchwort) {
                $found = true;
                if ($item == $row[0]) echo "die übersetzung für $suchwort ist $row[1]";
                else if ($item == $row[1]) echo "die übersetzung für $suchwort ist $row[0]";
            }
        }
    }
    if(!$found) echo "Das gesuchte wort '$suchwort' ist nicht vorhanden.";
}
else
{
    echo "geben sie ein suchwort ein";
}
fclose($file);