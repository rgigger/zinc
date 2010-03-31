begin;

create table entry
(
    id integer primary key,
    name text not null,
    title text not null,
    published_date timestamp with time zone,
    link text,
    link_text text
);

commit;