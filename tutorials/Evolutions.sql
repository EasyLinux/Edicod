ALTER TABLE 'documents' ADD COLUMN 'docsize' BIGINT DEFAULT NULL COMMENT 'Taille du fichier', 
                        ADD COLUMN 'keywords' TEXT NULL DEFAULT NULL COMMENT 'Mots clés saisis à la main';
ALTER TABLE 'documents' ADD COLUMN 'md5' TEXT NOT NULL COMMENT 'MD5 du fichier'; 
ALTER TABLE `_SqlStructure` ADD `S_Comment` MEDIUMTEXT NOT NULL COMMENT 'Les commentaires';
