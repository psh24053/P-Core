CREATE DATABASE `panphp`CHARACTER SET utf8 COLLATE utf8_general_ci; 
GRANT ALL PRIVILEGES ON panphp.* TO panphp@localhost IDENTIFIED BY 'panphp';

USE `panphp`;

/*==============================================================*/
/* Table: my_files                                              */
/*==============================================================*/
CREATE TABLE pan_files
(
   file_id              VARCHAR(32) NOT NULL,
   file_name            VARCHAR(128),
   file_mime            VARCHAR(128),
   file_size            BIGINT(64),
   createtime           BIGINT(20),
   PRIMARY KEY (file_id)
);