#DROP DATABASE u775772700_plrey;
#CREATE DATABASE;

#USE u775772700_plrey;

# user and database = used_clothing
# password = used2Clothing

CREATE TABLE sex (
    sex_id tinyint(1) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
    sex char(10) NOT NULL
);

INSERT INTO sex (sex) VALUES 
    ('Femenino'),
    ('Masculino'),
    ('Unisex');

CREATE TABLE user (
    user_id mediumint(8) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
    firstname varchar(45) NOT NULL,
    lastname varchar(30) NOT NULL,  
    email varchar(50) NOT NULL,  
    password char(40) NOT NULL,
    photo_location varchar(100) NOT NULL,
    root tinyint(3) unsigned NOT NULL DEFAULT '0',
    sex_id tinyint(1) unsigned NOT NULL,
    verified tinyint(3) unsigned NOT NULL DEFAULT '0',
    FOREIGN KEY (sex_id)
        REFERENCES sex (sex_id) 
        ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO user (firstname, lastname, email, password, photo_location, root, sex_id) VALUES
    ('Fernando', 'Illan', 'Fernando.Illan@syss.tech', 'cef48cb4569d34364e0e86067efa14fbe9b4591e', 'img/users/default.jpg', 1, 2);

CREATE TABLE category (
    category_id tinyint(1) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
    category varchar(20) NOT NULL
);

INSERT INTO category (category) VALUES
    ('Accesorios'),
    ('Calzado'),
    ('Complementos'),
    ('Piernas'),
    ('Torso');

CREATE TABLE subcategory (
    subcategory_id tinyint(3) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
    subcategory varchar(30) NOT NULL,
    category_id tinyint(1) unsigned NOT NULL,
    sex_id tinyint(1) unsigned NOT NULL,
    FOREIGN KEY (category_id)
    REFERENCES category (category_id) 
    ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (sex_id)
    REFERENCES sex (sex_id) 
    ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO subcategory (subcategory, category_id, sex_id) VALUES
    ('Reloj', 1, 3),
    ('Jeans', 4, 3);

CREATE TABLE dress_item (
  dress_item_id int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name varchar(50) NOT NULL,
  description varchar(50) NOT NULL,
  photo_location varchar(100) NOT NULL,
  available tinyint(3) unsigned NOT NULL DEFAULT '1',
  user_id mediumint(8) unsigned NOT NULL,
  subcategory_id tinyint(3) unsigned NOT NULL,
  FOREIGN KEY (user_id)
    REFERENCES user (user_id) 
    ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (subcategory_id)
    REFERENCES subcategory (subcategory_id) 
    ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE event (
    event_id bigint(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,    
    description varchar(100) NOT NULL,
    full_description text,
    date date NOT NULL,
    user_id mediumint(8) unsigned NOT NULL,    
    FOREIGN KEY (user_id)
    REFERENCES user (user_id) 
    ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE used_clothing (
    event_id bigint(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    dress_item_id int(11) unsigned NOT NULL,
    FOREIGN KEY (event_id)
    REFERENCES event (event_id)
    ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (dress_item_id)
    REFERENCES dress_item (dress_item_id)
    ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE temp_dress_item (  
  dress_item_id int(11) unsigned NOT NULL,
  user_id mediumint(8) unsigned NOT NULL,    
    FOREIGN KEY (user_id)
    REFERENCES user (user_id)
    ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (dress_item_id)
    REFERENCES dress_item (dress_item_id)
    ON DELETE CASCADE ON UPDATE CASCADE
);