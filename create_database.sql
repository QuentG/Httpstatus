CREATE DATABASE IF NOT EXISTS consejo_gans;
use consejo_gans;

-- Create table of exemple
CREATE TABLE IF NOT EXISTS admin
(
    id INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL,
    mdp VARCHAR(255) NOT NULL,
    api_key VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS list_site
(
    id INT NOT NULL AUTO_INCREMENT,
    url_site VARCHAR(255) NOT NULL,
    status_site INT(11) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS history_site
(
    id_site INT(11) NOT NULL,
    update_site DATETIME NOT NULL,
    status_site INT(11) NOT NULL
);


INSERT INTO admin VALUES ('deschaussettes@yopmail.com', 'password', 'abcdefghjaimelesapis');