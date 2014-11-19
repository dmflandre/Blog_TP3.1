<?php
	class ArtAction extends CommonAction{
		public function word()
		{
			//var_dump($_GET);
			//$tempname="a".$_GET['w'];
			//$cache = Cache::getInstance('File');
			//if(!$art=$cache->get("art")){
				$where['id']=$_GET['w'];
				$art = M('Article')->where($where)->find();
				$art['username']=M("User")->where("id={$art['uid']}")->getField("username");
				$art['cname']=M("Category")->where("id={$art['cid']}")->getField("name");
				
			//	$cache->set("art",$art);
			//}
			
			$this->assign('art',$art);
			$this->display('word');
		}
	}