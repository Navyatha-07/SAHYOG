use SAHYOG1;
create table ngo_users(
    id int AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(250) NOT NULL UNIQUE,
    email varchar(250) NOT NULL UNIQUE,
    mobile_number VARCHAR(20) NOT NULL UNIQUE,
    password varchar(225) NOT NULL,
    nameofNGO varchar(250) NOT NULL UNIQUE,
    location varchar(250) NOT NULL UNIQUE
);
DESCRIBE ngo_users;
SHOW tables;
Select * from ngo_users;
