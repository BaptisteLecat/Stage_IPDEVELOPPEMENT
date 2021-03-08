-----------------------------------------
----------select_DNS_fromDomain----------
-----------------------------------------

DROP PROCEDURE IF EXISTS select_DNS_fromDomain;

DELIMITER |
CREATE PROCEDURE select_DNS_fromDomain (IN _domainId INT(11), OUT _id INT(10), OUT _subDomain VARCHAR(255), OUT _target VARCHAR(255), OUT _deleted_on TIMESTAMP, OUT _created_on TIMESTAMP, OUT _modified_on TIMESTAMP, OUT _dns_field_id INT(10), OUT _priority INT(10))  
BEGIN
	DECLARE fin BOOLEAN DEFAULT FALSE; -- Permet d'arreter la boucle si il n'y plus d'enregistrements
	DECLARE _flag  integer          default null; -- Permet de tester si l'enregistrement est présent dans la table fille llx_dns_mx
	DECLARE curseur CURSOR FOR SELECT id, subDomain, target, deleted_on, created_on, modified_on, dns_field_id FROM llx_dns_records WHERE domain_id = _domainId; -- Initialisation du curseur
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET fin = TRUE; 

	OPEN curseur;

	-- On défini une table temporaire afin d'y insérer nos DNS avec TOUTES les infos: cf(priority)
	DROP TEMPORARY TABLE IF EXISTS TMP_DNS;
	CREATE TEMPORARY TABLE TMP_DNS(
		_id INT PRIMARY KEY,
		_subDomain VARCHAR(255),
		_target VARCHAR(255),
		_deleted_on timestamp NULL DEFAULT NULL,
		_created_on TIMESTAMP,
		_modified_on TIMESTAMP,
		_dns_field_id INT,
		_priority INT NULL
	); 

	loop_curseur: LOOP -- Boucle qui parcour tout les enregistrements du curseur.
		FETCH curseur INTO _id, _subDomain, _target, _deleted_on, _created_on, _modified_on, _dns_field_id;
		IF fin THEN
			LEAVE loop_curseur;
		END IF;
		set _flag = (SELECT 1 FROM llx_dns_mx WHERE id = _id); -- Si == 1 l'id de l'enregistrement est dans la table dns_mx donc il est de type MX.
		IF (_flag = 1) THEN
			SELECT priority INTO _priority FROM llx_dns_mx WHERE id = _id; -- On récupere la priority pour avoir toutes les infos du champs.
		END IF;
		INSERT INTO TMP_DNS VALUES(_id, _subDomain, _target, _deleted_on, _created_on, _modified_on, _dns_field_id, _priority); -- on insere les données pour les récuperer dans la table virtuelle.
		set _flag = null;
		set _priority = null;

	END LOOP;

	CLOSE curseur;

END |
DELIMITER ;

call select_DNS_fromDomain (0, @id, @subDomain, @target, @deleted_on, @created_on, @modified_on, @dns_field_id, @priority);