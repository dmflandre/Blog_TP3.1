<?php
	class UserModel extends Model{
		protected $_validate = array(
			//用户名不能为空
			array('username','require','用户名不能为空',0,'',3),
			//密码不能为空
			array('password','require','密码不能为空',0,'',3),
			//验证码是否正确
			array('captcha','checkCaptcha','验证码错误',1,'callback',4),
			//验证用户名或者密码是否正确
			array('password','checkPass','用户名或者密码错误',1,'callback',4),
			array('password','checkPass','用户名或者密码错误',1,'callback',7),

			//修改密码
			//1.验证原始密码不能为空
			array('oldpass','require','原始密码不能为空',1,'',5),
			//2.验证原始密码正确性
			array('oldpass','checkOldPass','原始密码不正确',1,'callback',5),
			//3.验证新密码不能为空
			array('newpass','require','新密码不能为空',1,'',5),
			//4.验证确认密码与新密码保持一致
			array('repass','newpass','两次密码输入不一致',1,'confirm',5),

			//添加用户的规则
			//1.用户名不能为空
			//2.用户是否重复
			array('username','','用户名已存在',1,'unique',6),
			//3.验证密码不能为空
			//4.两次密码一致
			array('repass','password','两次密码不一致',1,'confirm',6),
		);

		//回调验证验证验证码
		public function checkCaptcha(){
			if(session("verify")!=md5($_POST['captcha'])){
				return false;
			}
			return true;
		}

		//回调方法验证用户名或者密码是否正确
		public function checkPass(){
			
			$username = $_POST['username'];
			$password = md5($_POST['password']);
			$data = $this->where("username='$username' and password='$password'")->find();
			if(!$data){
				return false;
			}
			return true;
		}

		public function checkOldPass(){
			$username = session('username');
			$password = md5($_POST['oldpass']);
			$data = $this->where("username='$username' and password='$password'")->find();
			if(is_null($data)){
				return false;
			}
			return true;
		}

		//给用户列表添加Ip地址定位
		public function getIp($users){
			import('ORG.Net.IpLocation');// 导入IpLocation类
			$ip = new IpLocation('UTFWry.dat'); // 实例化类 参数表示IP地址库文件
			foreach($users as &$user){
				$area = $ip->getLocation(long2ip($user['loginip']));
				$user['area'] = $area['country'].$area['area'];
			}
			return $users;
		}
	}