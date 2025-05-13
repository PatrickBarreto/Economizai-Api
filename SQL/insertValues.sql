--ir manualmente no banco ver se realmente foi com zero. A conta system de id 0 é necessária para informações default que precisam de account.
INSERT INTO accounts(id,name,phone,email) VALUES (0,'system', 00000000, '');

--Categorias default
INSERT IGNORE INTO categories (accounts_id, name)
VALUES
(0,'Outros'),
(0,'Proteínas'),
(0,'Fibras'),
(0,'Carboidratos'),
(0,'Gorduras'),
(0,'Temperos'),
(0,'Bebidas'),
(0,'Doces'),
(0,'Lacticínios'),
(0,'Higiene pessoal'),
(0,'Higiene doméstica'),
(0,'Padaria'),
(0,'Suprimentos para animais de estimação'),
(0,'Utilitários'),
(0,'Medicamentos');

-- Access-Token local
INSERT IGNORE INTO app_access_tokens(business, token_hash, expires_in) VALUES('localhost', MD5('localhost'), UNIX_TIMESTAMP()+ 31557600);

-- Unit Mensures 
INSERT IGNORE INTO unit_mensure(accounts_id, name, created, edited) 
VALUES
(0, 'mcg', NOW(), 0),
(0, 'mg', NOW(), 0),
(0, 'g', NOW(), 0),
(0, 'kg', NOW(), 0),
(0, 'mm', NOW(), 0),
(0, 'cm', NOW(), 0),
(0, 'm', NOW(), 0),
(0, 'mm2', NOW(), 0),
(0, 'cm2', NOW(), 0),
(0, 'm2', NOW(), 0),
(0, 'ml', NOW(), 0),
(0, 'l', NOW(), 0),
(0, 'c3', NOW(), 0),
(0, 'm3', NOW(), 0)

-- Item Types
INSERT IGNORE INTO item_types(accounts_id, name, created, edited) 
VALUES
(0, 'food', NOW(), 0),
(0, 'medicine', NOW(), 0),
