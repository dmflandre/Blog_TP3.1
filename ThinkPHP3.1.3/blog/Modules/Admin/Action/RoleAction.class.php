<?php
	class RoleAction extends Action{
		public function add(){
			$this->display("add");
		}

		public function doAdd(){
			//1.实例化对象
			$rolemodel = D("Role");
			//2.压入数据并且验证
			if($rolemodel->create()){
				//3.插入数据
				if($rolemodel->add()){
					$this->success("添加成功",U('index'));
				}else{
					$this->error('添加失败');
				}
			}else{
				$this->error($rolemodel->getError());
			}
			
		}

		public function index(){
			$rolemodel = D("Role");
			$data = $rolemodel->select();
			$roles = $rolemodel->getRole($data);
			$this->assign("roles",$roles);
			$this->display("index");
		}

		//设置权限的方法
		public function auth(){
			$roles = M("Role")->select();
			$nodes = D("Node")->getList();
			$res = M("Role_node")->where("rid=".$roles[0]['id'])->select();
			foreach($res as $val){
				$nids[] = $val['nid'];
			}
			$this->assign("nids",$nids);
			$this->assign("nodes",$nodes);
			$this->assign("roles",$roles);
			$this->display("auth");
		}

		//设置权限
		public function setauth(){
			//先把当前的角色的权限全部删除
			M("Role_node")->where("rid=".$_POST['rid'])->delete();
			//然后再添加新的
			$data = array();
			foreach($_POST['nid'] as $nid){
				$data[] = array('rid'=>$_POST['rid'],'nid'=>$nid);
			}
			if(M("Role_node")->addAll($data)){
				$this->success("设置成功");
			}else{
				$this->error("设置失败");
			}
		}

		//通过ajax获取对应的权限
		public function getAjaxList(){
			layout(false);
			$rid = $_GET['rid'];
			$nodes = D("Node")->getList();
			$res = M("Role_node")->where("rid=".$rid)->select();
			foreach($res as $val){
				$nids[] = $val['nid'];
			}
			$this->assign("nodes",$nodes);
			$this->assign("nids",$nids);
			$this->display("section");
		}
	}