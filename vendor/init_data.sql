/*==============================================================*/
/* 创建管理员用户             			                        */
/*==============================================================*/
INSERT INTO tb_business_user(user_name, password, create_time, update_time) VALUES ('admin', '123456',NOW(), NOW());

/*==============================================================*/
/* 创建用户组             				                        */
/*==============================================================*/
INSERT INTO tb_business_group(group_name, remark, create_time, update_time) VALUES ('管理组', '管理员角色',NOW(), NOW());

/*==============================================================*/
/* 用户和用户组关联           				                        */
/*==============================================================*/
INSERT INTO tb_relation_user_group(user_id, group_id) VALUES
(
	(SELECT user_id FROM tb_business_user WHERE user_name = 'admin'),
	(SELECT group_id FROM tb_business_group WHERE group_name = '管理组')
);

/*==============================================================*/
/* 系统功能                					                    */
/*==============================================================*/
INSERT INTO tb_business_function
(function_name, function_url, sort, level_type, parent_id, create_time, update_time)
VALUES
('系统管理', '/system/index', 1, 1, 0, NOW(), NOW()),
('用户管理', '/system/user/index', 1, 2, 1, NOW(), NOW()),
('用户组管理', '/system/group/index', 2, 2, 1, NOW(), NOW()),
('角色权限管理', '/system/role/index', 3, 2, 1, NOW(), NOW()),
('功能管理', '/system/function/index', 4, 2, 1, NOW(), NOW()),
('组织机构管理', '/system/organization/index', 5, 2, 1, NOW(), NOW()),
('日志管理', '/system/log/index', 6, 2, 1, NOW(), NOW());

/*==============================================================*/
/* 创建角色并分配相应的权限               		                    */
/*==============================================================*/
INSERT INTO tb_business_role(role_name, remark, create_time, update_time) VALUES ('管理员角色', '管理',NOW(), NOW());

INSERT INTO tb_relation_role_ug(role_id, ug_id) VALUES
(
	(SELECT role_id FROM tb_business_role WHERE role_name = '管理员角色'),
	(SELECT user_id FROM tb_business_user WHERE user_name = 'admin')
);

/*==============================================================*/
/* 角色功能关联。                                                 */
/*==============================================================*/
INSERT INTO tb_relation_role_fd(role_id, function_id) VALUES
(
	(SELECT role_id FROM tb_business_role WHERE role_name = '管理员角色'),
	(SELECT function_id FROM tb_business_function WHERE function_name = '系统管理')
),
(
	(SELECT role_id FROM tb_business_role WHERE role_name = '管理员角色'),
	(SELECT function_id FROM tb_business_function WHERE function_name = '用户管理')
),
(
	(SELECT role_id FROM tb_business_role WHERE role_name = '管理员角色'),
	(SELECT function_id FROM tb_business_function WHERE function_name = '用户组管理')
),
(
	(SELECT role_id FROM tb_business_role WHERE role_name = '管理员角色'),
	(SELECT function_id FROM tb_business_function WHERE function_name = '角色权限管理')
),
(
	(SELECT role_id FROM tb_business_role WHERE role_name = '管理员角色'),
	(SELECT function_id FROM tb_business_function WHERE function_name = '功能管理')
),
(
	(SELECT role_id FROM tb_business_role WHERE role_name = '管理员角色'),
	(SELECT function_id FROM tb_business_function WHERE function_name = '组织机构管理')
),
(
	(SELECT role_id FROM tb_business_role WHERE role_name = '管理员角色'),
	(SELECT function_id FROM tb_business_function WHERE function_name = '日志管理')
)
;