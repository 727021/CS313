INSERT INTO Common_Lookup (context,value)
VALUES ('USER.TYPE','DEFAULT');

INSERT INTO Common_Lookup (context,value)
VALUES ('USER.TYPE','ADMIN');

INSERT INTO Common_Lookup (context,value)
VALUES ('SURVEY.STATUS','UNPUBLISHED');

INSERT INTO Common_Lookup (context,value)
VALUES ('SURVEY.STATUS','PUBLISHED');

INSERT INTO Common_Lookup (context,value)
VALUES ('SURVEY.STATUS','CLOSED');

-- Insert a test user account
INSERT INTO Users (username,email,first,last,hash,type) VALUES
( 'testuser'
, 'email@example.com'
, 'Test'
, 'User'
, '$2y$10$iwpymfrQaZ3W2vEMw0nG9u872zUSLoJHuVeFeXN.LMUrSCS7D3Cve' -- 'password'
, (SELECT common_lookup_id FROM Common_Lookup WHERE context = 'USER.TYPE' AND value = 'DEFAULT')
);