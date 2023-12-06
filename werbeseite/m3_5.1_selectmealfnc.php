<?php
//funktion um eine tabelle von gerichten anzuzeigen
//if $show gib die allergene der gerichte ezusätzlich aus 
function selectmealfromdb($sql, $show, $link): void
{

    $result = mysqli_query($link, $sql);//frage nach gerichten ab

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $codearray =[];
            echo '<table >';
            //if $show brauchen wir zusätzliche spalte für allergene
            if($show) echo '<tr><th>Name</th><th>Preis intern</th><th>Preis extern</th><th>Allergencode</th></tr>';
            else echo '<tr><th>Name</th><th>Preis intern</th><th>Preis extern</th></tr>';
            while ($row = mysqli_fetch_assoc($result)) {
            //gibt die reihen der gerichte aus
                echo "<tr>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["preisintern"] . "&euro;</td>";
                echo "<td>" . $row["preisextern"] . "&euro;</td>";
                if($show){
                    //frage nach der ganzen allergenliste ab
                    $getallergen = "select g.name, ga.code from gericht g left join gericht_hat_allergen ga on g.id = ga.gericht_id order by g.name;";
                    $allergeninmeal = mysqli_query($link, $getallergen);
                    $total_rows = mysqli_num_rows($allergeninmeal);
                    $current_row = 0;
                    //füge es in die tabelle ein
                    echo "<td>";
                    while($row2 = mysqli_fetch_assoc($allergeninmeal))
                    {
                        $current_row++;
                        if($row2["name"] == $row["name"] && $row2["code"] != NULL) {
                            echo $row2["code"];
                            if(!in_array($row2["code"],$codearray))$codearray[] =  $row2["code"];} //speichert allergencodes ohne duplikate 
                        if($row2["name"] == $row["name"] && $row2["code"] != NULL && $current_row != $total_rows) echo ", ";
                    }
                    echo "</td>";
                }
                echo "</tr>";
                sort($codearray); //sortiert für schöne ausgabe
            }

            echo '</table>';
            if($show)
            {
                $length = count($codearray);
                //frage db nach codeübersetzungsliste
                $sql = "select name, code from allergen;";
                $codetoallergen = mysqli_query($link, $sql);
                $array_result = mysqli_fetch_all($codetoallergen, MYSQLI_ASSOC);
                echo "<h3>Liste der Allergene</h3><ul>";
                
                foreach ($codearray as $code) {
                    foreach ($array_result as $item) {
                        if ($item['code'] === $code) {
                            echo "<li>". $item['code']." = ".$item['name'] . "</li>";
                            break; // Um die Schleife zu beenden, wenn ein Übereinstimmung gefunden wurde
                        }
                    }
                }
                echo "</ul>";
            }

        } else echo "Keine Ergebnisse gefunden";

    } else echo "Fehler beim Ausführen der Abfrage: " . mysqli_error($link);
}
