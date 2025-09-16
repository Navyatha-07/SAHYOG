use sahyog1;
create table  if not exists ngo_users (
    id int AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(250) NOT NULL ,
    email varchar(250) NOT NULL UNIQUE,
    mobile_number varchar(10) NOT NULL UNIQUE,
    password varchar(08) NOT NULL,
    nameofNGO varchar(250) NOT NULL ,
    location varchar(250) NOT NULL 
);
Alter table ngo_users MODIFY password VARCHAR(255) NOT NULL;
SHOW INDEX FROM ngo_users;
create table if not exists rural_users(
    ID int AUTO_INCREMENT PRIMARY kEY,
    FullName Varchar(250) NOT NULL,
    Email varchar(250) NOT NULL UNIQUE,
    MobileNumber varchar(10) NOT NULL UNIQUE,
    Password varchar(255) NOT NULL,
    Age VARCHAR(2) not null,
    Skills varchar(255) not null,
    location varchar(255) not null,
    Needs varchar(255) not null
);
Alter table rural_users MODIFY password VARCHAR(255) NOT NULL;
SHOW TABLES;
DESCRIBE ngo_users;


SHOW INDEX FROM ngo_users;
Create TABLE  if not exists Scheme(
    Scheme_ID INT AUTO_INCREMENT PRIMARY KEY,
    NGO_ID INT,
    Scheme_Title VARCHAR(255) NOT NULL,
    Scheme_Description TEXT NOT NULL,
    location VARCHAR(255) NOT NULL,
    Scheme_Date DATE NOT NULL,
    ELigibility TEXT NOT NULL,
    Category VARCHAR(100) NOT NULL,
    Status ENUM('active','inactive') DEFAULT 'active',
    Posted_Date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Foreign Key (NGO_ID) REFERENCES ngo_users(id)
);
ALTER TABLE Scheme CHANGE ELigibility Eligibility TEXT NOT NULL;