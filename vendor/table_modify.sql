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

