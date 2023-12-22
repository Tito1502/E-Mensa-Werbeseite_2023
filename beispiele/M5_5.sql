CREATE PROCEDURE anzahlanmeldungen_inc(IN user_id_input INT8)
BEGIN
    UPDATE benutzer
    SET anzahlanmeldungen = anzahlanmeldungen + 1
    WHERE id = user_id_input;
END;