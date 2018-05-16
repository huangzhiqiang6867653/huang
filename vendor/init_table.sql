/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     2018/5/14 05:40:35                           */
/*==============================================================*/


drop table if exists tb_business_dictionary;

drop table if exists tb_business_dictionary_detail;

drop table if exists tb_business_function;

drop table if exists tb_business_function_detail;

drop table if exists tb_business_group;

drop table if exists tb_business_organization;

drop table if exists tb_business_role;

drop table if exists tb_business_user;

drop table if exists tb_log_login;

drop table if exists tb_log_operation;

drop table if exists tb_relation_role_ug;

drop table if exists tb_relation_user_group;

/*==============================================================*/
/* Table: tb_business_dictionary                                */
/*==============================================================*/
create table tb_business_dictionary
(
   dictionary_id        int(11) not null auto_increment comment '字典主键',
   text                 varchar(16) not null comment '名称',
   code                 varchar(16) not null comment '编码',
   sort                 int(3) default NULL comment '排序',
   create_time          time comment '创建时间',
   update_time          time comment '更新时间',
   delete_flag          int(1) not null default 0 comment '删除标记（0未删除，1删除）',
   primary key (dictionary_id)
)
auto_increment = 1;

alter table tb_business_dictionary comment '字典管理表';

/*==============================================================*/
/* Table: tb_business_dictionary_detail                         */
/*==============================================================*/
create table tb_business_dictionary_detail
(
   dictionary_detail_id int(11) not null auto_increment comment '明细主键',
   dictionary_id        int(11) not null comment '字典主键',
   text                 varchar(16) not null comment '名称',
   code                 varchar(16) not null comment '编码',
   sort                 int(3) default NULL comment '排序',
   create_time          time comment '创建时间',
   update_time          time comment '更新时间',
   delete_flag          int(1) not null default 0 comment '删除标记（0未删除，1删除）',
   primary key (dictionary_detail_id)
)
auto_increment = 1;

alter table tb_business_dictionary_detail comment '字典明细管理';

/*==============================================================*/
/* Table: tb_business_function                                  */
/*==============================================================*/
create table tb_business_function
(
   function_id          int(11) not null auto_increment comment '功能主键',
   function_name        varchar(32) comment '功能名称',
   function_url         varchar(128) comment '地址',
   sort                 int(3) default NULL comment '排序',
   level_type           int(1) not null default 1 comment '级别类型（1一级功能，2二级功能，默认1）',
   pic_url              varchar(128) comment '图片地址',
   pic_type             int(3) not null default 1 comment '图片类型（1系统默认型）',
   remark               text comment '备注说明',
   create_time          time comment '创建时间',
   update_time          time comment '更新时间',
   delete_flag          int(1) not null default 0 comment '删除标记（0未删除，1删除）',
   primary key (function_id)
)
auto_increment = 1;

alter table tb_business_function comment '功能管理表';

/*==============================================================*/
/* Table: tb_business_function_detail                           */
/*==============================================================*/
create table tb_business_function_detail
(
   function_detail_id   int(11) not null auto_increment comment '功能明细主键',
   function_id          int(11) not null comment '功能主键',
   text                 varchar(16) not null comment '明细名称',
   remark               text comment '备注说明',
   code                 varchar(16) not null comment '明细编码',
   sort                 int(3) default NULL comment '排序',
   pic_url              varchar(128) comment '图片地址',
   pic_type             int(3) not null default 1 comment '图片类型（1系统默认型）',
   create_time          time comment '创建时间',
   update_time          time comment '更新时间',
   delete_flag          int(1) not null default 0 comment '删除标记（0未删除，1删除）',
   primary key (function_detail_id)
)
auto_increment = 1;

alter table tb_business_function_detail comment '功能明细管理表';

/*==============================================================*/
/* Table: tb_business_group                                     */
/*==============================================================*/
create table tb_business_group
(
   group_id             int(11) not null auto_increment comment '用户组主键',
   group_name           varchar(32) not null comment '组名称',
   remark               text comment '备注介绍',
   create_time          time not null comment '创建时间',
   update_time          time not null comment '更新时间',
   delete_flag          int(1) not null default 0 comment '删除标记（0未删除，1删除）',
   primary key (group_id)
)
auto_increment = 1;

alter table tb_business_group comment '用户组管理表';

/*==============================================================*/
/* Table: tb_business_organization                              */
/*==============================================================*/
create table tb_business_organization
(
   organization_id组织主键  int(11) not null auto_increment comment '组织主键',
   organization_name    varchar(32) not null comment '机构名称',
   level_type           int(1) not null default 1 comment '级别类型（1一级功能，2二级功能，默认1）',
   pic_url              varchar(128) comment '图片地址',
   short_name           varchar(32) comment '机构简称',
   remark               text comment '机构介绍',
   parent_id            int(11) comment '上级机构主键',
   sort                 int(3) default NULL comment '排序',
   create_time          time comment '创建时间',
   update_time          time comment '更新时间',
   delete_flag          int(1) not null default 0 comment '删除标记（0未删除，1删除）',
   primary key (organization_id组织主键)
)
auto_increment = 1;

alter table tb_business_organization comment '组织机构管理';

/*==============================================================*/
/* Table: tb_business_role                                      */
/*==============================================================*/
create table tb_business_role
(
   role_id              int(11) not null auto_increment comment '角色主键',
   role_name            varchar(32) comment '角色名称',
   remark               text comment '备注说明',
   create_time          time comment '创建时间',
   update_time          time comment '更新时间',
   delete_flag          int(1) not null default 0 comment '删除标记（0未删除，1删除）',
   primary key (role_id)
)
auto_increment = 1;

alter table tb_business_role comment '角色管理表';

/*==============================================================*/
/* Table: tb_business_user                                      */
/*==============================================================*/
create table tb_business_user
(
   user_id              int(11) not null auto_increment comment '用户主键',
   user_name            varchar(16) comment '用户名',
   password             varchar(128) comment '密码',
   pic_url              varchar(128) comment '头像地址',
   create_time          time comment '创建时间',
   update_time          time comment '更新时间',
   delete_flag          int(1) not null default 0 comment '删除标记（0未删除，1删除）',
   primary key (user_id)
)
auto_increment = 1;

alter table tb_business_user comment '用户管理表';

/*==============================================================*/
/* Table: tb_log_login                                          */
/*==============================================================*/
create table tb_log_login
(
   log_id               int(11) not null auto_increment comment '日志主键',
   user_id              int(11) not null comment '用户主键',
   login_time           time not null comment '登录时间',
   logout_time          time not null comment '退出时间',
   ip                   varchar(32) comment '登录IP',
   mac                  varchar(32) comment '登录mac',
   primary key (log_id)
)
auto_increment = 1;

alter table tb_log_login comment '用户登录日志';

/*==============================================================*/
/* Table: tb_log_operation                                      */
/*==============================================================*/
create table tb_log_operation
(
   log_id               int(11) not null auto_increment comment '日志主键',
   user_id              int(11) comment '用户主键',
   url                  varchar(128) not null comment '请求地址',
   request_data         text comment '请求参数',
   back_data            text comment '返回数据',
   request_time         time not null comment '请求时间',
   primary key (log_id)
)
auto_increment = 1;

alter table tb_log_operation comment '用户操作日志';

/*==============================================================*/
/* Table: tb_relation_role_ug                                   */
/*==============================================================*/
create table tb_relation_role_ug
(
   relation_id          int(11) not null auto_increment comment '关联主键',
   role_id              int(11) not null comment '角色主键',
   ug_id                int(11) not null comment '用户/用户组主键',
   type                 int(1) not null default 0 comment '类型(0用户，1用户组，默认0)',
   primary key (relation_id)
)
auto_increment = 1;

alter table tb_relation_role_ug comment '用户角色关联表';

/*==============================================================*/
/* Table: tb_relation_user_group                                */
/*==============================================================*/
create table tb_relation_user_group
(
   relation_id          int(11) not null auto_increment comment '关联主键',
   user_id              int(11) not null comment '用户主键',
   group_id             int(11) not null comment '用户组主键',
   primary key (relation_id)
)
auto_increment = 1;

alter table tb_relation_user_group comment '用户和用户组关联表';

