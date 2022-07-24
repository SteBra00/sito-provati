CREATE DATABASE IF NOT EXISTS provaci_db;
USE provaci_db;


CREATE TABLE IF NOT EXISTS region (
    id INTEGER PRIMARY KEY NOT NULL,
    name VARCHAR(25) NOT NULL
);

CREATE TABLE IF NOT EXISTS province (
    id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(25) NOT NULL,
    abbreviation VARCHAR(5) NOT NULL,
    region INTEGER NOT NULL,
    FOREIGN KEY (region) REFERENCES region(id)
);

CREATE TABLE IF NOT EXISTS gender (
    id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(20) NOT NULL
);

CREATE TABLE IF NOT EXISTS pronouns (
    id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(10) NOT NULL
);

CREATE TABLE IF NOT EXISTS orientation (
    id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(20) NOT NULL
);

CREATE TABLE IF NOT EXISTS whatLookingFor (
    id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(20) NOT NULL
);

CREATE TABLE IF NOT EXISTS interest (
    id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(30) NOT NULL
);

CREATE TABLE IF NOT EXISTS user (
    id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
    username VARCHAR(30) UNIQUE NOT NULL,
    name_surname VARCHAR(50),
    email VARCHAR(50) UNIQUE NOT NULL,
    password TINYTEXT NOT NULL,
    gender INTEGER,
    FOREIGN KEY (gender) REFERENCES gender(id),
    orientation INTEGER,
    FOREIGN KEY (orientation) REFERENCES orientation(id),
    born DATE,
    profilePicture TINYTEXT,
    biography TINYTEXT,
    nationality VARCHAR(30),
    province INTEGER,
    linkInstagram TINYTEXT,
    linkFacebook TINYTEXT,
    linkTelegram TINYTEXT,
    linkSnapchat TINYTEXT,
    linkTwitter TINYTEXT,
    photography1 TINYTEXT,
    photography2 TINYTEXT,
    photography3 TINYTEXT,
    photography4 TINYTEXT,
    photography5 TINYTEXT,
    profession VARCHAR(40),
    verified BOOLEAN DEFAULT 0
);

CREATE TABLE IF NOT EXISTS user_pronouns (
    user INTEGER NOT NULL,
    FOREIGN KEY (user) REFERENCES user(id),
    pronouns INTEGER NOT NULL,
    FOREIGN KEY (pronouns) REFERENCES pronouns(id)
);

CREATE TABLE IF NOT EXISTS user_whatLookingFor (
    user INTEGER NOT NULL,
    FOREIGN KEY (user) REFERENCES user(id),
    whatLookingFor INTEGER NOT NULL,
    FOREIGN KEY (whatLookingFor) REFERENCES whatLookingFor(id)
);

CREATE TABLE IF NOT EXISTS user_interest (
    user INTEGER NOT NULL,
    FOREIGN KEY (user) REFERENCES user(id),
    interest INTEGER NOT NULL,
    FOREIGN KEY (interest) REFERENCES interest(id)
)