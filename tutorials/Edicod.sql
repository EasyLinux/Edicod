USE Edicod;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `cabinet` (
  `cabid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'cabinet id',
  `parent` int(11) NOT NULL COMMENT 'Dossier parent',
  `label` varchar(64) NOT NULL COMMENT 'Nom du classement',
  PRIMARY KEY (`cabid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Classement' AUTO_INCREMENT=2 ;

INSERT INTO `cabinet` (`cabid`, `parent`, `label`) VALUES
(1, 0, 'Global (par defaut)');

CREATE TABLE IF NOT EXISTS `CommonWords` (
  `coid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique',
  `keyword` varchar(128) NOT NULL COMMENT 'Mot clé à ignorer',
  PRIMARY KEY (`coid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

INSERT INTO `CommonWords` (`coid`, `keyword`) VALUES
(1, 'comme'),
(5, 'avec'),
(3, 'pendant'),
(4, 'sont'),
(6, 'cette'),
(7, 'avant'),
(8, 'date'),
(9, 'plus'),
(10, 'loin'),
(11, 'dans');

CREATE TABLE IF NOT EXISTS `contact` (
  `conid` int(32) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant Unique',
  `valid` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Contact actif (0/N)',
  `company` varchar(64) NOT NULL COMMENT 'Raison sociale',
  `name` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Nom de l utilisateur',
  `genre` text NOT NULL,
  `given_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '' COMMENT 'Prenom de l utilisateur',
  `email` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Mail ',
  `phone` varchar(16) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '' COMMENT 'Numero de telephone',
  `num` int(11) DEFAULT '0' COMMENT 'Numero de rue',
  `address1` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Ligne d''adresse 1',
  `address2` varchar(64) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Ligne d''adresse 2',
  `city` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '' COMMENT 'Localité',
  `zip` varchar(5) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '' COMMENT 'Code postal',
  PRIMARY KEY (`conid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Contact' AUTO_INCREMENT=1 ;

INSERT INTO `contact` (`conid`, `valid`, `company`, `name`, `genre`, `given_name`, `email`, `phone`, `num`, `address1`, `address2`, `city`, `zip`) VALUES
(0, 0, 'VIDE', 'Vide', '', '', NULL, '', 0, NULL, NULL, '', '');

CREATE TABLE IF NOT EXISTS `docattach` (
  `did_docattach` int(11) NOT NULL AUTO_INCREMENT,
  `did` int(11) NOT NULL,
  PRIMARY KEY (`did_docattach`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `docdraft` (
  `ddid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant',
  `did` int(11) DEFAULT NULL COMMENT 'Identifiant parent',
  `name` varchar(32) NOT NULL COMMENT 'Nom du courrier',
  `description` varchar(254) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `path` varchar(128) DEFAULT NULL COMMENT 'Chemin du fichier',
  `wfsid` int(11) DEFAULT NULL COMMENT 'Etape workflow',
  `guid` varchar(5) NOT NULL COMMENT 'groupe ou utilisateur',
  `conid` int(11) NOT NULL COMMENT 'contact',
  `objet` varchar(64) NOT NULL,
  `receptnum` varchar(32) DEFAULT NULL COMMENT 'Numéro recommandé',
  `mid` int(11) NOT NULL COMMENT 'template associe',
  `content` text NOT NULL COMMENT 'texte',
  PRIMARY KEY (`ddid`),
  UNIQUE KEY `did` (`did`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Brouillon courrier en sortie' AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `docfolders` (
  `did` int(11) NOT NULL COMMENT 'Pointe sur document',
  `fid` int(11) NOT NULL COMMENT 'pointe sur folders',
  PRIMARY KEY (`did`,`fid`),
  KEY `docf_doc_FK` (`did`),
  KEY `docf_folders_FK` (`fid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Lien entre documents et folders';

CREATE TABLE IF NOT EXISTS `dockeywords` (
  `kid` int(11) NOT NULL AUTO_INCREMENT,
  `wichparts` int(11) NOT NULL DEFAULT '0' COMMENT 'Partie de la fiche où apparait le mot',
  `did` int(11) NOT NULL,
  `occurs` int(11) NOT NULL COMMENT 'Nombre de fois qu''un mot apparait',
  PRIMARY KEY (`kid`,`wichparts`,`did`),
  KEY `fk_dockeywords_documents1` (`did`),
  KEY `kid` (`kid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Lie les mots clés à un document' AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `doclink` (
  `did1` int(11) NOT NULL COMMENT 'pointe sur document 1',
  `did2` int(11) NOT NULL COMMENT 'pointe sur document 2',
  PRIMARY KEY (`did1`,`did2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Lie les documents entre eux';

CREATE TABLE IF NOT EXISTS `doclog` (
  `logid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique',
  `did` int(11) NOT NULL COMMENT 'Pointeur sur document attaché',
  `uid` int(11) NOT NULL COMMENT 'Utilisateur',
  `action` int(11) DEFAULT NULL COMMENT 'Lié au workflow',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Time stamp',
  `description` varchar(254) NOT NULL COMMENT 'Description',
  PRIMARY KEY (`logid`),
  KEY `doclog_doc_FK` (`did`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Journal des documents' AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `docnote` (
  `dnid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique',
  `uid` int(11) NOT NULL COMMENT 'Utilisateur',
  `did` int(11) NOT NULL COMMENT 'Document lié',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date et heure',
  `parent` int(11) NOT NULL COMMENT 'Note liée',
  `note` mediumtext NOT NULL,
  PRIMARY KEY (`dnid`),
  KEY `uid` (`uid`,`did`,`parent`),
  KEY `docn_doc_FK` (`did`),
  KEY `docn_user_KF` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Notes sur un document' AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `documents` (
  `did` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Document id',
  `name` varchar(128) NOT NULL COMMENT 'Nom document',
  `path` varchar(128) NOT NULL COMMENT 'Repertoire',
  `size` bigint(20) NOT NULL COMMENT 'Taille du fichier',
  `object` varchar(64) NOT NULL COMMENT 'Objet du document',
  `cabid` int(11) DEFAULT NULL COMMENT 'Classement',
  `date_in` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date arrivee',
  `date_due` date NOT NULL COMMENT 'Date de traitement',
  `date_out` date DEFAULT NULL COMMENT 'Date depart',
  `date_del` date NOT NULL COMMENT 'Date à partir de laquelle le courrier sera supprimé',
  `conid` int(11) DEFAULT NULL COMMENT 'Contact Id',
  `receptid` varchar(16) DEFAULT NULL COMMENT 'Numero recommande',
  `wfsid` int(11) NOT NULL COMMENT 'Etape du parcours',
  `md5` text NOT NULL COMMENT 'MD5 du fichier',
  PRIMARY KEY (`did`),
  KEY `docs_cabinet_FK` (`cabid`),
  KEY `docs_contact_FK` (`conid`),
  KEY `docs_wfsteps_FK` (`wfsid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Document' AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `docview` (
  `uid` int(11) NOT NULL COMMENT 'Lie a user',
  `did` int(11) NOT NULL COMMENT 'Lie a documents',
  PRIMARY KEY (`uid`,`did`),
  KEY `fk_docview_user` (`uid`),
  KEY `fk_docview_documents1` (`did`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Liste des utilisateurs en copie d''une table';

CREATE TABLE IF NOT EXISTS `folders` (
  `fid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'folder id',
  `label` varchar(64) NOT NULL COMMENT 'Nom du dossier',
  `parent` int(11) NOT NULL COMMENT 'Dossier parent',
  PRIMARY KEY (`fid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Dossiers pour les courriers' AUTO_INCREMENT=2 ;

INSERT INTO `folders` (`fid`, `label`, `parent`) VALUES
(1, 'Global (Par d&eacute;faut)', 0);

CREATE TABLE IF NOT EXISTS `groups` (
  `gid` int(32) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant',
  `wfsid` int(11) DEFAULT NULL COMMENT 'Etape de workflow par défaut',
  `name` varchar(32) COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Nom du groupe',
  `inputdirectory` varchar(254) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Répertoire d''entrée des documents',
  `comment` varchar(64) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Description',
  `wfsidout` int(11) DEFAULT NULL COMMENT 'Etape par défaut courrier sortant',
  `address1` varchar(64) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Adresse 1',
  `address2` varchar(64) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Adresse 2',
  `zip` varchar(12) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Code postal',
  `city` varchar(32) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Ville',
  `phone` varchar(16) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Téléphone',
  `fax` varchar(16) COLLATE latin1_general_ci DEFAULT NULL COMMENT 'Fax',
  PRIMARY KEY (`gid`),
  KEY `GRP_NOM` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Groupes d''utilisateurs' AUTO_INCREMENT=2 ;

INSERT INTO `groups` (`gid`, `wfsid`, `name`, `inputdirectory`, `comment`, `wfsidout`, `address1`, `address2`, `zip`, `city`, `phone`, `fax`) VALUES
(1, NULL, 'Tout le monde', '/', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

CREATE TABLE IF NOT EXISTS `g_grp` (
  `gid` int(32) DEFAULT NULL COMMENT 'Groupe ID',
  `uid` int(11) DEFAULT NULL COMMENT 'USER ID',
  `ggrpID` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ggrpID`),
  UNIQUE KEY `ggrp_UQ` (`gid`,`uid`),
  KEY `ggrp_user_FK` (`uid`),
  KEY `gid_IDX` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Lien entre utilisateurs et groupes' AUTO_INCREMENT=2 ;

INSERT INTO `g_grp` (`gid`, `uid`, `ggrpID`) VALUES
(1, 1, 1);

CREATE TABLE IF NOT EXISTS `keywords` (
  `kid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique',
  `keyword` varchar(64) NOT NULL COMMENT 'Mot clé',
  PRIMARY KEY (`kid`),
  UNIQUE KEY `keyword_idx` (`keyword`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Liste des mots clés de la base de données' AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `menu` (
  `id_menu` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant',
  `parent` int(11) NOT NULL COMMENT 'Menu parent',
  `ordering` int(11) NOT NULL COMMENT 'Ordre d''apparition',
  `rights` int(11) NOT NULL COMMENT 'Droits (profile)',
  `display` varchar(32) NOT NULL COMMENT 'a afficher',
  `link` varchar(32) NOT NULL COMMENT 'option',
  `icon` varchar(128) NOT NULL COMMENT 'icone',
  PRIMARY KEY (`id_menu`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Gestion des menus' AUTO_INCREMENT=28 ;

INSERT INTO `menu` (`id_menu`, `parent`, `ordering`, `rights`, `display`, `link`, `icon`) VALUES
(1, 0, 200, 8, 'Configuration', '.', ''),
(2, 0, 300, 4, 'Administration', '.', ''),
(3, 0, 500, 1, 'Pr&eacute;f&eacute;rences', '.', ''),
(4, 3, 501, 1, 'Mon compte', 'MyAccount', 'user.png'),
(5, 0, 900, 1, 'D&eacute;connexion', 'Logout', 'exit.png'),
(6, 2, 301, 4, 'Utilisateurs', 'UserAdmin', 'user_red.png'),
(8, 1, 201, 8, 'Param&eacute;trage', 'Configure', 'configure.png'),
(9, 2, 302, 4, 'Contacts', 'Contact', 'contacts.png'),
(10, 0, 1, 1, 'Courrier arriv&eacute;', 'FrontPage', 'home.png'),
(11, 2, 303, 4, 'Groupes', 'Groups', 'group.png'),
(12, 2, 304, 4, 'R&eacute;pertoires', 'Folders', 'folder.png'),
(15, 0, 10, 1, 'Recherche', 'Find', 'mail_find.png'),
(16, 0, 100, 2, 'Gestion courrier', '.', ''),
(19, 16, 101, 2, 'Dossiers virtuels', 'DocFolders', 'docfolder.png'),
(20, 16, 102, 32, 'Ajout courrier', 'AddDocument', 'mail_add.png'),
(21, 16, 103, 2, 'Chrono', 'Chrono', 'chrono.png'),
(22, 16, 104, 2, 'Classement', 'Cabinet', 'cabinet.png'),
(23, 2, 305, 2, 'Workflow', 'Workflow', 'workflow.png'),
(24, 1, 202, 32, 'Mise &agrave; jour', 'Update', 'update.png'),
(25, 1, 203, 16, 'Publication', 'Publish', 'publish.png'),
(26, 1, 204, 32, 'ReadFile', '/Cron/ReadFiles2.php', 'update.png'),
(27, 16, 105, 32, 'Envoyer courrier', 'SendMail', 'mail_send.png');

CREATE TABLE IF NOT EXISTS `parameters` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant',
  `name` varchar(32) NOT NULL DEFAULT '.' COMMENT 'Nom de la variable',
  `type` varchar(16) NOT NULL DEFAULT 'text' COMMENT 'Type de champs',
  `value` varchar(128) DEFAULT '.' COMMENT 'Valeur',
  `display` varchar(64) NOT NULL COMMENT 'Nom à afficher',
  `description` varchar(254) NOT NULL COMMENT 'Texte long pour expliquer le paramêtre',
  `params` varchar(128) NOT NULL COMMENT 'Utilisé pour les select',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Variables gérées par le configurateur' AUTO_INCREMENT=34 ;

INSERT INTO `parameters` (`id`, `name`, `type`, `value`, `display`, `description`, `params`) VALUES
(1, 'SqlEngine', 'ListSelect', 'MYSQL', 'Moteur de b.d.d.', 'Moteur de base de donn&eacute;es', 'MYSQL:Serveur MySQL|PGSQL: Serveur Postgres|MSSQL:Serveur Sql Microsoft|ORACLE:Oracle Sql'),
(2, 'SqlSrv', 'bad', 'localhost', 'Serveur de B.d.d.', 'Nom du serveur de base de donn&eacute;es. <br />Non fonctionnel !', ''),
(3, 'SqlUsr', 'bad', 'Edicod', 'Utilisateur B.d.d.', 'Nom de l''utilisateur de la base de donn&eacute;es. <br />Non fonctionnel !', ''),
(4, 'SqlPwd', 'bad', 'Edicod', 'Mot de passe B.d.d', 'Mot de passe de l''utilisteur de la base de donn&eacute;es. <br />Non fonctionnel !', ''),
(5, 'SqlBase', 'bad', 'Edicod', 'Nom de la B.d.d', 'Nom de la base de donn&eacute;es. <br />Non fonctionnel !', ''),
(6, 'StorePath', 'text', '/Root', 'R&eacute;pertoire de stockage', 'Arborescence de stockage des courriers', ''),
(7, 'InputPath', 'text', '/Input', 'Chemin r&eacute;pertoire d''entr&eacute;e', 'Point d''entr&eacute;e des courriers', ''),
(8, 'AbsoluteDocuments', 'text', '/Data/Edicod', 'Chemin documents (absolu)', 'Chemin absolu de stockage des documents Edicod', ''),
(9, 'RelativeDocuments', 'text', '/Documents', 'Chemin documents (relatif)', 'Chemin relatif de stockage des documents Edicod.<br /><br /><b><u>NB</u></b> Une directive <i>alias</i> est n&eacute;cessaire dans <i>Apache</i>.', ''),
(10, 'TimeOut', 'int', '9000', 'Temps avant d&eacute;connection forc&eacute;e', 'Temps maximal (en secondes) de session, d&eacute;rmine le temps avant la d&eacute;connection forc&eacute;e', ''),
(11, 'RespondBefore', 'int', '15', 'D&eacute;lai de traitement maximum', 'D&eacute;lai de traitement maximum en jours.', ''),
(12, 'MandatorySender', 'bool', '0', 'Exp&eacute;diteur obligatoire', 'Lors de l''attribution des courriers, oblige la d&eacute;finition d''un contact', ''),
(15, 'DefaultPassword', 'text', 'password', 'Mot de passe par d&eacute;faut', 'Mot de passe utilis&eacute; par d&eacute;faut lors de la cr&eacute;atoin d''un compte', ''),
(16, 'DefaultProfile', 'select', '3', 'Profile par d&eacute;faut', 'Profil attribu&eacute; par d&eacute;faut &agrave; un nouvel utilisateur', 'pid|description|SELECT pid,description FROM profiles'),
(17, 'DefaultGroup', 'select', '1', 'Groupe par d&eacute;faut', 'Groupe par d&eacute;faut attribu&eacute; &agrave; un nouvel utilisateur', 'gid|name|SELECT gid,name FROM groups'),
(21, 'Authentication.', 'ListSelect', 'BASE', 'Authentification', 'Systeme d''authentification', 'BASE:Base de donn&eacute;es|LDAP:Serveur Ldap|SMB:Authentification NT/Samba|AD:Active Directory'),
(22, 'IncomingPath', 'text', '/Incoming', 'Chemin d''accueil', 'Chemin o&ugrave; sont sotck&eacute;s les couriers entrants', ''),
(23, 'Autorefresh', 'int', '60', 'Rafraichir apr&egrave;s', 'Rafraichir automatiquement la fen&ecirc;tre', ''),
(24, 'WarningTime', 'int', '5', 'Courrier urgent', 'Nombre de jours &agrave; partir desquels le courrier est not&eacute; urgent (Orange).', ''),
(25, 'ErrorTime', 'int', '1', 'Courrier en retard', 'Nombre de jours &agrave; partir desquels le courrier est consid&eacute;r&eacute; en retard (rouge).', ''),
(26, 'BadDocuments', 'text', '/Bad', 'Chemin documents refus&eacute;s', 'Chemin o&ugrave; sont d&eacute;pos&eacute;s les documents rejet&eacute;s par le Cron', ''),
(27, 'VersionDb', 'ReadOnly', '01.10.00', 'Version de la base de donn&eacute;es', 'Version de la base de donn&eacute;es', ''),
(28, 'VersionEngine', 'ReadOnly', '01.10.00', 'Version du logiciel', 'Version du logiciel', ''),
(29, 'LastUpdate', 'ReadOnly', '01/01/2011', 'Derni&egrave;re mise &agrave; jour', 'Date de la derni&egrave;re mise &agrave; jour', ''),
(30, 'MaxHistory', 'int', '90', 'Nombre de jours', 'Nombre de jours &agrave; afficher dans l''historique', ''),
(31, 'MyAccountEditable', 'bool', '1', 'Editer mon compte', 'L utilisateur a la possibilit&eacute; d &eacute;diter son compte', ''),
(32, 'Raisoc', 'text', '', 'Raison sociale', 'Votre raison sociale', ''),
(33, 'OutputPath', 'text', '/Output', 'Chemin de sortie', 'Emplacement des documents sortants', '');

CREATE TABLE IF NOT EXISTS `profiles` (
  `pid` int(32) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identifiant',
  `description` varchar(30) COLLATE latin1_general_ci NOT NULL DEFAULT 'Pas de Nom' COMMENT 'Libelle',
  `rights` int(11) NOT NULL COMMENT 'Droits binaires',
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Profiles utilisateurs' AUTO_INCREMENT=8 ;

INSERT INTO `profiles` (`pid`, `description`, `rights`) VALUES
(1, 'Configurateur', 15),
(2, 'Administrateur', 7),
(3, 'Utilisateur', 3),
(4, 'Lecteur', 1),
(5, 'Aucun droit', 0),
(6, 'D&eacute;veloppeur', 31),
(7, 'Compte Pop', 0);

CREATE TABLE IF NOT EXISTS `templates` (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL COMMENT 'Nom du template',
  `header` text COMMENT 'Code HTML de l''entete',
  `headershape` varchar(32) NOT NULL COMMENT 'Taille et position du header',
  `sender` text COMMENT 'Code Html du cartouche expéditeur',
  `sendershape` varchar(32) NOT NULL COMMENT 'Taille et position de l''expéditeur',
  `to` text COMMENT 'Code HTML du destinataire',
  `toshape` varchar(32) NOT NULL COMMENT 'Taille et position destinataire',
  `title` text NOT NULL COMMENT 'Titre - LRAR',
  `titleshape` varchar(32) NOT NULL COMMENT 'Taille et position du titre',
  `subject` text NOT NULL COMMENT 'Texte du sujet',
  `subjectshape` varchar(32) NOT NULL COMMENT 'Taille et position du sjuet',
  `content` text COMMENT 'Contenu ',
  `contentshape` varchar(32) NOT NULL COMMENT 'Taille et position du contenu',
  `footer` text NOT NULL COMMENT 'Bas de page',
  `footershape` varchar(32) NOT NULL COMMENT 'Taille et position bas de page',
  `preview` varchar(45) DEFAULT NULL COMMENT 'Image preview',
  PRIMARY KEY (`mid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Modèles de courrier' AUTO_INCREMENT=2 ;

INSERT INTO `templates` (`mid`, `name`, `header`, `headershape`, `sender`, `sendershape`, `to`, `toshape`, `title`, `titleshape`, `subject`, `subjectshape`, `content`, `contentshape`, `footer`, `footershape`, `preview`) VALUES
(1, 'Defaut', '<p style="border-bottom: 1px solid red">#Raisoc#</p>', '0, 0, 10, 10', '<table>\r\n <tr>\r\n  <td><h3>Exp&eacute;diteur</h3></td><td>#Raisoc#</td>\r\n </tr><tr>\r\n  <td></td><td>#address#</td>\r\n </tr><tr>\r\n  <td></td><td>#zip# #city#</td>\r\n </tr>\r\n</table>', '80, 30, 10, 20', '<div style="border: 1px solid red; marging: 7px">\r\nBouygues<br />\r\n1, avenue de Wagram<br />\r\n75016 PARIS\r\n</div>\r\n\r\n', '80, 30, 100, 60', '<p style="font-size: large; text-align: center; font-weight: bold">L.R.A.R.</p>', '0,0,10,90', '<span style="font-weight: bold">Objet</span> &nbsp;&nbsp;#subject#', '0, 0, 10, 100', 'Ceci est un essai', '0, 140, 10, 120', '<p style="border-top: 1px solid red; text-align: right">Date de cr&eacute;ation : #date#</p>', '0, 10, 10, 270', NULL);

CREATE TABLE IF NOT EXISTS `user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant Unique',
  `login` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL COMMENT 'login de l utilisateur',
  `MD5Pass` varchar(32) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT 'ee11cbb19052e40b07aac0ca060c23ee' COMMENT 'Mot de passe cryptage MD5 (user)',
  `pid` int(32) unsigned NOT NULL DEFAULT '2' COMMENT 'identifiant profil',
  `valid` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Utilisateur actif (0/N)',
  `name` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '' COMMENT 'Nom de l utilisateur',
  `given_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '' COMMENT 'Prenom de l utilisateur',
  `genre` varchar(6) NOT NULL,
  `email` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL COMMENT 'Mail (obligatoire)',
  `phone` varchar(16) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '' COMMENT 'Numero de telephone',
  `num` int(11) DEFAULT '0' COMMENT 'Numero de rue',
  `address1` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '' COMMENT 'Ligne d''adresse 1',
  `address2` varchar(64) DEFAULT '' COMMENT 'Ligne d''adresse 2',
  `city` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '' COMMENT 'Localité',
  `zip` varchar(5) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT '' COMMENT 'Code postal',
  `wfsid` int(11) NOT NULL COMMENT 'Etape workflow courrier sortant',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `login` (`login`),
  KEY `user_profile_FK` (`pid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Donnees personnelles de l''utilisateur' AUTO_INCREMENT=2 ;

INSERT INTO `user` (`uid`, `login`, `MD5Pass`, `pid`, `valid`, `name`, `given_name`, `genre`, `email`, `phone`, `num`, `address1`, `address2`, `city`, `zip`, `wfsid`) VALUES
(0, 'Readfiles', 'ee11cbb19052e40b07aac0ca060c23ee', 2, 0, 'Automatique', '', '', '', '', 0, '', '', '', '', 0),
(1, 'Admin', '578117797814c9c4c1d62cf39f5d80ca', 6, 1, 'NOEL', 'Serge', '', 'serge.noel@net6a.com', '06.07.51.68.21', 16, '16, allee Paul Eluard', ' ', 'REZE', '44400', 0);

CREATE TABLE IF NOT EXISTS `wf_details` (
  `wdid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique',
  `wfsid` int(11) NOT NULL COMMENT 'Etape considérée',
  `guid` char(5) NOT NULL COMMENT 'Groupe ou utilisateur',
  `myorder` int(11) NOT NULL COMMENT 'Ordre',
  `col` smallint(6) NOT NULL COMMENT 'Colonne',
  `description` varchar(254) NOT NULL COMMENT 'Visible par...',
  `actor` tinyint(1) DEFAULT NULL COMMENT 'Groupe ou personne qui a le droit de provoquer le passage à l''étape suivante',
  PRIMARY KEY (`wdid`),
  KEY `wfdetails_wfsteps_FK` (`wfsid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Détail du circuit (workflow)' AUTO_INCREMENT=1 ;

INSERT INTO `wf_details` (`wdid`, `wfsid`, `guid`, `myorder`, `col`, `description`, `actor`) VALUES
(1, 1, 'G1', 1, 0, 'D&eacute;faut', 1);

CREATE TABLE IF NOT EXISTS `wf_steps` (
  `wfsid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique',
  `wid` int(11) NOT NULL COMMENT 'Pointe sur workflow',
  `myorder` int(11) NOT NULL COMMENT 'Ordre',
  `description` varchar(128) CHARACTER SET latin1 NOT NULL COMMENT 'Description de l''étape',
  PRIMARY KEY (`wfsid`),
  KEY `wid` (`wid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Etapes du parcours' AUTO_INCREMENT=2 ;

INSERT INTO `wf_steps` (`wfsid`, `wid`, `myorder`, `description`) VALUES
(1, 1, 1, 'D&eacute;faut');

CREATE TABLE IF NOT EXISTS `workflow` (
  `wid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique',
  `name` varchar(64) NOT NULL COMMENT 'Nom du circuit',
  `description` varchar(254) NOT NULL COMMENT 'Description du Workflow',
  `fid` int(11) DEFAULT NULL COMMENT 'Pointe sur dossier virtuel par défaut associé',
  PRIMARY KEY (`wid`),
  UNIQUE KEY `Nom` (`name`),
  KEY `fid` (`fid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Parcours d''un courrier' AUTO_INCREMENT=2 ;

INSERT INTO `workflow` (`wid`, `name`, `description`, `fid`) VALUES
(1, 'A r&eacute;partir', 'Par d&eacute;faut', NULL);

CREATE TABLE IF NOT EXISTS `w_grp` (
  `wid` int(11) NOT NULL COMMENT 'Pointe sur un workflow',
  `gid` int(11) NOT NULL COMMENT 'Pointe sur un groupe',
  PRIMARY KEY (`wid`,`gid`),
  KEY `wid` (`wid`,`gid`),
  KEY `fk_grp_grp` (`gid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Lien entre groupe et workflow';

CREATE TABLE IF NOT EXISTS `_SqlLog` (
  `SL_id` int(11) NOT NULL COMMENT 'Identifiant',
  `SL_Stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date Heure',
  `SL_Data` mediumtext NOT NULL,
  PRIMARY KEY (`SL_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Systeme Backup continu';

CREATE TABLE IF NOT EXISTS `_SqlStructure` (
  `S_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique',
  `S_SQL` longtext NOT NULL COMMENT 'Commande SQL',
  `S_Version` varchar(8) NOT NULL DEFAULT '00.00.00' COMMENT 'Version au format xx.xx.xx en entier',
  `S_Stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date / Heure du changement',
  `S_Comment` mediumtext NOT NULL COMMENT 'Les commentaires',
  PRIMARY KEY (`S_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Table systeme contient les modifications sur la base' AUTO_INCREMENT=1 ;

ALTER TABLE `docfolders`
  ADD CONSTRAINT `docf_doc_FK` FOREIGN KEY (`did`) REFERENCES `documents` (`did`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `docf_folders_FK` FOREIGN KEY (`fid`) REFERENCES `folders` (`fid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `docnote`
  ADD CONSTRAINT `docn_doc_FK` FOREIGN KEY (`did`) REFERENCES `documents` (`did`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `docn_user_KF` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `documents`
  ADD CONSTRAINT `docs_cabinet_FK` FOREIGN KEY (`cabid`) REFERENCES `cabinet` (`cabid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `docs_contact_FK` FOREIGN KEY (`conid`) REFERENCES `contact` (`conid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `docs_wfsteps_FK` FOREIGN KEY (`wfsid`) REFERENCES `wf_steps` (`wfsid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `docview`
  ADD CONSTRAINT `fk_docview_documents1` FOREIGN KEY (`did`) REFERENCES `documents` (`did`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_docview_user` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `g_grp`
  ADD CONSTRAINT `ggrp_groups_FK` FOREIGN KEY (`gid`) REFERENCES `groups` (`gid`),
  ADD CONSTRAINT `ggrp_user_FK` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `user`
  ADD CONSTRAINT `user_profile_FK` FOREIGN KEY (`pid`) REFERENCES `profiles` (`pid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `wf_details`
  ADD CONSTRAINT `wfdetails_wfsteps_FK` FOREIGN KEY (`wfsid`) REFERENCES `wf_steps` (`wfsid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `wf_steps`
  ADD CONSTRAINT `wf_steps_ibfk_1` FOREIGN KEY (`wid`) REFERENCES `workflow` (`wid`);

ALTER TABLE `w_grp`
  ADD CONSTRAINT `w_grp_ibfk_1` FOREIGN KEY (`wid`) REFERENCES `workflow` (`wid`),
  ADD CONSTRAINT `w_grp_ibfk_2` FOREIGN KEY (`gid`) REFERENCES `groups` (`gid`);

