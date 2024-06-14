use test1;
-- 안전모드해제
set sql_safe_updates=0;

ALTER TABLE user ADD CONSTRAINT unique_name UNIQUE (name);

delete from user where id =3;

-- 유저 테이블 
select * from user;

select * from user where name = 'bbb' and password = 'bbb';


-- 회원 테이블
select * from board;

update board set views = views + 1 where id = 1 ;

select count(*) as count from board;

-- 게시글 제목검색
select * from board where title like '%123%';
select count(*) as count from board where title like '%%';
select b.*, u.nickname from board b left join user u on b.write_user_id = u.id where title like '%bb%' order by board_created desc limit 0,5;

-- 게시글 작성자검색
select count(*) as count from board b left join user u on b.write_user_id = u.id where u.nickname like '%test%';
select b.*, u.nickname from board b left join user u on b.write_user_id = u.id where u.nickname like '%test%' order by board_created desc limit 0,5;

-- 게시글 전체검색
select b.*, u.name from board b left join user u on b.write_user_id = u.id order by board_created desc limit 0, 5;



-- 댓글
select * from reply;

select * 
  from reply r left join board b 
    on r.board_id = b.id left join user u 
    on r.reply_user_id = u.id 
 where b.id = 1;

select r.*, u.nickname from reply r left join board b on r.board_id = b.id left join user u on b.create_user_id = u.id where b.id = 2;



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


-- 로그인 로그
select * from login_log;

select * from event_log;