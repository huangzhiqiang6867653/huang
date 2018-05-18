ALTER TABLE tb_business_function ADD COLUMN parent_id int(11) comment '上级主键';

drop table if exists tb_relation_role_fd;

alter table tb_relation_role_ug comment '用户角色关联表';

create table tb_relation_role_fd
(
   relation_id          int(11) not null auto_increment comment '关联主键',
   role_id              int(11) not null comment '角色主键',
   function_id          int(11) default null comment '功能主键',
   function_detail_id   int(11) default null comment '功能明细主键',
   primary key (relation_id)
)
auto_increment = 1;
alter table tb_relation_role_fd comment '角色权限关联表';

/*==============================================================*/
/* 修改表time为 datetime                                         */
/*==============================================================*/
ALTER TABLE tb_business_user MODIFY COLUMN create_time datetime comment '创建时间';
ALTER TABLE tb_business_user MODIFY COLUMN update_time datetime comment '更新时间';
ALTER TABLE tb_business_user MODIFY COLUMN delete_flag int(11) DEFAULT NULL comment '删除标记(默认为空)';
UPDATE tb_business_user SET delete_flag = NULL;

ALTER TABLE tb_business_dictionary MODIFY COLUMN create_time datetime comment '创建时间';
ALTER TABLE tb_business_dictionary MODIFY COLUMN update_time datetime comment '更新时间';
ALTER TABLE tb_business_dictionary MODIFY COLUMN delete_flag int(11) DEFAULT NULL comment '删除标记(默认为空)';
UPDATE tb_business_dictionary SET delete_flag = NULL;

ALTER TABLE tb_business_dictionary_detail MODIFY COLUMN create_time datetime comment '创建时间';
ALTER TABLE tb_business_dictionary_detail MODIFY COLUMN update_time datetime comment '更新时间';
ALTER TABLE tb_business_dictionary_detail MODIFY COLUMN delete_flag int(11) DEFAULT NULL comment '删除标记(默认为空)';
UPDATE tb_business_dictionary_detail SET delete_flag = NULL;

ALTER TABLE tb_business_function MODIFY COLUMN create_time datetime comment '创建时间';
ALTER TABLE tb_business_function MODIFY COLUMN update_time datetime comment '更新时间';
ALTER TABLE tb_business_function MODIFY COLUMN delete_flag int(11) DEFAULT NULL comment '删除标记(默认为空)';
UPDATE tb_business_function SET delete_flag = NULL;

ALTER TABLE tb_business_function_detail MODIFY COLUMN create_time datetime comment '创建时间';
ALTER TABLE tb_business_function_detail MODIFY COLUMN update_time datetime comment '更新时间';
ALTER TABLE tb_business_function_detail MODIFY COLUMN delete_flag int(11) DEFAULT NULL comment '删除标记(默认为空)';
UPDATE tb_business_function_detail SET delete_flag = NULL;

ALTER TABLE tb_business_group MODIFY COLUMN create_time datetime comment '创建时间';
ALTER TABLE tb_business_group MODIFY COLUMN update_time datetime comment '更新时间';
ALTER TABLE tb_business_group MODIFY COLUMN delete_flag int(11) DEFAULT NULL comment '删除标记(默认为空)';
UPDATE tb_business_group SET delete_flag = NULL;

ALTER TABLE tb_business_organization MODIFY COLUMN create_time datetime comment '创建时间';
ALTER TABLE tb_business_organization MODIFY COLUMN update_time datetime comment '更新时间';
ALTER TABLE tb_business_organization MODIFY COLUMN delete_flag int(11) DEFAULT NULL comment '删除标记(默认为空)';
UPDATE tb_business_organization SET delete_flag = NULL;

ALTER TABLE tb_business_role MODIFY COLUMN create_time datetime comment '创建时间';
ALTER TABLE tb_business_role MODIFY COLUMN update_time datetime comment '更新时间';
ALTER TABLE tb_business_role MODIFY COLUMN delete_flag int(11) DEFAULT NULL comment '删除标记(默认为空)';
UPDATE tb_business_role SET delete_flag = NULL;

