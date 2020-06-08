create user 'RUnDa_Common_DB_User'@'rundacommondatabase' identified by 'RUnDa_Common_Pass';

grant all PRIVILEGES ON runda_common_test.* TO 'RUnDa_Common_DB_User'@'rundacommondatabase';

FLUSH privileges;

create database runda_common_live;
create database runda_common_test;

use runda_common_live;

create table subscriptions(
      ID integer primary key auto_increment,
      email varchar(64) unique not null,
      date_created datetime not null,
      date_last_sent datetime not null
);

use runda_common_test;

create table subscriptions(
    ID integer primary key auto_increment,
    email varchar(64) unique not null,
    date_created datetime not null,
    date_last_sent datetime not null
);