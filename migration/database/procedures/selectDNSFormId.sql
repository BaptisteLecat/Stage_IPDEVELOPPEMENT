-----------------------------------------
----------select_DNS_fromId--------------
-----------------------------------------

DROP PROCEDURE IF EXISTS select_DNS_fromId;
DELIMITER |
CREATE PROCEDURE select_DNS_fromId (IN _id INT(11), OUT _domain_id INT(10), OUT _subDomain VARCHAR(255), OUT _target VARCHAR(255), OUT _deleted_on TIMESTAMP, OUT _created_on TIMESTAMP, OUT _modified_on TIMESTAMP, OUT _dns_field_id INT(10), OUT _priority INT(10))  
BEGIN
	DECLARE _flag  integer          default null; -- Permet de tester si l'enregistrement est présent dans la table fille llx_dns_mx

	set _flag = (SELECT 1 FROM llx_dns_mx WHERE id = _id); -- Si == 1 l'id de l'enregistrement est dans la table dns_mx donc il est de type MX.
	IF (_flag = 1) THEN
		SELECT subDomain, target, deleted_on, created_on, modified_on, dns_field_id, domain_id, priority INTO _subDomain, _target, _deleted_on, _created_on, _modified_on, _dns_field_id, _domain_id, _priority FROM llx_dns_mx, llx_dns_records WHERE llx_dns_records.id = llx_dns_mx.id AND llx_dns_records.id = _id; -- On récupere la tout + la priority pour avoir toutes les infos du champs.
	ELSE
		SELECT subDomain, target, deleted_on, created_on, modified_on, dns_field_id, domain_id INTO _subDomain, _target, _deleted_on, _created_on, _modified_on, _dns_field_id, _domain_id FROM llx_dns_records WHERE id = _id;

	END IF;

	SELECT _subDomain, _target, _deleted_on, _created_on, _modified_on, _dns_field_id, _domain_id, _priority;

END |
DELIMITER ;

call select_DNS_fromId (0, @domain_id, @subDomain, @target, @deleted_on, @created_on, @modified_on, @dns_field_id, @priority);