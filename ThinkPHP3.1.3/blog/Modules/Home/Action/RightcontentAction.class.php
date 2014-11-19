<?php
	class RightcontentAction extends Action{
		public function _initialize(){
			//设置缓存
			//1.实例化缓存对象
			
			//2.设置配置
			//3.保存缓存
			$cache = Cache::getInstance('File');

			//显示导航
			if(!$menu=$cache->get("menu")){
				$menu = D("Category")->getMenu();
				$cache->set("menu",$menu);
			}
			
			//随机文章
			$randArt = M("Article")->order("rand()")->limit(3)->select();
			foreach ($randArt as &$val) {
				$val['upic']="small_".M("Profile")->where("uid={$val['uid']}")->getField("pic");
			}

			//最近文章
			if(!$recentArt = $cache->get('recentArt')){
				echo time();
				$recentArt = M("Article")->order("ptime desc")->limit(5)->select();
				$cache->set("recentArt",$recentArt);
			}
			//登录信息
			if (session('isLogin')>0) {
				echo M("User")->where("username='".session('username')."'")->getField("id");
			}
			



			$this->assign("serch",$_GET['serch']);
			$this->assign("recentArt",$recentArt);
			$this->assign("randArt",$randArt);
			$this->assign('menu',$menu);
		}
		public function showwords($where)
		{
			$artmodel = D('Article');
			//处理分页
			import('ORG.Util.Page');// 导入分页类
			$total = $artmodel->where($serch)->count();
			$pager = new Page($total,2);
			$firstRow = $pager->firstRow;
			$listRow = $pager->listRows;

			$arts = $artmodel->where($where)->limit($firstRow.",".$listRow)->order('ptime desc')->select();
			$link = $pager->show();
			

			foreach ($arts as &$val) {
				$val['username']=M("User")->where("id={$val['uid']}")->getField("username");
				$val['cname']=M("Category")->where("id={$val['cid']}")->getField("name");
			}

			$this->assign('link',$link);
			$this->assign("arts",$arts);
		}
	}	