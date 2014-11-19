<?php
return array(
	//'配置项'=>'配置值'
	'APP_GROUP_LIST'=>'Admin,Home',//分组列表
	'DEFAULT_GROUP'=>'Home',//默认分组
	'APP_GROUP_MODE'=>1,//开启独立分组模式

	//开启页面的trace信息
	//'SHOW_PAGE_TRACE'=>true,

	//开启布局
	'LAYOUT_ON'=>true,

	//配置数据库
	'DB_TYPE'=>'mysql',
	'DB_HOST'=>'localhost',
	'DB_PORT'=>3306,
	'DB_USER'=>'root',
	'DB_PWD'=>'',
	'DB_NAME'=>'flandre_blog',
	'DB_PREFIX'=>'blog_',
	'DB_CHARSET'=>'utf8',
	

	//自定义配置
	//性别
	'TMPL_SEX_VAR'=>array('保密','男','女','泰国'),
	//学历
	'TMPL_EDU_VAR'=>array('请选择','小学','初中','高中','大专','本科','硕士研究生','博士研究生','博士后','卡密'),
	//Common下的img文件夹
	'TMPL_PARSE_STRING'=>array(
		'__COMMON__'=>__ROOT__."/".APP_NAME."/Common",
	),
	
);
?>