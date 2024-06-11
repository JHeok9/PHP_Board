use test1;

show tables;

create table user(
	id int(11) not null auto_increment primary key,
    name varchar(50) not null unique,
    password varchar(50) not null,
    nickname varchar(50) not null
    );

commit;
select * from user;

select * from user where name = 'bbb' and password = 'bbb';

create table board(
	id int(11) not null auto_increment primary key,
    title varchar(255) not null ,
    content text not null,
    created datetime not null,
    create_user_id int(11) not null
);

select * from board;

select count(*) as count from board;

select * from board where id = 1;

select * from board b left join user u on b.create_user_id = u.id where b.id = 7;

select b.*, u.name from board b left join user u on b.create_user_id = u.id;

select b.*, u.name from board b left join user u on b.create_user_id = u.id limit 5, 5;

create table reply(
	id int(11) not null auto_increment primary key,
    reply_content text not null,
    created datetime not null,
    board_id int(11) not null,
    user_id int(11) not null
);

select * from reply;

delete from reply where id = 2;

select * 
  from reply r left join board b 
    on r.board_id = b.id left join user u 
    on r.user_id = u.id 
 where b.id = 2;

select r.*, u.nickname from reply r left join board b on r.board_id = b.id left join user u on b.create_user_id = u.id where b.id = 2;
