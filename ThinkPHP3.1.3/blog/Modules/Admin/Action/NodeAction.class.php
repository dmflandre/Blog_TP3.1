<?php
	class NodeAction extends Action{
		public function add(){
			//查询出所有的控制器
			$controllers = M("Node")->where('level=1')->select();
			$this->assign('controllers',$controllers);
			$this->display("add");
		}

		public function doAdd(){
			//1.创建对象
			$nodemodel = D("Node");
			//2.压入数据并且验证
			if($nodemodel->create()){
				//3.处理数据并且插入
				if($_POST['pid']==0){
					$_POST['level'] = 1;
				}else{
					$_POST['level'] = 2;
				}
				if($nodemodel->add($_POST)){
					$this->success('添加节点成功',U('index'));
				}else{
					$this->error('添加节点失败',U('index'));
				}
			}else{
				$this->error($nodemodel->getError());
			}
			
		}

		//节点列表方法
		public function index(){
			$nodes = D("Node")->getList();
			$this->assign('nodes',$nodes);
			$this->display("index");
		}
	}