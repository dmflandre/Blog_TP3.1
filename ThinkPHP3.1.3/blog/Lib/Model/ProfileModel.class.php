<?php
	//关联一定要继承关联模型【RelationModel】
	class ProfileModel extends RelationModel{
		//声明一个关联的成员属性
		protected $_link = array(
			'user'=>array(
				//关联类型
				'mapping_type'=>BELONGS_TO,
				//关联的类
				'class_name'=>'User',
				//关联外键
				'foreign_key'=>'uid',
				//关联查询字段
				'mapping_fields'=>'username',
				//字段别名
				'as_fields'=>'username:uname',
			),
		);

		//验证规则
		protected $_validate = array(
			//1.UID不能为空
			array('uid','require','UID不合法',1),
			//2.真实姓名不为空的时候验证合法性
			array('t_name','checkTName','真实姓名不合法',2,'callback',3),
			//3.年龄指定范围0-150
			array('age',array(0,150),'年龄必须为0-150的整型',2,'between',3),
			//4.性别指定范围0-3
			array('sex',array(0,3),'性别不合法',2,'between',3),
			//5.学历指定范围0-10
			array('edu',array(0,10),'学历不合法',2,'between',3),
			//6.email验证
			array('email','/^\w+@[0-9a-z-]+\.[a-z]+(\.[a-z]+)?$/i','email格式不正确',2,'regex'),
		);

		//自定义方法
		public function checkTName(){
			$names = array('本拉登','萨达姆','奥巴马','傻X');
			if(in_array($_POST['t_name'],$names)){
				return false;
			}
			return true;
		}
	}