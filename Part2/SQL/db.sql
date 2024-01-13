CREATE DATABASE simpledb;
CREATE TABLE users(
    user_id MEDIUMINT(6) UNSIGNED PRIMARY kEY AUTO_INCREMENT,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    password VARCHAR(100) NOT NULL,
    registration_date DATETIME 


);