<?php
	class ArticleAction extends CommonAction{
		public function add(){
			$catemodel = D("Category");
			$data = $catemodel->relation(true)->order('concat(path,"-",id)')->select();
			$data = $catemodel->getList($data);
			$this->assign('cates',$data);
			$this->display("add");
		}

		public function doAdd(){
			$_POST['uid'] = M("User")->where("username='".session('username')."'")->getField("id");
			$_POST['ptime'] = time();
			$_POST['pip'] = ip2long($_SERVER['REMOTE_ADDR']);
			//1.实例化对象
			$artmodel = D("Article");

			//文件上传
			if($_FILES['pic']['error']==0){
				//1.加载上传类
				import('ORG.Net.UploadFile');
				//2.实例化上传类
				$upload = new UploadFile();
				$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
				$upload->savePath = str_replace("\\","/",dirname(dirname(dirname(dirname(__FILE__)))))."/Public/uploads/";
				$upload->thumb = true;
				//$upload->thumbMaxWidth = "160";
				//$upload->thumbMaxHeight = "125";
				$upload->thumbPrefix = "thumb_";
				if($upload->upload()){
					$info = $upload->getUploadFileInfo();
					$_POST['pic'] = $info[0]['savename'];
				}else{
					$this->error($upload->getErrorMsg());
					exit;
				}
			}

			//2.压入并且验证数据
			if($artmodel->create()){
				//3.添加文章
				if($artmodel->add($_POST)){
					$this->success('添加成功',U('index'));
				}else{
					$this->error('添加失败');
				}
			}else{
				$this->error($artmodel->getError());
			}
			
		}


		public function index(){
			$arts = D("Article")->relation(true)->select();
			$this->assign('arts',$arts);
			$this->display("index");
		}

	}