/* Queries to set up the tables for the web app. */

-- Drop Any previously created tables first in the right order. --

DROP TABLE IF EXISTS internshub_applications;
DROP TABLE IF EXISTS internshub_internships;
DROP TABLE IF EXISTS internshub_users;

-- Users Table --

CREATE TABLE internshub_users(
	userid integer primary key auto_increment,
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
	-- Auto Filled Fields, will be filled in by the application itself. --

	intid integer primary key auto_increment,
	userid integer references internshub_users(userid) on delete cascade on update set null,
	empname text,	-- Employer Name --
	created timestamp,

	-- Fields to be filled in by the employer. --

	title varchar(255) not null default "",
	details text default "",	-- Details of the internship. --
	start_date date not null,
	duration text not null,		-- n Weeks/Months, etc. --
	stipend numeric unsigned not null check(stipend > 0),
	apply_by date not null,
	ninternships integer unsigned not null default 1,
	location text not null,				-- Work From Home / Location --
	skills_required text default ""		-- A comma seperated text with skills required. --
);

-- Applications Table --

CREATE TABLE internshub_applications(
	appid integer primary key auto_increment,
	intid integer references internshub_internships(intid) on delete cascade on update set null,
	userid integer references internshub_users(userid) on delete cascade on update set null,
	created timestamp,
	details text default ""
);