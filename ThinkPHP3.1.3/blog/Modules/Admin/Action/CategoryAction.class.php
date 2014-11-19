<?php
	class CategoryAction extends CommonAction{
		public function add(){
			$catemodel = D("Category");
			$cates = $catemodel->order('concat(path,"-",id)')->select();
			$cates = $catemodel->getList($cates);
			$this->assign('cates',$cates);
			$this->display('add');
		}

		public function doAdd(){
			//1.实例化model
			$catemodel = D("Category");
			//2.压入并且验证数据
			if($catemodel->create()){
				//3.插入数据
				//处理path
				//判断如果pid为0，path为0
				if($_POST['pid']==0){
					$_POST['path'] = "0";
				}else{
					//如果pid不为0，找到id为当前pid值的path，再拼接pid
					$path = $catemodel->where('id='.$_POST['pid'])->getField("path");
					$_POST['path'] = $path."-".$_POST['pid'];
				}
				if($catemodel->add($_POST)){
					$this->success("添加成功",U('index'));
				}else{
					$this->error('添加失败');
				}
			}else{
				$this->error($catemodel->getError());
			}
			
		}

		public function index(){
			$catemodel = D("Category");
			$cates = $catemodel->relation(true)->order('concat(path,"-",id)')->select();
			$cates = $catemodel->getList($cates);

			$this->assign('cates',$cates);
			$this->display("index");
		}
	}