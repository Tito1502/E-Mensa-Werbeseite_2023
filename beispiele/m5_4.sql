CREATE VIEW view_suppengerichte AS
SELECT * FROM gericht
WHERE name LIKE '%suppe%';

/*SELECT * FROM emensawerbeseite.view_suppengerichte;*/

CREATE VIEW view_anmeldungen AS
SELECT BesucherID, COUNT(BesucherID) AS anzahlbesuche
FROM besucher
ORDER BY anzahlbesuche DESC;

/*SELECT * FROM emensawerbeseite.view_anmeldungen;*/

CREATE VIEW view_kategorie_vegetarisch AS
SELECT kategorie.id, gericht.name
FROM kategorie
         LEFT JOIN gericht_hat_kategorie ON kategorie.id = gericht_hat_kategorie.kategorie_id
         LEFT JOIN gericht ON gericht_hat_kategorie.gericht_id = gericht.id AND gericht.vegetarisch = true;
         
/*SELECT * FROM  emensawerbeseite.view_kategorie_vegetarisch;*/

