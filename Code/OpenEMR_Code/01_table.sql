CREATE TABLE IF NOT EXISTS `form_covid_testing` (
id bigint(20) NOT NULL auto_increment,
date datetime default NULL,
pid bigint(20) default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,
test_status varchar(255),
test_notes longtext,
doctor varchar(255),
date_of_signature datetime default NULL,
procedure_code varchar(255),
PRIMARY KEY (id)
) ENGINE=InnoDB;