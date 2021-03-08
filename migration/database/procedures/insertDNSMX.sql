---------------------------------
----------INSERT_DNS_MX----------
---------------------------------

DROP PROCEDURE IF EXISTS insert_DNS_mx;
DELIMITER |
CREATE PROCEDURE insert_DNS_mx (IN _subDomain VARCHAR(255), IN _target TEXT, IN _domain_id INT(10), IN _priority INT(11))  
BEGIN
	DECLARE _dnsId integer unsigned default null; -- valeur de retour pour connaitre l'id de l'insertion.
	DECLARE _dns_field_id integer default null; -- prendra l'id de MX dans la table llx_dns_fields

	SELECT id INTO _dns_field_id FROM llx_dns_fields WHERE label = "MX"; -- si c'est un MX l'id de field doit correspondre à celui de MX dans la table

	INSERT INTO llx_dns_records (subDomain, target, domain_id, dns_field_id) VALUES (_subDomain, _target, _domain_id, _dns_field_id); -- Insertion des valeurs dans la table mère
    set _dnsId = last_insert_id(); -- récupération de l'id pour donné le meme id à la table fille
    INSERT INTO llx_dns_mx (id, priority) VALUES (_dnsId, _priority); -- insertion dans la table fille

	SELECT _dnsId; -- retour de l'id
END |
DELIMITER ;

call insert_DNS_mx ("subDomain", "target", 0, 0);