-- DATABASE SCHEMA
-- id          int auto increment 
-- ip          varchar 
-- timestamp   int (nota: unix timestamp) 
-- operation   varchar (nota: armazenar a operação completa e.g. 1 + 1 / 2 * 5) 
-- result      decimal(12,4) 
-- bonus       boolean/tinyint (nota: indicar se o resultado da operação acertou no número aleatório) 


DROP TABLE IF EXISTS Calculation;

CREATE TABLE Calculation (
    Id INTEGER PRIMARY KEY AUTOINCREMENT,
    Ip VARCHAR(15) NOT NULL,
    OperationTimestamp INTEGER NOT NULL,
    Operation VARCHAR(100) NOT NULL,
    Result DECIMAL(12,4) NOT NULL,
    Bonus BOOLEAN NOT NULL
);