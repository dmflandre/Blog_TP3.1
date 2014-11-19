<?php
return array(
	'TMPL_PARSE_STRING'=>array(
		'__RES__'=>dirname($_SERVER['SCRIPT_NAME'])."/".APP_NAME."/Modules/".GROUP_NAME."/Resource",
		'__PUBLIC__'=>__ROOT__."/".APP_NAME."/Public",
		'__COMMON__'=>__ROOT__."/".APP_NAME."/Common",
	),

	//指定布局文件
	'LAYOUT_NAME'=>'layouts/home',

	//'DB_LIKE_FIELDS'=>'title',//数据库模糊查询(好像无效)
);