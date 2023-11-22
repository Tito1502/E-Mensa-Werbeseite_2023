<!--
- Praktikum E-Mensa Werbeseite. Autoren:
- Jeremy, Mainka, 3567706
- Philip, Engels, 3569528
- Bol, Daudov, 3539110
-->

<?php
const GET_PARAM_MIN_STARS = 'search_min_stars';
const GET_PARAM_SEARCH_TEXT = 'search_text';

/**
 * List of all allergens.
 */
$allergens = [
    11 => 'Gluten',
    12 => 'Krebstiere',
    13 => 'Eier',
    14 => 'Fisch',
    17 => 'Milch'
];

$meal = [
    'name' => 'Süßkartoffeltaschen mit Frischkäse und Kräutern gefüllt',
    'description' => 'Die Süßkartoffeln werden vorsichtig aufgeschnitten und der Frischkäse eingefüllt.',
    'price_intern' => 2.90,
    'price_extern' => 3.90,
    //verschachteltes array um mehrere Werte zu speichern
    'allergens' => $allergensmeal = array(11, 13),
    'amount' => 42             // Number of available meals
];

$ratings = [
    ['text' => 'Die Kartoffel ist einfach klasse. Nur die Fischstäbchen schmecken nach Käse. ',
        'author' => 'Ute U.',
        'stars' => 2],
    ['text' => 'Sehr gut. Immer wieder gerne',
        'author' => 'Gustav G.',
        'stars' => 4],
    ['text' => 'Der Klassiker für den Wochenstart. Frisch wie immer',
        'author' => 'Renate R.',
        'stars' => 4],
    ['text' => 'Kartoffel ist gut. Das Grüne ist mir suspekt.',
        'author' => 'Marta M.',
        'stars' => 3]
];

$searchText = '';

$show_description = 1;

$sprache = $_GET['sprache'] ?? 'de';

$art_bewertung = $_GET['art_bewertung'] ?? 'alle';

//array zur Übersetzung der statischen texte
$translation = [
    'Gericht' => 'Meal',
    'Allergene' => 'Allergens',
    'Preis' => 'Price',
    'Bewertungen' => 'Ratings',
    'Insgesamt' => 'In total',
    'Autor' => 'Author',
    'Sterne' => 'Stars',
    'Suchen' => 'Search'
];

$showRatings = [];
if (!empty($_GET[GET_PARAM_SEARCH_TEXT]))
{
    $searchTerm = $_GET[GET_PARAM_SEARCH_TEXT];
    foreach ($ratings as $rating)
    {
        //strpos = case sensitive, stripos = case insensitive
        if (stripos($rating['text'], $searchTerm) !== false)
        {
            $showRatings[] = $rating;
        }
    }
} else if (!empty($_GET[GET_PARAM_MIN_STARS]))
{
    $minStars = $_GET[GET_PARAM_MIN_STARS];
    foreach ($ratings as $rating)
    {
        if ($rating['stars'] >= $minStars)
        {
            $showRatings[] = $rating;
        }
    }
} else
{
    $showRatings = $ratings;
}

function calcMeanStars(array $ratings): float
{
    //$sum = 1 ist logisch falsch
    $sum = 0;
    foreach ($ratings as $rating)
    {
        $sum += $rating['stars'];
    }
    if (count($ratings) > 0)
    {
        return $sum / count($ratings);
    } else
    {
        return 0; // verhindert eine Division durch Null, wenn das Array leer ist
    }
}

//ermöglicht array elemente nach Anzahl Sterne zu sortieren
function compareByStars($a, $b)
{
    return $a['stars'] - $b['stars'];
}

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8"/>
    <title>Gericht: <?php echo $meal['name']; ?></title>
    <style>
        * {
            font-family: Arial, serif;
        }

        .rating {
            color: darkgray;
        }
    </style>
</head>
<body>

<!--
 - Links zum ändern von Website Parametern
 - Hinweis: Links anklicken oder nach Bewertungstexten suchen
 - setzt die Seite auf Deutsch, da ich keine Lösung für das
 - Problem gefunden habe
 -->
<a href="meal.php?sprache=de">Deutsch</a>
<a href="meal.php?sprache=en">English</a>
<br>
<a href="meal.php?art_bewertung=alle">ALLE</a>
<a href="meal.php?art_bewertung=TOP">TOP</a>
<a href="meal.php?art_bewertung=FLOPP">FLOPP</a>

<?php
//Zeigt das Gericht der Sprache entsprechend an
if ($sprache == 'en')
{
    echo "<h1>{$translation['Gericht']}: {$meal['name']} </h1>";
} elseif ($sprache == 'de')
{
    echo "<h1>Gericht: {$meal['name']}</h1>";
}
?>

<?php
//zeigt die Beschreibung an, sofern show_description = 1
//muss manuell in die suchleiste getippt werden : "&show_description=0" (default: Beschreibung aktiv)
if (isset($_GET["show_description"]))
{
    $show_description = $_GET["show_description"];
}
if ($show_description)
{
    echo "<p> {$meal['description']} </p>";
}
?>

<?php
//Zeigt die Überschrift "Allergene" der Sprache entsprechend an
if ($sprache == 'en')
{
    echo "{$translation['Allergene']}:";
} elseif ($sprache == 'de')
{
    echo "Allergene:";
}
?>

<ul>
    <?php
    //gibt die Allergene als ungeordnete Liste zurück
    for ($i = 0; $i < count($allergensmeal); $i++)
    {
        echo "<li>{$allergens[$allergensmeal[$i]]}</li>";
    }
    ?>
</ul>

<?php
//Trennt den String price_extern auf und wandelt ihn in den richtigen Syntax um
if ($sprache == 'en')
{
    echo "{$translation['Preis']}:";
} else if ($sprache == 'de')
{
    echo "Preis: <br>";
}
$preis = explode('.', $meal['price_extern']);
$preis = implode(',', $preis) . "0";
echo "<ul><li>{$preis}€</li></ul>"
?>

<?php
//schickt den Suchtext mit Post an den Server
if (isset($_POST['submit']))
{
    $searchtext = $_POST['search_text'];
}
?>


<?php
//zeigt die Überschrift "Bewertungen" bzw "Ratings" mitsamt durchschnittlicher Sternzahl an
if ($sprache == 'en')
{
    echo "<h1> {$translation['Bewertungen']} ({$translation['Insgesamt']}:" . calcMeanStars($ratings) . ")</h1>";
} elseif ($sprache == 'de')
{
    echo "<h1>Bewertungen (Insgesamt:" . calcMeanStars($ratings) . ")</h1>";
}
?>

<!--
 - Textfeld für Suchtext, der den eingegebenen Text weiterhin anzeigt
 -->
<form method="get">
    <label for="search_text">Filter:</label>
    <input id="search_text" type="text" name="search_text"
           value="<?php echo isset($_GET['search_text']) ? htmlspecialchars($_GET['search_text']) : ''; ?>">
    <input type="submit" value="<?php if ($sprache == 'en') {
        echo $translation['Suchen'];
    } elseif ($sprache == 'de') {
        echo "Suchen";
    } ?>">
</form>
<table class="rating">
    <thead>
    <tr>
        <?php
        //zeigt die Tabellen überschriften in der entsprechenden Sprache an
        if ($sprache == 'en')
        {
            echo "<td>Text</td>
		              <td>{$translation['Autor']}</td>
                      <td>{$translation['Sterne']}</td>";
        } elseif ($sprache == 'de')
        {
            echo "<td>Text</td>
		              <td>Autor</td>
                      <td>Sterne</td>";
        }
        ?>
    </tr>
    </thead>
    <tbody>
    <?php
    //Wenn art_bewertung nicht gesetzt ist oder weder "TOP","FLOPP" noch "alle" ist, wird es auf alle gesetzt
    if(!isset($_GET['art_bewertung']) || ($_GET['art_bewertung'] != 'FLOPP' && $_GET['art_bewertung'] != 'TOP' && $_GET['art_bewertung'] != 'alle'))
    {
        $art_bewertung = 'alle';
    }
    //sortiert das Array nach Anzahl Sterne
    usort($showRatings, 'compareByStars');
    //nimmt die niedrigste Anzahl Sterne aus dem Array
    if ($art_bewertung == 'FLOPP')
    {
        $top_star = $showRatings[0]['stars'];
        //nimmt die höchste Anzahl Sterne aus dem Array
    } else if ($art_bewertung == 'TOP')
    {
        $top_star = $showRatings[count($showRatings) - 1]['stars'];
    }
    //gibt alle "TOP" bzw "FLOPP" Bewertungen aus
    if ($art_bewertung == 'FLOPP' || $art_bewertung == 'TOP')
    {
        foreach ($showRatings as $rating)
        {
            if ($rating['stars'] == $top_star)
            {
                echo "<tr>
                <td class='rating_text'>{$rating['text']}</td>
                <td class='rating_author'>{$rating['author']}</td>
                <td class='rating_stars'>{$rating['stars']}</td>
              </tr>";
            }
        }
        //gibt alle Bewertungen aus
    } else{
        foreach ($showRatings as $rating)
        {
            echo "<tr>
                <td class='rating_text'>{$rating['text']}</td>
                <td class='rating_author'>{$rating['author']}</td>
                <td class='rating_stars'>{$rating['stars']}</td>
              </tr>";
        }
    }
    ?>
    </tbody>
</table>
</body>
</html>