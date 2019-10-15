create table conferences (conference_id SERIAL primary key, month int NOT NULL, 
                        year int NOT NULL);

create table users (user_id SERIAL primary key, name varchar(15) NOT NULL, 
                    password varchar(255) NOT NULL);

create table speakers (speaker_id SERIAL primary key, name varchar(50) NOT NULL);

create table session (session_id SERIAL primary key, conference_id int references conferences(conference_id) NOT NULL,
                        day int NOT NULL, time int NOT NULL);

create table notes (note_id SERIAL primary key, speaker int references speakers(speaker_id) NOT NULL,
                    session int references session(session_id) NOT NULL,
                    author int references users(user_id) NOT NULL,
                    content text);

INSERT into conferences (month, year) VALUES (10, 2019);
INSERT into session (conference_id, day, time) VALUES (
    (SELECT conference_id FROM conferences WHERE month = 10 AND year = 2019),
    0,
    1
);
INSERT into speakers (name) VALUES ('David A. Bednar');
INSERT into speakers (name) VALUES ('Russell M. Nelson');
INSERT into speakers (name) VALUES ('Quentin L. Cook');

INSERT into users (name, password) VALUES ('Jimmy', 'password');

INSERT into notes (speaker, session, author, content) VALUES (
    (SELECT speaker_id FROM speakers WHERE name = 'David A. Bednar'),
    (SELECT session_id FROM session WHERE day = 0 AND time = 1 AND conference_id = 
    (SELECT conference_id FROM conferences WHERE month = 10 AND year = 2019)),
    (SELECT user_id FROM users WHERE name = 'Jimmy'),
    'The church is true'
);

INSERT into notes (speaker, session, author, content) VALUES (
    (SELECT speaker_id FROM speakers WHERE name = 'David A. Bednar'),
    (SELECT session_id FROM session WHERE day = 0 AND time = 1 AND conference_id = 
    (SELECT conference_id FROM conferences WHERE month = 10 AND year = 2019)),
    (SELECT user_id FROM users WHERE name = 'Jimmy'),
    'The church is cool'
);

INSERT into notes (speaker, session, author, content) VALUES (
    (SELECT speaker_id FROM speakers WHERE name = 'Russell M. Nelson'),
    (SELECT session_id FROM session WHERE day = 0 AND time = 1 AND conference_id = 
    (SELECT conference_id FROM conferences WHERE month = 10 AND year = 2019)),
    (SELECT user_id FROM users WHERE name = 'Jimmy'),
    'The church is true'
);

INSERT into notes (speaker, session, author, content) VALUES (
    (SELECT speaker_id FROM speakers WHERE name = 'Russell M. Nelson'),
    (SELECT session_id FROM session WHERE day = 0 AND time = 1 AND conference_id = 
    (SELECT conference_id FROM conferences WHERE month = 10 AND year = 2019)),
    (SELECT user_id FROM users WHERE name = 'Jimmy'),
    'The church is'
);

INSERT into notes (speaker, session, author, content) VALUES (
    (SELECT speaker_id FROM speakers WHERE name = 'Quentin L. Cook'),
    (SELECT session_id FROM session WHERE day = 0 AND time = 1 AND conference_id = 
    (SELECT conference_id FROM conferences WHERE month = 10 AND year = 2019)),
    (SELECT user_id FROM users WHERE name = 'Jimmy'),
    'The church is true'
);

INSERT into notes (speaker, session, author, content) VALUES (
    (SELECT speaker_id FROM speakers WHERE name = 'Quentin L. Cook'),
    (SELECT session_id FROM session WHERE day = 0 AND time = 1 AND conference_id = 
    (SELECT conference_id FROM conferences WHERE month = 10 AND year = 2019)),
    (SELECT user_id FROM users WHERE name = 'Jimmy'),
    'The gospel'
);

SELECT content FROM notes WHERE speaker = (SELECT speaker_id FROM speakers WHERE name = 'Quentin L. Cook') AND
    session = (SELECT session_id FROM session WHERE day = 0 AND time = 1 AND conference_id = 
    (SELECT conference_id FROM conferences WHERE month = 10 AND year = 2019));