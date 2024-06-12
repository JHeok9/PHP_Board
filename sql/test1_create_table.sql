use test1;
drop table user;
drop table board;
drop table reply;

-- 테이블 생성 SQL - user
CREATE TABLE user
(
    `id`        INT(11)        NOT NULL    AUTO_INCREMENT COMMENT '회원 ID', 
    `name`      VARCHAR(50)    NOT NULL    COMMENT '회원 아이디', 
    `password`  VARCHAR(50)    NOT NULL    COMMENT '회원 비밀번호', 
    `nickname`  VARCHAR(50)    NOT NULL    COMMENT '회원 이름', 
    CONSTRAINT PK_member PRIMARY KEY (id)
);

-- 테이블 Comment 설정 SQL - user
ALTER TABLE user COMMENT '회원';

 
-- 테이블 생성 SQL - board
CREATE TABLE board
(
    `board_id`        INT(11)         NOT NULL    AUTO_INCREMENT COMMENT '게시글 ID', 
    `title`           VARCHAR(255)    NOT NULL    COMMENT '게시글 제목', 
    `content`         TEXT            NULL        COMMENT '게시글 내용', 
    `created`         DATETIME        NOT NULL    COMMENT '작성일', 
    `views`           INT(11)         NOT NULL    COMMENT '조회수', 
    `updated`         DATETIME        NULL        COMMENT '수정일', 
    `create_user_id`  INT(11)         NOT NULL    COMMENT '게시글 작성자', 
    CONSTRAINT PK_board PRIMARY KEY (board_id)
);

-- 테이블 Comment 설정 SQL - board
ALTER TABLE board COMMENT '게시글';

-- Foreign Key 설정 SQL - board(create_user_id) -> user(id)
ALTER TABLE board
    ADD CONSTRAINT FK_board_create_user_id_user_id FOREIGN KEY (create_user_id)
        REFERENCES user (id) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- Foreign Key 삭제 SQL - board(create_user_id)
-- ALTER TABLE board
-- DROP FOREIGN KEY FK_board_create_user_id_user_id;





-- 테이블 생성 SQL - reply
CREATE TABLE reply
(
    `id`              INT(11)     NOT NULL    AUTO_INCREMENT COMMENT '댓글 ID', 
    `member_id`       INT(11)     NOT NULL    COMMENT '회원 ID. 비회원 댓글 가능', 
    `board_id`        INT(11)     NOT NULL    COMMENT '게시글 ID', 
    `is_reply_to_id`  INT(11)     NOT NULL    COMMENT '원본 댓글 아이디', 
    `content`         TEXT        NOT NULL    COMMENT '댓글 내용', 
    `reg_date`        DATETIME    NOT NULL    COMMENT '등록일', 
    CONSTRAINT PK_board_comment PRIMARY KEY (id)
);

-- 테이블 Comment 설정 SQL - reply
ALTER TABLE reply COMMENT '댓글';

-- Foreign Key 설정 SQL - reply(member_id) -> user(id)
ALTER TABLE reply
    ADD CONSTRAINT FK_reply_member_id_user_id FOREIGN KEY (member_id)
        REFERENCES user (id) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- Foreign Key 삭제 SQL - reply(member_id)
-- ALTER TABLE reply
-- DROP FOREIGN KEY FK_reply_member_id_user_id;

-- Foreign Key 설정 SQL - reply(board_id) -> board(board_id)
ALTER TABLE reply
    ADD CONSTRAINT FK_reply_board_id_board_board_id FOREIGN KEY (board_id)
        REFERENCES board (board_id) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- Foreign Key 삭제 SQL - reply(board_id)
-- ALTER TABLE reply
-- DROP FOREIGN KEY FK_reply_board_id_board_board_id;


-- 테이블 생성 SQL - board_file
CREATE TABLE board_file
(
    `file_id`    INT(11)         NOT NULL    AUTO_INCREMENT COMMENT '파일 ID. 회원 아이디', 
    `board_id`   INT(11)         NOT NULL    COMMENT '게시글 ID', 
    `file_name`  VARCHAR(255)    NOT NULL    COMMENT '파일 이름', 
    `reg_date`   DATETIME        NOT NULL    COMMENT '등록일', 
    CONSTRAINT PK_board_file PRIMARY KEY (file_id)
);

-- 테이블 Comment 설정 SQL - board_file
ALTER TABLE board_file COMMENT '회원 상세';

-- Foreign Key 설정 SQL - board_file(board_id) -> board(board_id)
ALTER TABLE board_file
    ADD CONSTRAINT FK_board_file_board_id_board_board_id FOREIGN KEY (board_id)
        REFERENCES board (board_id) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- Foreign Key 삭제 SQL - board_file(board_id)
-- ALTER TABLE board_file
-- DROP FOREIGN KEY FK_board_file_board_id_board_board_id;