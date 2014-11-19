<?php
	class RBAC{
		//获取所有的权限，并且写入session
		public static function setAccessList($uid){
			//1.查询所有的rid
			$data = M("User_role")->where('uid='.$uid)->select();
			foreach($data as $v){
				$rids[] = $v['rid'];
			}
			//2.查询对应的所有的nid
			$nids = array();
			foreach($rids as $rid){
				$res = M("Role_node")->where("rid=".$rid)->select();
				foreach($res as $val){
					$nids[] = $val['nid'];
				}
			}
			//3.查询出所有控制器和操作的名称
			foreach($nids as $nid){
				$nodes[] = M("Node")->where("id=".$nid)->find();
			}
			$controllers = self::setFormatArray($nodes);
			//2.写入到session当中
			session("ACCESS_LIST",$controllers);
		}

		//组装数组
		private static function setFormatArray($data){
			$controllers = array();
			foreach($data as $val){
				if($val['level']==1){
					//控制器
					$controllers[$val['name']] = array();
					foreach($data as $v){
						if($v['pid']==$val['id']){
							$controllers[$val['name']][] = $v['name'];
						}
					}
				}
			}
			return $controllers;
		}
		
		//验证权限
		public static function checkAuth(){
			//dump($_SESSION);
			//dump($_GET);
			//echo MODULE_NAME;
			//echo ACTION_NAME;
			//1.先判断控制器的权限是否存在
			if(array_key_exists(MODULE_NAME,session("ACCESS_LIST"))){
				//2.验证该控制器的方法是否存在
				$access_list = session("ACCESS_LIST");
				if(!in_array(ACTION_NAME,$access_list[MODULE_NAME])){
					//踢出去
					
					return false;
				}
			}else{
				//踢出去
				
				return false;
			}
			return true;
		}
	}