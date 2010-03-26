begin;

create table person
(
    id serial primary key,
    username text,
    password text
);

commit;