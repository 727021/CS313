-- This table will contain values for things like survey status and user type.
CREATE TABLE Common_Lookup (
	common_lookup_id SERIAL PRIMARY KEY,
	context VARCHAR(30) NOT NULL, -- TABLE.COLUMN
	value VARCHAR(30) NOT NULL
);

CREATE TABLE Users (
	user_id SERIAL PRIMARY KEY,
	username VARCHAR(30) NOT NULL UNIQUE,
	email VARCHAR(255) NOT NULL UNIQUE,
	first VARCHAR(30) NOT NULL,
	middle VARCHAR(30),
	last VARCHAR(30) NOT NULL,
	hash VARCHAR(255) NOT NULL,
	type INT NOT NULL REFERENCES Common_Lookup(common_lookup_id)
);

CREATE TABLE Survey (
	survey_id SERIAL PRIMARY KEY,
	title VARCHAR(30),
	user_id INT NOT NULL REFERENCES Users(user_id),
	status INT NOT NULL REFERENCES Common_Lookup(common_lookup_id)
);

CREATE TABLE Page (
	page_id SERIAL PRIMARY KEY,
	survey_id INT NOT NULL REFERENCES Survey(survey_id)
);

CREATE TABLE Question (
	question_id SERIAL PRIMARY KEY,
	page_id INT NOT NULL REFERENCES Page(page_id),
	content TEXT NOT NULL
);

CREATE TABLE Response (
	response_id SERIAL PRIMARY KEY,
	survey_id INT NOT NULL REFERENCES Survey(survey_id),
	ip_address VARCHAR(45),
	response_data TEXT NOT NULL,
	responded_on TIMESTAMP NOT NULL DEFAULT NOW()
);