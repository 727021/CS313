create table conferences (conference_id SERIAL primary key, month int NOT NULL, 
                        year int NOT NULL);

create table users (user_id SERIAL primary key, name varchar(15) NOT NULL, 
                    password varchar(255) NOT NULL);

create table speakers (speaker_id SERIAL primary key, name varchar(50) NOT NULL);

create table notes (note_id SERIAL primary key, speaker int references speakers(speaker_id) NOT NULL,
                    conference int references conferences(conference_id) NOT NULL,
                    author int references users(user_id) NOT NULL,
                    content text);