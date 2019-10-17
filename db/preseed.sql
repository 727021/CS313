INSERT INTO surveys.Common_Lookup (context,value)
VALUES ('USER.TYPE','DEFAULT');

INSERT INTO surveys.Common_Lookup (context,value)
VALUES ('USER.TYPE','ADMIN');

INSERT INTO surveys.Common_Lookup (context,value)
VALUES ('SURVEY.STATUS','UNPUBLISHED');

INSERT INTO surveys.Common_Lookup (context,value)
VALUES ('SURVEY.STATUS','PUBLISHED');

INSERT INTO surveys.Common_Lookup (context,value)
VALUES ('SURVEY.STATUS','CLOSED');

-- Insert a test user account
INSERT INTO surveys.Users (username,email,first,last,hash,type) VALUES
( 'testuser'
, 'email@example.com'
, 'Test'
, 'User'
, '$2y$10$iwpymfrQaZ3W2vEMw0nG9u872zUSLoJHuVeFeXN.LMUrSCS7D3Cve' -- 'password'
, (SELECT common_lookup_id FROM surveys.Common_Lookup WHERE context = 'USER.TYPE' AND value = 'DEFAULT')
);

-- Insert test surveys
INSERT INTO surveys.Survey (title,user_id,status) VALUES
( 'Test Survey'
, (SELECT user_id FROM surveys.users WHERE username = 'testuser')
, (SELECT common_lookup_id FROM surveys.common_lookup
   WHERE context = 'SURVEY.STATUS' AND value = 'UNPUBLISHED')
);

INSERT INTO surveys.Survey (title,user_id,status) VALUES
( 'Test Survey 2'
, (SELECT user_id FROM surveys.users WHERE username = 'testuser')
, (SELECT common_lookup_id FROM surveys.common_lookup
   WHERE context = 'SURVEY.STATUS' AND value = 'PUBLISHED')
);

INSERT INTO surveys.Survey (title,user_id,status) VALUES
( 'Test Survey 3'
, (SELECT user_id FROM surveys.users WHERE username = 'testuser')
, (SELECT common_lookup_id FROM surveys.common_lookup
   WHERE context = 'SURVEY.STATUS' AND value = 'CLOSED')
);

INSERT INTO surveys.shortcode (survey_id,code) VALUES
( (SELECT survey_id FROM surveys.survey WHERE title = 'Test Survey')
, '69b683f14e9fd6e78c72555e3d1ab295'
);

INSERT INTO surveys.shortcode (survey_id,code) VALUES
( (SELECT survey_id FROM surveys.survey WHERE title = 'Test Survey 2')
, '9fab7e1dfffe3643e9372baf9c63a0a1'
);

INSERT INTO surveys.shortcode (survey_id,code) VALUES
( (SELECT survey_id FROM surveys.survey WHERE title = 'Test Survey 3')
, '5d226163de4546078f778f8367e97bdc'
);