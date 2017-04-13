-- run this file as the mysql root user
-- mysql -u root

DROP DATABASE IF EXISTS daw1002_heros;
GRANT USAGE ON *.* TO 'daw1002_heros'@'localhost' IDENTIFIED BY 'daw1002_heros';
CREATE DATABASE daw1002_heros;
GRANT ALL ON daw1002_heros.* to 'daw1002_heros'@'localhost';
FLUSH PRIVILEGES;
USE daw1002_heros;

CREATE TABLE user(
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(30) NOT NULL UNIQUE,
  password VARCHAR(60) NOT NULL,
  firstname VARCHAR(30) NOT NULL,
  lastname VARCHAR(30) NOT NULL,
  email VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE item(
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(30) NOT NULL UNIQUE,
  ability TEXT NOT NULL,
  description TEXT NOT NULL,
  appearance TEXT NOT NULL,
  initial_location TEXT NOT NULL
); 

CREATE TABLE hero(
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(30) NOT NULL UNIQUE,
  ability TEXT NOT NULL,
  description TEXT NOT NULL
); 

CREATE TABLE team (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(30) NOT NULL UNIQUE,
  creator_user INT UNSIGNED NOT NULL UNIQUE,
    CONSTRAINT fk_team_creator_user FOREIGN KEY (creator_user) REFERENCES user(id) ON DELETE CASCADE,
  location TEXT NOT NULL
);

CREATE TABLE team_hero (
  team INT UNSIGNED NOT NULL,
  CONSTRAINT fk_teamhero_team FOREIGN KEY (team) REFERENCES team(id) ON DELETE CASCADE,

  hero INT UNSIGNED NOT NULL,
  CONSTRAINT fk_teamhero_hero FOREIGN KEY (hero) REFERENCES hero(id) ON DELETE CASCADE,

  CONSTRAINT unq_team_hero UNIQUE(team,hero)
);

CREATE TABLE team_item (
  team INT UNSIGNED NOT NULL,
    CONSTRAINT fk_teamitem_team FOREIGN KEY (team) REFERENCES team(id) ON DELETE CASCADE,

  item INT UNSIGNED NOT NULL,
    CONSTRAINT fk_teamitem_item FOREIGN KEY (item) REFERENCES item(id) ON DELETE CASCADE,

  hero INT UNSIGNED NOT NULL,
    CONSTRAINT fk_teamitem_hero FOREIGN KEY (hero) REFERENCES hero(id) ON DELETE CASCADE,

  CONSTRAINT unq_team_item UNIQUE(team,item)
);

-- now you can login to mysql using:
-- mysql -u daw1002_heros -pdaw1002_heros daw1002_heros
