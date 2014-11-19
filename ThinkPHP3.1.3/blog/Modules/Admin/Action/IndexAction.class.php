<?php
	class IndexAction extends CommonAction{
		public function index(){

			$this->assign('index',$index);
			$this->display('index');
		}
		public function modimg()
		{
			if($_FILES['pic']['error']==0){
				//1.导入上传类
				import('ORG.Net.UploadFile');
				//2.实例化上传类
				$upload = new UploadFile();// 实例化上传类
				
				//3.指定最大文件大小
				$upload->maxSize = 5000000;
				//4.指定文件的后缀名
				$upload->allowExts = array('jpeg','jpg');
				//5.限制mime的类型
				$upload->allowTypes = array('image/jpeg');
				//6.指定移动目录
				//6.执行移动
				$save = str_replace("\\","/",dirname(dirname(dirname(dirname(__FILE__)))))."/Common/images/";
				$upload->savePath = $save;
				//指定保存规则，定义文件名字
				$upload->saveRule = $this->imgname();
				//设置替换文件
				$upload->uploadReplace = true;

				if($upload->upload()){
					$this->success("修改成功！");

				}else{
					$this->error($upload->getErrorMsg());
					exit;
				}
			}
		}
		public function imgname()
		{
			return "logo";
		}
	}