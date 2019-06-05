DROP TRIGGER IF EXISTS after_labprove_insert;
DELIMITER $$
CREATE TRIGGER after_labprove_insert
AFTER INSERT ON labprover
FOR EACH ROW
    BEGIN
        UPDATE vannprover AS v 
        INNER JOIN labprover AS l ON v.vannproveid = l.vannproveid
        SET v.labproveid=l.labproveid WHERE l.vannproveid = v.vannproveid;
END$$
DELIMITER ;

