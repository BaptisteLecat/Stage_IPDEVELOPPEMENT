---------------------------------------
----------INSERT_DNS_STANDARD----------
---------------------------------------

DROP PROCEDURE IF EXISTS insert_DNS_standard;
DELIMITER |
CREATE PROCEDURE insert_DNS_standard (IN _subDomain VARCHAR(255), IN _target TEXT, _domain_id INT(11), _dns_field_id INT(11))  
BEGIN
	DECLARE _dnsId integer unsigned default null; -- valeur de retour pour connaitre l'id de l'insertion.

	INSERT INTO llx_dns_records (subDomain, target, domain_id, dns_field_id) VALUES (_subDomain, _target, _domain_id, _dns_field_id); -- Insertion des valeurs dans la table mère
    set _dnsId = last_insert_id(); -- récupération de l'id pour donné le meme id à la table fille
    INSERT INTO llx_dns_standard (id) VALUES (_dnsId); -- insertion dans la table fille

	SELECT _dnsId; -- retour de l'id
END |
DELIMITER ;

call insert_DNS_standard("subDomain", "target", 0, 0);