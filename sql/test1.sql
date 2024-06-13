use test1;

ALTER TABLE user ADD CONSTRAINT unique_name UNIQUE (name);

delete from user where id =3;

select * from user;

select * from user where name = 'bbb' and password = 'bbb';

select * from board;

update board set views = views + 1 where id = 1 ;

select count(*) as count from board;

-- 게시글 제목검색
select * from board where title like '%123%';
select count(*) as count from board where title like '%%';
select b.*, u.nickname from board b left join user u on b.write_user_id = u.id where title like '%bb%' order by board_created desc limit 0,5;

-- 게시글 작성자검색
select * from board b left join user u on b.write_user_id = u.id where u.nickname like '%bb%';
select count(*) as count from board b left join user u on b.write_user_id = u.id where u.nickname like '%test%';

select * from board where id = 1;

select * from board b left join user u on b.create_user_id = u.id where b.id = 7;


select b.*, u.name from board b left join user u on b.create_user_id = u.id;

select b.*, u.name from board b left join user u on b.create_user_id = u.id limit 5, 5;

select b.*, u.name from board b left join user u on b.write_user_id = u.id order by board_created desc limit 0, 5;

select a.*
  from (select b.*, u.name 
		  from board b left join user u 
			on b.write_user_id = u.id 
		order by board_created desc) a
limit 10, 5;


select * from reply;

delete from reply where id = 2;

select * 
  from reply r left join board b 
    on r.board_id = b.id left join user u 
    on r.user_id = u.id 
 where b.id = 2;

select r.*, u.nickname from reply r left join board b on r.board_id = b.id left join user u on b.create_user_id = u.id where b.id = 2;


-- 안전모드해제
set sql_safe_updates=0;

delete from board_file;

select * from board_file;



-- 로 그
select * from access_log;

-- 일별 접속로그
SELECT 
    DATE_FORMAT(d.date_range, '%Y-%m-%d') AS log_date,
    COALESCE(COUNT(a.id), 0) AS total_logins
FROM (
    SELECT CURDATE() - INTERVAL (n.n) DAY AS date_range
    FROM (
        SELECT 0 as n UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 
        UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9
		) n
	) d
LEFT JOIN access_log a ON DATE(a.access_time) = d.date_range
GROUP BY d.date_range
ORDER BY d.date_range;
