<?php
	class IndexAction extends CommonAction{
		//创建一个方法index
		public function index(){
			$this->showrightcontent();
			if ($_GET['serch']) {
				$serch['title']=array('like',"%".$_GET['serch']."%");
			}else{$serch='';}
			$this->showwords($serch);
			$this->display('index');
		}
		public function cates()
		{

			$this->showrightcontent;
			$c=$_GET['c'];
			$serch['cid']=$c;
			if ($_GET['serch']) {
				$serch['title']=array('like',"%".$_GET['serch']."%");
			}else{unset($serch['title']);}
			$this->showwords($serch);
			$this->display('cate');
		}
	}