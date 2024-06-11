insert into testTable (name) values('aaa');
insert into testTable (name) values('bbb');
insert into testTable (name) values('ccc');
insert into testTable (name) values('ddd');

commit;

show databases;
use test;

create table topic(
	id int(11) not null auto_increment,
    title varchar(45) not null,
	description text,
    created  datetime not null,
    primary key(id)
) engine=InnoDB;

commit;



select * from topic;

-- 안전모드해제
set sql_safe_updates=0;
delete from topic;

create table author(
	id int(11) not null auto_increment,
    name varchar(30) not null,
    profile varchar(200) null,
    primary key(id)
);

desc author;

commit;

insert into author (name, profile) values ('eoging', 'developer');
insert into author (name, profile) values ('duru', 'DBA');
insert into author (name, profile) values ('taeho', 'Data scientist');

select * from author;

select * from topic;

alter table topic add column author_id int(11);

desc topic;

update topic set author_id = 1 where id = 9;
update topic set author_id = 2 where id = 10;
update topic set author_id = 2 where id = 11;
update topic set author_id = 3 where id = 12;

select * from topic t left join author a on t.author_id = a.id;