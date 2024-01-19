/*View zur vereinfachten Abfrage der Daten für hervorgehobene Bewertungen*/

CREATE VIEW view_hervorgehoben_bewertung AS
SELECT gericht.name, bewertungen.bemerkung, bewertungen.sternbewertung
FROM bewertungen
         LEFT JOIN gericht ON bewertungen.gericht_id = gericht.id WHERE bewertungen.hervorheben = 1;