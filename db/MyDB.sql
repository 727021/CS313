-- Remove old tables in the public schema if they still exist
DROP TABLE IF EXISTS Question;
DROP TABLE IF EXISTS Page;
DROP TABLE IF EXISTS Response;
DROP TABLE IF EXISTS Survey;
DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS Common_Lookup;

-- Drop everything
DROP SCHEMA IF EXISTS surveys CASCADE;

CREATE SCHEMA surveys

-- This table will contain values for things like survey status and user type.
CREATE TABLE common_lookup
( common_lookup_id	SERIAL		NOT NULL PRIMARY KEY
, context 			VARCHAR(30) NOT NULL -- 'TABLE.COLUMN'
, value 			VARCHAR(30) NOT NULL)

CREATE TABLE users
( user_id 	SERIAL 			NOT NULL PRIMARY KEY
, username 	VARCHAR(30) 	NOT NULL UNIQUE
, email 	VARCHAR(255) 	NOT NULL UNIQUE
, first 	VARCHAR(30) 	NOT NULL
, middle 	VARCHAR(30)
, last 		VARCHAR(30) 	NOT NULL
, hash		VARCHAR(255) 	NOT NULL -- Generated in php with hash_password()
, type 		INT 			NOT NULL REFERENCES common_lookup(common_lookup_id))

CREATE TABLE survey
( survey_id SERIAL 		NOT NULL PRIMARY KEY
, title 	VARCHAR(30)
, user_id	INT 		NOT NULL REFERENCES users(user_id)
, status 	INT 		NOT NULL REFERENCES common_lookup(common_lookup_id))

CREATE TABLE page
( page_id 		SERIAL 	NOT NULL PRIMARY KEY
, survey_id 	INT 	NOT NULL REFERENCES survey(survey_id)
, page_index 	INT 	NOT NULL)

CREATE TABLE question
( question_id 	SERIAL 	NOT NULL PRIMARY KEY
, page_id 		INT 	NOT NULL REFERENCES page(page_id)
, content 		TEXT 	NOT NULL)

CREATE TABLE response
( response_id 	SERIAL 		NOT NULL PRIMARY KEY
, survey_id 	INT 		NOT NULL REFERENCES survey(survey_id)
, ip_address 	VARCHAR(45)
, response_data TEXT 		NOT NULL
, responded_on 	TIMESTAMP 	NOT NULL DEFAULT NOW())

CREATE TABLE shortcode -- For survey URLs
( shortcode_id 	INT 		NOT NULL PRIMARY KEY
, survey_id 	INT 		NOT NULL REFERENCES survey(survey_id)
, code 			VARCHAR(16) NOT NULL) -- Generated in php with md5(uniqid($survey['id'] . $survey['title']), true)

-- Create a view for easy access to user info
CREATE VIEW User_Info AS
	SELECT
	  u.user_id AS id
	, u.last || ', ' || u.first AS name
	, u.username
	, u.email
	, cl.value as type
	FROM Users u
	INNER JOIN Common_Lookup cl
	ON cl.common_lookup_id = u.type;