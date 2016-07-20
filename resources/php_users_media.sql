drop database if exists php_users_media;
create database php_users_media charset utf8;
use php_users_media;

/* user roles */

create table roles(
role_id int not null primary key auto_increment,
name varchar(50) not null
);

insert into roles (name) values
('administator'), ('user');

/* user table -> access roles */

create table users(
user_id int not null primary key auto_increment,
role int not null default 2,
name varchar(50) not null,
email varchar(50) not null,
password varchar(100) not null
);

/* create unique index for e-mail */

create unique index ui1 on users(email);

/* add foreign key to role */

alter table users add foreign key (role) references roles(role_id);

/* insert default admin user -> password is md5 encripted version of "pass11" */

insert into users (role, name, email, password) values
(1, 'Damir', 'luketic.damir@gmail.com', '0102812fbd5f73aa18aa0bae2cd8f79f');

/* table for media format */

create table media(
media_id int not null primary key auto_increment,
name varchar(50) not null
);

/* unique index for media name */

create unique index ui2 on media(name);

/* insert defaul value */

insert into media(name) values
('CD'), ('DVD'), ('Blu-ray');

/* table for categories */

create table categories(
category_id int not null primary key auto_increment,
name varchar(50) not null
); 

/* unique index for name */

create unique index ui3 on categories(name);

/* Default values */

insert into categories(name) values
('Music'), ('Movie');


/* create table for products */

create table products(
product_id int not null primary key auto_increment,
category int not null,
media int not null,
active boolean not null default 1,
title varchar(50) not null,
details varchar(250),
release_date date
);

/* add foreign key for products */

alter table products add foreign key (media) references media(media_id);
alter table products add foreign key (category) references categories(category_id);

/* default value for products */

insert into products(category, media, title) values
(1, 1, 'Judas Priest - British Steel'),
(1, 1, 'Judas Priest - Painkiller'),
(1, 1, 'Judas Priest - Angel of Retribution'),
(1, 1, 'WASP - The Last Command'),
(1, 3, 'WASP - Dying for the World'),
(1, 1, 'WASP - Dominator'),
(1, 1, 'WASP - Babylon'),
(1, 1, 'Queensrÿche - The Warning'),
(1, 1, 'Queensrÿche - Rage for Order'),
(1, 1, 'Queensrÿche - Operation: Mindcrime'),
(1, 1, 'Queensrÿche - Empire'),
(1, 2, 'Queensrÿche - Promised Land'),
(2, 2, 'A History of Violence'),
(2, 2, 'Eastern Promises'),
(2, 2, 'The Road'),
(2, 3, 'The Book of Eli'),
(2, 3, 'Man on Fire');

/* pivot table for users product */

create table equipment(
user_id int not null,
product_id int not null
);

/* foreign key for pivot table */

alter table equipment add foreign key (user_id) references users(user_id);
alter table equipment add foreign key (product_id) references products(product_id);

/* default data for pivot table */

insert into equipment(user_id, product_id) values
(1,1),(1,2),(1,3),(1,4),(1,5),
(1,6),(1,7),(1,8),(1,9),(1,10),(1,11); 













