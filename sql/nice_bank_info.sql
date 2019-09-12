-- czz 2019-09-12
-- 银行信息
DROP TABLE IF EXISTS public.nice_bank_info;
DROP SEQUENCE IF EXISTS public.nice_bank_info_id_seq;

CREATE SEQUENCE nice_bank_info_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

CREATE TABLE nice_bank_info(
    id INTEGER NOT NULL DEFAULT nextval('nice_bank_info_id_seq'::regclass),
    bank_no VARCHAR(50) DEFAULT '' NOT NULL,
    bank_name VARCHAR(100) DEFAULT '' NOT NULL,
    mobile VARCHAR(30) DEFAULT '' NOT NULL,
    zip_code VARCHAR(30) DEFAULT '' NOT NULL,
    address text,
    wwift_code VARCHAR(30) DEFAULT '' NOT NULL,
    cuid int4 DEFAULT 0 NOT NULL,
    ctime int4 DEFAULT 0 NOT NULL,
    muid int4 DEFAULT 0 NOT NULL,
    mtime int4 DEFAULT 0 NOT NULL
);

COMMENT ON TABLE "public"."nice_bank_info" IS '银行信息';
COMMENT ON COLUMN "public"."nice_bank_info"."id" IS 'id';
COMMENT ON COLUMN "public"."nice_bank_info"."bank_no" IS '行号';
COMMENT ON COLUMN "public"."nice_bank_info"."bank_name" IS '名称';
COMMENT ON COLUMN "public"."nice_bank_info"."mobile" IS '电话';
COMMENT ON COLUMN "public"."nice_bank_info"."zip_code" IS '邮编';
COMMENT ON COLUMN "public"."nice_bank_info"."address" IS '地址';
COMMENT ON COLUMN "public"."nice_bank_info"."wwift_code" IS 'WWIFT CODE';
COMMENT ON COLUMN "public"."nice_bank_info"."ctime" IS '创建时间';
COMMENT ON COLUMN "public"."nice_bank_info"."cuid" IS '创建者';
COMMENT ON COLUMN "public"."nice_bank_info"."mtime" IS '修改时间';
COMMENT ON COLUMN "public"."nice_bank_info"."muid" IS '修改者';

ALTER TABLE ONLY nice_bank_info ADD CONSTRAINT nice_bank_info_pkey PRIMARY KEY (id);
