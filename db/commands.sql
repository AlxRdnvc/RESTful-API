-- previously ssh to mysql docker container in order to connect to sql through terminal
CREATE DATABASE api_db;
CREATE USER 'api_db_user'@'localhost';
GRANT ALL PRIVILEGES ON api_db.* TO 'api_db_user'@'localhost';
SET PASSWORD FOR 'api_db_user'@'localhost' = 'parolaDeTest';

-- create table task
CREATE TABLE task (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(128) NOT NULL,
    priority INT DEFAULT NULL,
    is_completed BOOLEAN NOT NULL DEFAULT FALSE,
    PRIMARY KEY (id),
    INDEX (name)
);

-- seed the table task
INSERT INTO task (name, priority, is_completed)
VALUES
    ('Complete Project Proposal', 1, FALSE),
    ('Attend Team Meeting', 2, FALSE),
    ('Review Code Pull Requests', 3, FALSE),
    ('Write Monthly Report', 2, FALSE),
    ('Plan Team Building Event', 1, TRUE),
    ('Respond to Client Emails', 3, FALSE),
    ('Prepare for Product Launch', 1, FALSE),
    ('Conduct User Research', 2, FALSE),
    ('Brainstorm New Feature Ideas', 3, FALSE),
    ('Evaluate Competitor Products', 2, TRUE);

-- create table user for the api_key authentication
CREATE TABLE user (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(128) NOT NULL,
    username VARCHAR(128) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    api_key VARCHAR(32) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE (username),
    UNIQUE (api_key)
);

-- add foreign key relationship to link task records to user records
ALTER TABLE task
ADD user_id INT NOT NULL,
ADD INDEX (user_id);

UPDATE task 
SET user_id = 1;

ALTER TABLE task
ADD FOREIGN KEY (user_id) REFERENCES user(id)
ON DELETE CASCADE ON UPDATE CASCADE;