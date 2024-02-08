
CREATE TABLE accounts (
    id int AUTO_INCREMENT PRIMARY KEY,
    name varchar(255),
    phone varchar(20),
    email varchar(255),
    created timestamp,
    edited timestamp,
    UNIQUE(email),
    UNIQUE(phone)
);

CREATE TABLE shopping_lists (
    id INT AUTO_INCREMENT PRIMARY KEY,
    accounts_id INT(11),
    name VARCHAR(255),
    type ENUM('food', 'medicine'),
    created TIMESTAMP,
    edited TIMESTAMP,
    FOREIGN KEY (accounts_id) REFERENCES accounts(id)
);

CREATE TABLE brands (
    id INT AUTO_INCREMENT PRIMARY KEY,
    accounts_id INT(11),
    name VARCHAR(255),
    type ENUM('food', 'medicine'),
    created TIMESTAMP,
    edited TIMESTAMP,
    FOREIGN KEY (accounts_id) REFERENCES accounts(id)
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    accounts_id INT(11),
    name VARCHAR(255),
    created TIMESTAMP,
    edited TIMESTAMP,
    FOREIGN KEY (accounts_id) REFERENCES accounts(id)
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    accounts_id INT(11),
    brands_id INT(11),
    name VARCHAR(255),
    type ENUM('food', 'medicine'),
    volume int(11),
    unit_mensure ENUM('mcg', 'mg', 'g', 'kg','mm', 'cm', 'm','mm2', 'cm2', 'm2', 'ml', 'l', 'c3', 'm3'),
    created TIMESTAMP,
    edited TIMESTAMP,

    FOREIGN KEY (accounts_id) REFERENCES accounts(id),
    FOREIGN KEY (brands_id) REFERENCES brands(id)
);



CREATE TABLE bond_categories_products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    categories_id INT(11),
    products_id INT(11),
    FOREIGN KEY (categories_id) REFERENCES categories(id),
    FOREIGN KEY (products_id) REFERENCES products(id),
    CONSTRAINT bondCategorieProduct UNIQUE(categories_id, products_id)
);


CREATE TABLE bond_brand_categories (
id INT AUTO_INCREMENT PRIMARY KEY,
brands_id INT(11),
categories_id INT(11),
CONSTRAINT boundBrandCategories UNIQUE(brands_id, categories_id),
FOREIGN KEY (brands_id) REFERENCES brands(id),
FOREIGN KEY (categories_id) REFERENCES categories(id)
);