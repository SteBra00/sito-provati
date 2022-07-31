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
    region_id INTEGER NOT NULL,
    FOREIGN KEY (region_id) REFERENCES region(id)
);

CREATE TABLE IF NOT EXISTS gender (
    id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(20) NOT NULL
);

CREATE TABLE IF NOT EXISTS pronoun (
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
    verified BOOLEAN NOT NULL DEFAULT 0,
    hideEmail BOOLEAN NOT NULL DEFAULT 0,
    hideBorn BOOLEAN NOT NULL DEFAULT 0,
    hideNationality BOOLEAN NOT NULL DEFAULT 0,
    hideLocality BOOLEAN NOT NULL DEFAULT 0,
    profileColor VARCHAR(7) NOT NULL DEFAULT '#DA0707',
    profileDark BOOLEAN NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS user_pronoun (
    user_id INTEGER NOT NULL,
    FOREIGN KEY (user_id) REFERENCES user(id),
    pronoun_id INTEGER NOT NULL,
    FOREIGN KEY (pronoun_id) REFERENCES pronoun(id)
);

CREATE TABLE IF NOT EXISTS user_whatLookingFor (
    user_id INTEGER NOT NULL,
    FOREIGN KEY (user_id) REFERENCES user(id),
    whatLookingFor_id INTEGER NOT NULL,
    FOREIGN KEY (whatLookingFor_id) REFERENCES whatLookingFor(id)
);

CREATE TABLE IF NOT EXISTS user_interest (
    user_id INTEGER NOT NULL,
    FOREIGN KEY (user_id) REFERENCES user(id),
    interest_id INTEGER NOT NULL,
    FOREIGN KEY (interest_id) REFERENCES interest(id)
);

CREATE TABLE IF NOT EXISTS liked (
    userFrom_id INTEGER NOT NULL,
    FOREIGN KEY (userFrom_id) REFERENCES user(id),
    userTo_id INTEGER NOT NULL,
    FOREIGN KEY (userTo_id) REFERENCES user(id)
);

CREATE TABLE IF NOT EXISTS blocked (
    userFrom_id INTEGER NOT NULL,
    FOREIGN KEY (userFrom_id) REFERENCES user(id),
    userTo_id INTEGER NOT NULL,
    FOREIGN KEY (userTo_id) REFERENCES user(id)
);

CREATE TABLE IF NOT EXISTS matched (
    userFrom_id INTEGER NOT NULL,
    FOREIGN KEY (userFrom_id) REFERENCES user(id),
    userTo_id INTEGER NOT NULL,
    FOREIGN KEY (userTo_id) REFERENCES user(id),
    compatibility INTEGER NOT NULL DEFAULT 100
);
