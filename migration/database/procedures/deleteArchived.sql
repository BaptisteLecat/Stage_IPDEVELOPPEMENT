-----------------------------------------
----------delete_Archived--------------
-----------------------------------------

DROP PROCEDURE IF EXISTS delete_Archived;
DELIMITER |
CREATE PROCEDURE delete_Archived ()  
BEGIN
	DECLARE fin BOOLEAN DEFAULT FALSE; -- Permet d'arreter la boucle si il n'y plus d'enregistrements
	DECLARE _id INT(11);
	DECLARE _deleted_on TIMESTAMP;
	DECLARE cursor_deleteDNS CURSOR FOR SELECT id, deleted_on FROM llx_dns_records WHERE deleted_on IS NOT NULL;

	OPEN cursor_deleteDNS;

		loop_cursor: LOOP -- Boucle qui parcours tout les enregistrements du curseur.
			FETCH cursor_deleteDNS INTO _id, _deleted_on;
			IF fin THEN
				LEAVE loop_cursor;
			END IF;
			IF (NOW() > _deleted_on) THEN
				DELETE FROM llx_dns_records WHERE id = _id;
			END IF;
		END LOOP;

	CLOSE cursor_deleteDNS;

END |
DELIMITER ;

call delete_Archived ();