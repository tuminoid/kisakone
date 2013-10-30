SET @DATABASE_NAME = 'fliitto_yleinen';

SELECT  CONCAT('ALTER TABLE ', table_name, ' ENGINE=InnoDB;') AS sql_statements
FROM    information_schema.tables AS tb
WHERE   table_schema = @DATABASE_NAME
AND     table_name LIKE 'kisakone_%'
AND     `ENGINE` = 'MyISAM'
AND     `TABLE_TYPE` = 'BASE TABLE'
ORDER BY table_name DESC;