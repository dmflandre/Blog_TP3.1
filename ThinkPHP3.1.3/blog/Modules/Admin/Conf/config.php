<?php
return array(
	'LAYOUT_NAME'=>'layouts/admin',

	'TMPL_PARSE_STRING'=>array(
		'__RES__'=>dirname($_SERVER['SCRIPT_NAME'])."/".APP_NAME."/Modules/".GROUP_NAME."/Resource",
		'__PUBLIC__'=>__ROOT__."/".APP_NAME."/Public",
		'__COMMON__'=>__ROOT__."/".APP_NAME."/Common",
	),

	//后台的session前缀
	'SESSION_PREFIX'=>'admin',
);