-- previously ssh to mysql docker container in order to connect to sql through terminal
CREATE DATABASE api_db;
CREATE USER 'api_db_user'@'localhost';
GRANT ALL PRIVILEGES ON api_db.* TO 'api_db_user'@'localhost';
SET PASSWORD FOR 'api_db_user'@'localhost' = 'parolaDeTest';

-- create table tasks
CREATE TABLE task (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(128) NOT NULL,
    priority INT DEFAULT NULL,
    is_completed BOOLEAN NOT NULL DEFAULT FALSE,
    PRIMARY KEY (id),
    INDEX (name)
);
