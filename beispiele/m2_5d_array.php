<?php
/**
 * Praktikum DBWT. Autoren:
 * Bol, Daudov, 3539110
 * Vorname2, Nachname2, Matrikelnummer2
 *  Vorname2, Nachname2, Matrikelnummer2
 */
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
        echo "$key. {$meal['name']}<br>&emsp;"; // Mahlzeit name
        $winningYears = (array)$meal['winner']; // Konvertiert in Array wegen letzen eintrages
        sort($winningYears); // Sortiert die Gewinnerjahre
        echo  implode(', ', $winningYears)."<br>"; // Gibt die sortierten Gewinnerjahre aus
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
echo "&emsp;".implode("<br>&emsp;",$nowinners)
?>