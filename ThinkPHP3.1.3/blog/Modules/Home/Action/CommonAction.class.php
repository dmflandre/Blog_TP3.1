<?php
	class CommonAction extends Action{
		public function _initialize(){

			//显示导航
			
			$menu = D("Category")->getMenu();
			
			$this->assign("serch",$_GET['serch']);
			
			$this->assign('menu',$menu);
		}
		//显示右侧边栏
		public function showrightcontent()
		{
			
			//随机文章
			$randArt = M("Article")->order("rand()")->limit(10)->select();
			foreach ($randArt as &$val) {
				$val['upic']="small_".M("Profile")->where("uid={$val['uid']}")->getField("pic");
			}

			

			//登录信息
			
			$adminindex=U('admin/Index/index');
			$addarticle=U('admin/Article/add');
			$action=U('admin/Public/dologineasy');
			if ($_SESSION['admin']['isLogin']>0) {
				$loginform=<<<loginform
				<h3>欢迎回来，{$_SESSION['admin']['username']}</h3>
				<p><a href="$adminindex" alt="转到后台" title="转到后台~">转到后台管理页面</a></p>
				<a href="$addarticle" alt="点此分享新文章" title="点此分享新文章">分享新文章</a>
				
loginform;
			}else{
				$loginform=<<<loginform
					<h3>登入</h3>
					<form name="loginform" id="loginform" action="$action" method="post">
						<p >
						<label >用户名</label><br/>
						<input name="username" size="20" type="text"/>
						</p>
						<p >
						<label>密码</label><br/>
						<input name="password" value="" size="20" type="password">
						</p>
						<p ><label><input name="rememberme" checked="checked" type="checkbox"> 记住我</label></p>
						
						<input  value="登入" type="submit">
			
					</form>
					<a href="" alt="密码丢失了我也没办法，诶嘿~" title="密码丢失了我也没办法，诶嘿~">丢失密码?</a><P></P>
loginform;
			}
			$this->assign('loginform',$loginform);
			$this->assign("recentArt",$recentArt);
			$this->assign("randArt",$randArt);
		}

		//显示文章列表
		public function showwords($where)
		{
			$artmodel = D('Article');
			//处理分页
			import('ORG.Util.Page');// 导入分页类
			$total = $artmodel->where($serch)->count();
			$pager = new Page($total,5);
			$firstRow = $pager->firstRow;
			$listRow = $pager->listRows;

			$arts = $artmodel->where($where)->limit($firstRow.",".$listRow)->order('ptime desc')->select();
			$link = $pager->show();
			

			foreach ($arts as &$val) {
				$val['username']=M("User")->where("id={$val['uid']}")->getField("username");
				$catename=M("Category")->where("id={$val['cid']}")->getField("name");
				$val['cname']=$catename;
			}
			$this->assign('catename',$catename);
			$this->assign('link',$link);
			$this->assign("arts",$arts);
		}
	}	