INSERT INTO surveys.Common_Lookup (context,value) VALUES
 ('USER.TYPE','DEFAULT')
,('USER.TYPE','ADMIN')
,('SURVEY.STATUS','UNPUBLISHED')
,('SURVEY.STATUS','PUBLISHED')
,('SURVEY.STATUS','CLOSED');

-- Insert a test user account
INSERT INTO surveys.Users (username,email,first,last,hash,type) VALUES
( 'testuser'
, 'email@example.com'
, 'Test'
, 'User'
, '$2y$10$iwpymfrQaZ3W2vEMw0nG9u872zUSLoJHuVeFeXN.LMUrSCS7D3Cve' -- 'password'
, (SELECT common_lookup_id FROM surveys.Common_Lookup WHERE context = 'USER.TYPE' AND value = 'DEFAULT')
);

-- Test Survey
INSERT INTO surveys.Survey (title,user_id,status) VALUES
( 'Test Survey'
, currval('surveys.users_user_id_seq')
, (SELECT common_lookup_id FROM surveys.common_lookup
   WHERE context = 'SURVEY.STATUS' AND value = 'UNPUBLISHED')
);

INSERT INTO surveys.page (survey_id,page_index) VALUES
( currval('surveys.users_user_id_seq')
, 1
);

INSERT INTO surveys.question (page_id,content) VALUES
  ( currval('surveys.page_page_id_seq')
  , '{"type":0, "content":{"content":"What is your name?","placeholder":"Name","multiline":false,"required":true}}')
, ( currval('surveys.page_page_id_seq')
  , '{"type":1, "content":{"content":"What is your favorite color?","choices":["Red","Blue","Green"],"radio":true,"required":true}}')
, ( currval('surveys.page_page_id_seq')
  , '{"type":2, "content":{"content":"Choose some:","choices":["1","2","3","4","5"],"multiple":true,"required":false}}')
, ( currval('surveys.page_page_id_seq')
  , '{"type":3, "content":{"content":"Rate this site:","start":1.0,"end":10.0,"interval":1.0,"required":true}}');

-- Test Survey 2
INSERT INTO surveys.Survey (title,user_id,status) VALUES
( 'Test Survey 2'
, currval('surveys.users_user_id_seq')
, (SELECT common_lookup_id FROM surveys.common_lookup
   WHERE context = 'SURVEY.STATUS' AND value = 'PUBLISHED')
);

INSERT INTO surveys.shortcode (survey_id,code) VALUES
( currval('surveys.survey_survey_id_seq')
, '9fab7e1dfffe3643e9372baf9c63a0a1'
);

INSERT INTO surveys.page (survey_id,page_index) VALUES
( currval('surveys.survey_survey_id_seq')
, 1
);

INSERT INTO surveys.question (page_id,content) VALUES
  ( currval('surveys.page_page_id_seq')
  , '{"type":0, "content":{"content":"What is your name?","placeholder":"Name","multiline":false,"required":true}}')
, ( currval('surveys.page_page_id_seq')
  , '{"type":0, "content":{"content":"Enter any comments:","placeholder":"Comments","multiline":true,"required":false}}');

INSERT INTO surveys.page (survey_id,page_index) VALUES
( currval('surveys.survey_survey_id_seq')
, 2
);

INSERT INTO surveys.question (page_id,content) VALUES
  ( currval('surveys.page_page_id_seq')
  , '{"type":1, "content":{"content":"What are your favorite colors?","choices":["Red","Blue","Green"],"radio":false,"required":true}}')
, ( currval('surveys.page_page_id_seq')
  , '{"type":2, "content":{"content":"Choose one:","choices":["1","2","3","4","5"],"multiple":false,"required":false}}');

-- Test Survey 3
INSERT INTO surveys.Survey (title,user_id,status) VALUES
( 'Test Survey 3'
, currval('surveys.users_user_id_seq')
, (SELECT common_lookup_id FROM surveys.common_lookup
   WHERE context = 'SURVEY.STATUS' AND value = 'CLOSED')
);

-- Responses for 'Test Survey 3'
INSERT INTO surveys.response (survey_id,response_data) VALUES
  ( currval('surveys.survey_survey_id_seq')
  , '[{"qid":5,"answer":"Andrew"},{"qid":6,"answer":"This is test data and this is a test comment."},{"qid":7,"answer":["Blue","Green"]},{"qid":8,"answer":["4"]}]')
, ( currval('surveys.survey_survey_id_seq')
  , '[{"qid":5,"answer":"John Doe"},{"qid":6,"answer":"This is test more data and this is another test comment."},{"qid":7,"answer":["Red"]},{"qid":8,"answer":["2"]}]');