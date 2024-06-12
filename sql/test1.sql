use test1;

select * from user;

select * from user where name = 'bbb' and password = 'bbb';

select * from board;

select count(*) as count from board;

select * from board where id = 1;

select * from board b left join user u on b.create_user_id = u.id where b.id = 7;

select b.*, u.name from board b left join user u on b.create_user_id = u.id;

select b.*, u.name from board b left join user u on b.create_user_id = u.id limit 5, 5;

select * from reply;

delete from reply where id = 2;

select * 
  from reply r left join board b 
    on r.board_id = b.id left join user u 
    on r.user_id = u.id 
 where b.id = 2;

select r.*, u.nickname from reply r left join board b on r.board_id = b.id left join user u on b.create_user_id = u.id where b.id = 2;

