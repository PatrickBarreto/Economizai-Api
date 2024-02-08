--ir manualmente no banco ver se realmente foi com zero. A conta system de id 0 é necessária para informações default que precisam de account.
INSERT INTO accounts(id,name,phone,email) VALUES (0,'system', 00000000, '');

--
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