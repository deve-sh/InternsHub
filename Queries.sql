/* Queries to set up the tables for the web app. */

-- Drop Any previously created tables first in the right order. --

DROP TABLE IF EXISTS internshub_applications;
DROP TABLE IF EXISTS internshub_internships;
DROP TABLE IF EXISTS internshub_users;

-- Users Table --

CREATE TABLE internshub_users(
	userid integer primary key auto_increment,
	username varchar(255) unique not null,
	name text not null,
	email varchar(255) unique not null,
	password varchar(255) not null,
	phone varchar(25) not null,
	isemployer boolean default 0,
	joined date not null,
	skills text default ""
);

-- Internships Table --

CREATE TABLE internshub_internships(
	intid integer primary key auto_increment,
	userid integer references internshub_users(userid) on delete cascade on update set null,
	title varchar(255) not null default "",
	details text default "",
	created timestamp,
	start_date date not null,
	stipend numeric not null,
	category text not null,
	type text,	-- Work from home / Part Time / Full Time --
	skills_required text default ""
);

-- Applications Table --

CREATE TABLE internshub_applications(
	appid integer primary key auto_increment,
	intid integer references internshub_internships(intid) on delete cascade on update set null,
	userid integer references internshub_users(userid) on delete cascade on update set null,
	created timestamp,
	details text default ""
);