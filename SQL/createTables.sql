
CREATE TABLE accounts (
    id int AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    phone VARCHAR(20),
    email VARCHAR(255),
    created BIGINT NOT NULL DEFAULT UNIX_TIMESTAMP(),
    edited BIGINT DEFAULT 0 NOT NULL,
    UNIQUE(email),
    UNIQUE(phone)
);

CREATE TABLE app_access_tokens (
	id int AUTO_INCREMENT PRIMARY KEY,
	business VARCHAR(255),
    token_hash VARCHAR(33),
    created BIGINT NOT NULL DEFAULT UNIX_TIMESTAMP(),
    expires_in BIGINT DEFAULT 0 NOT NULL,
    expried ENUM('1','0') NOT NULL DEFAULT '0',
    UNIQUE(token_hash)
);

CREATE TABLE shopping_lists (
    id INT AUTO_INCREMENT PRIMARY KEY,
    accounts_id INT(11),
    name VARCHAR(255),
    type ENUM('food', 'medicine'),
    created BIGINT NOT NULL DEFAULT UNIX_TIMESTAMP(),
    edited BIGINT DEFAULT 0 NOT NULL,
    FOREIGN KEY (accounts_id) REFERENCES accounts(id)
);

CREATE TABLE brands (
    id INT AUTO_INCREMENT PRIMARY KEY,
    accounts_id INT(11),
    name VARCHAR(255),
    type ENUM('food', 'medicine'),
    created BIGINT NOT NULL DEFAULT UNIX_TIMESTAMP(),
    edited BIGINT DEFAULT 0 NOT NULL,
    FOREIGN KEY (accounts_id) REFERENCES accounts(id)
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    accounts_id INT(11),
    name VARCHAR(255),
    created BIGINT NOT NULL DEFAULT UNIX_TIMESTAMP(),
    edited BIGINT DEFAULT 0 NOT NULL,
    FOREIGN KEY (accounts_id) REFERENCES accounts(id)
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    accounts_id INT(11),
    name VARCHAR(255),
    type ENUM('food', 'medicine'),
    volume INT(11),
    unit_mensure ENUM('mcg', 'mg', 'g', 'kg','mm', 'cm', 'm','mm2', 'cm2', 'm2', 'ml', 'l', 'c3', 'm3'),
    created BIGINT NOT NULL DEFAULT UNIX_TIMESTAMP(),
    edited BIGINT DEFAULT 0 NOT NULL,
    FOREIGN KEY (accounts_id) REFERENCES accounts(id)
);


-- Categories and products bond to identifier what productc can be and grouped
CREATE TABLE bond_categories_products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    categories_id INT(11),
    products_id INT(11),
    created BIGINT NOT NULL DEFAULT UNIX_TIMESTAMP(),
    edited BIGINT DEFAULT 0 NOT NULL,
    FOREIGN KEY (categories_id) REFERENCES categories(id),
    FOREIGN KEY (products_id) REFERENCES products(id),
    CONSTRAINT bondCategorieProduct UNIQUE(categories_id, products_id)
);


-- Categories and brands bond to identifier what brand can be showed for a product
CREATE TABLE bond_categories_brands (
	id INT AUTO_INCREMENT PRIMARY KEY,
	brands_id INT(11),
	categories_id INT(11),
    created BIGINT NOT NULL DEFAULT UNIX_TIMESTAMP(),
    edited BIGINT DEFAULT 0 NOT NULL,
	FOREIGN KEY (brands_id) REFERENCES brands(id),
	FOREIGN KEY (categories_id) REFERENCES categories(id),
	CONSTRAINT boundBrandCategories UNIQUE(brands_id, categories_id)
);


-- Shopping lists, categories and products bond to build and list with products to buy
CREATE TABLE bond_shopping_lists_products(
	id INT AUTO_INCREMENT PRIMARY KEY,
	shopping_lists_id INT(11),
	categories_id INT(11),
	products_id INT(11),
	amount INT(11),
    created BIGINT NOT NULL DEFAULT UNIX_TIMESTAMP(),
    edited BIGINT DEFAULT 0 NOT NULL,
	FOREIGN KEY(shopping_lists_id) REFERENCES shopping_lists(id),
	FOREIGN KEY(categories_id) REFERENCES categories(id),
	FOREIGN KEY(products_id) REFERENCES products(id),
	CONSTRAINT bondShoppingListProducts UNIQUE(shopping_lists_id, categories_id, products_id)
);

-- Shopping list execution to bond product options for N lists
CREATE TABLE shopping_lists_executions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    shopping_lists_id INT(11),
    execution_hash VARCHAR(33),
    created BIGINT NOT NULL DEFAULT UNIX_TIMESTAMP(),
    edited BIGINT DEFAULT 0 NOT NULL,
    FOREIGN KEY(shopping_lists_id) REFERENCES shopping_lists(id),
    CONSTRAINT bondShoppingListExecution UNIQUE(execution_hash)
);


CREATE TABLE bond_shopping_lists_products_options (
    id INT AUTO_INCREMENT PRIMARY KEY,
    shopping_lists_execution_hash VARCHAR(33),
    bond_shopping_lists_products_id INT(11),
    products_id INT(11), 
    brands_id INT(11), 
    type_description VARCHAR(50),
    wheight DOUBLE(10, 2),
    unit_mensure ENUM('mcg', 'mg', 'g', 'kg','mm', 'cm', 'm','mm2', 'cm2', 'm2', 'ml', 'l', 'c3', 'm3'),
    quantity INT(11),
    price DOUBLE(10, 2),
    created BIGINT NOT NULL DEFAULT UNIX_TIMESTAMP(),
    edited BIGINT DEFAULT 0 NOT NULL,
    FOREIGN KEY(shopping_lists_execution_hash) REFERENCES shopping_lists_executions(execution_hash),
    FOREIGN KEY(brands_id) REFERENCES brands(id),
    FOREIGN KEY(products_id) REFERENCES products(id),
    FOREIGN KEY(bond_shopping_lists_products_id) REFERENCES bond_shopping_lists_products(id)
);
