<?php
	class PublicAction extends Action{
		//渲染登陆界面
		public function login(){
			//临时关闭布局
			C('LAYOUT_ON',false);
			$this->display('login');
		}

		//创建验证码的方法
		public function captcha(){
			//1.加载验证码类
			import('ORG.Util.Image');
			//2.显示图片
			Image::buildImageVerify(5,1,'png',145,36);
			//$ttf = APP_PATH."/Public/fonts/msyhbd.ttf";
			//Image::GBVerify(1,'png',145,36,$ttf);
		}

		//执行登录的方法(无验证码)
		public function doLogineasy(){
			//1.创建model对象
			$usermodel = D("User");
			//2.压入数据
			//3.验证数据
			if($usermodel->create($_POST,7)){
				//写入session
				session('username',$_POST['username']);
				session('isLogin',1);
				import("ORG.Util.RBAC");
				$id = $usermodel->where("username='{$_POST['username']}'")->getField("id");
				RBAC::setAccessList($id);
				$this->success('恭喜您，登陆成功',U('Index/index'));
			}else{
				$this->error($usermodel->getError(),U('Public/login'));
			}
		}
		//执行登陆的方法(有验证码)
		public function doLogin(){
			//1.创建model对象
			$usermodel = D("User");
			//2.压入数据
			//3.验证数据
			if($usermodel->create($_POST,4)){
				//写入session
				session('username',$_POST['username']);
				session('isLogin',1);
				import("ORG.Util.RBAC");
				$id = $usermodel->where("username='{$_POST['username']}'")->getField("id");
				RBAC::setAccessList($id);
				$this->success('恭喜您，登陆成功',U('Index/index'));
			}else{
				$this->error($usermodel->getError());
			}
		}

		//退出方法
		public function logout(){
			//清除session，跳转回登陆界面
			session(null);
			if(session('isLogin')!=1){
				//执行跳转
				$this->success('退出成功，马上回到网站首页',U('home/Index/index'));
			}
		}
	}