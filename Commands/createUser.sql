CREATE DATABASE apibiometrics;
USE apibiometrics;
CREATE TABLE Users (
 Id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
 SubjectId varchar(30) UNIQUE NOT NULL,
 Template longblob NULL,
 name varchar(60) NULL,
 terminal_key varchar(30) NULL,
email varchar(30) NULL
);
