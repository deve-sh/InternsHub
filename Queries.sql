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
	skills text
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
	details text,	-- Details of the internship. --
	start_date date not null,
	duration text not null,		-- n Weeks/Months, etc. --
	stipend numeric unsigned not null check(stipend >= 0),
	apply_by date not null,
	ninternships integer unsigned not null default 1,
	location text not null,				-- Work From Home / Location --
	skills_required text		-- A comma seperated text with skills required. --
);

-- Applications Table --

CREATE TABLE internshub_applications(
	appid integer primary key auto_increment,
	employerid integer references internshub_users(userid) on delete cascade on update set null,
	intid integer references internshub_internships(intid) on delete cascade on update set null,
	applicantid integer references internshub_users(userid) on delete cascade on update set null,
	created timestamp,
	
	details text
	-- approved boolean default 0--
);

/*
	The following is test data you may need if you do not want to manually register users.
	Just uncomment the following and run the entire query file.
*/


/*
-- Creating a student. --

INSERT INTO internshub_users(
	name,
	email,
	password,
	phone,
	isemployer,
	joined,
	skills
) VALUES(
	'Student',
	'student@student.com',
	'$2y$10$OdVAgCBLso0oce935xMHluMcxCTgJHLhTlPgyuY1IPCszL58G0.SC',		-- This is a hash for 'password' --
	'+91-1234567890',
	0,
	'2019-09-04',
	'HTML, CSS, JS, PHP'
);

-- Creating an employer --

INSERT INTO internshub_users(
	name,
	email,
	password,
	phone,
	isemployer,
	joined,
	skills
) VALUES(
	'Employer',
	'employer@employer.com',
	'$2y$10$OdVAgCBLso0oce935xMHluMcxCTgJHLhTlPgyuY1IPCszL58G0.SC',		-- This is a hash for 'password' --
	'+91-2345678901',
	1,
	'2019-09-04',
	''	-- Employer does not need to have any values in the skills column. --
);

-- Creating an internship --

INSERT INTO internshub_internships(
	userid,
	empname,
	title,
	details,
	start_date,
	duration,
	stipend,
	apply_by,
	ninternships,
	location,
	skills_required
)
VALUES(
	2,
	'Employer',
	'Web Development Internship',
	"Those who are good at web development and have a sound knowledge of concepts of PHP and JS may apply.

	Students are expected to devote a minimum of 2 hours each day to the Internship.",
	'2019-12-12',
	'2 Month(s)',
	10000,
	'2019-12-5',
	3,
	'Work From Home',
	'PHP, JS, HTML, CSS'
);

-- Creating an application for the above internship --

INSERT INTO internshub_applications(
	employerid,
	applicantid,
	intid,
	details
)
VALUES(
	2,
	1,
	1,
	"I am a hard worker and proficient in Web Development."
);
*/