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