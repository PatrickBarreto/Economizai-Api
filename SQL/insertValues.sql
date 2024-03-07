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
INSERT IGNORE INTO app_access_tokens(business, token_hash, expires_in)VALUES('localhost', MD5('localhost'), UNIX_TIMESTAMP()+ 31557600);