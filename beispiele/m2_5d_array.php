<!--
- Praktikum E-Mensa Werbeseite. Autoren:
- Jeremy, Mainka, 3567706
- Philip, Engels, 3569528
- Bol, Daudov, 3539110
-->
<?php
$famousMeals = [
    1 => ['name' => 'Currywurst mit Pommes',
        'winner' => [2001, 2003, 2007, 2010, 2020]],
    2 => ['name' => 'Hähnchencrossies mit Paprikareis',
        'winner' => [2002, 2004, 2008]],
    3 => ['name' => 'Spaghetti Bolognese',
        'winner' => [2011, 2012, 2017]],
    4 => ['name' => 'Jägerschnitzel mit Pommes',
        'winner' => 2019]
];

function printWinners($meals)
{
    foreach ($meals as $key => $meal)
    {
        //echo '<p class = "name">'. $key. {$meal['name']}.'<br>&emsp</p>'; // Mahlzeit name
        echo '<p style="padding: unset;margin: unset" > ' . $key . '. ' . $meal['name'] .'</p>';
        $winningYears = (array)$meal['winner']; // Konvertiert in Array wegen letzen eintrages
        sort($winningYears); // Sortiert die Gewinnerjahre
        echo  '<p style="padding: unset;margin: unset;padding-left: 20px;">'.implode(', ', $winningYears).'</p>'; // Gibt die sortierten Gewinnerjahre aus
    }
}

printWinners($famousMeals); // Ruft die Funktion auf

function printNoWinners($meals)
{
    $arraywinners = [];
    foreach ($meals as $meal)
    {
        if(is_array($meal["winner"]))
        {
            $arraywinners = array_merge($arraywinners, $meal["winner"]);
        }
        else $arraywinners[] = $meal["winner"];
    }
    sort($arraywinners);
    $allyears= range(2000, 2023);

    $yearnowin = array_diff($allyears,$arraywinners);
    return $yearnowin;
}
$nowinners = printNoWinners($famousMeals);

echo "<br>".implode("<br>&emsp;",$nowinners)
?>