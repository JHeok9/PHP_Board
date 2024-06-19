use test1;
-- 안전모드해제
set sql_safe_updates=0;

ALTER TABLE user ADD CONSTRAINT unique_name UNIQUE (name);

delete from user where id =3;

-- 유저 테이블 
select * from user;

select * from user where name = 'bbb' and password = 'bbb';


-- 회원 테이블



-- 게시판
select * from board order by board_created desc;
select * from board_file;
delete from board where id = 52;

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
select * from access_log order by access_time desc;

SELECT * 
FROM access_log 
WHERE access_time >= '2024-06-17 16:32:00';

delete from access_log where access_time >= '2024-06-17 16:32:00';
commit;

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


-- login_log 컬럼이름 변경
ALTER TABLE login_log CHANGE login_id user_id int(11) NOT NULL COMMENT '로그인 유저 id';

describe login_log;


-- 이벤트로그
select t.*, u.name, u.nickname from event_log t left join user u on t.user_id = u.id order by t.event_time limit 0,5 ;



-- access_log 테이블의 access_time을 log_time으로 변경
ALTER TABLE access_log CHANGE access_time log_time DATETIME NOT NULL COMMENT '로그 시간';

-- login_log 테이블의 login_time을 log_time으로 변경
ALTER TABLE login_log CHANGE login_time log_time DATETIME NOT NULL COMMENT '로그 시간';

-- event_log 테이블의 event_time을 log_time으로 변경
ALTER TABLE event_log CHANGE event_time log_time DATETIME NOT NULL COMMENT '로그 시간';
