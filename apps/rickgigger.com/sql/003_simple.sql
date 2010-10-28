begin;

alter table entry add column simple boolean;
update entry set simple = 'f';
alter table entry alter column simple set not null;

commit;