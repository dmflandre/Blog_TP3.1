<?php
	class CommonAction extends Action{
		//初始化方法，在所有方法运行之前先运行本方法
		public function _initialize(){
			//加载RBAC
			import("ORG.Util.RBAC");
			
			if(!RBAC::checkAuth()){
				$this->error("您所在的用户组木有权限");
				//exit;
			}
		}
	}