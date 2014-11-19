<?php
	class UserAction extends CommonAction{
		public function modPass(){
			$this->display('modpass');
		}

		public function doModPass(){
			//1.实例化对象
			$usermodel = D("User");
			//2.压入数据
			//3.验证数据
			if($usermodel->create($_POST,5)!==false){
				//修改密码
				$username = session('username');
				if($usermodel->where("username='$username'")->save(array('password'=>md5($_POST['newpass'])))){
					$this->success('修改密码成功');
				}else{
					$this->error('修改密码失败');
				}
			}else{
				$this->error($usermodel->getError());
			}
		}

		//添加会员方法
		public function add(){
			$this->display('add');
		}

		//执行添加的方法
		public function doAdd(){
			//1.实例化对象
			$usermodel = D('User');
			//2.压入数据
			//3.验证数据
			if($usermodel->create($_POST,6)){
				//4.添加数据
				if($id = $usermodel->add(array('username'=>$_POST['username'],'password'=>md5($_POST['password'])))){
					//找对应的主键ID添加到profile当中
					M('Profile')->add(array('uid'=>$id));
					$this->success('添加用户成功',U('User/index'));
				}else{
					$this->error('添加用户失败');
				}
			}else{
				$this->error($usermodel->getError());
			}
			
		}

		//显示会员列表
		public function index(){
			$usermodel = D('User');
			//处理分页
			import('ORG.Util.Page');// 导入分页类
			$total = $usermodel->count();
			$pager = new Page($total,3);
			$firstRow = $pager->firstRow;
			$listRow = $pager->listRows;

			$users = $usermodel->limit($firstRow.",".$listRow)->order('id asc')->select();
			$link = $pager->show();
			$users = $usermodel->getIp($users);
			$this->assign('link',$link);
			$this->assign('users',$users);
			$this->display('index');
		}

		//删除用户的方法
		public function del(){
			/*$id = $_GET['id'];
			if(M("User")->delete($id)){
				$this->success('删除用户成功');
			}else{
				$this->error('删除用户失败');
			}*/
			$id = $_REQUEST['id'];
			//如果是批量删除
			if(is_array($id)){
				$id = join(",",$id);
			}
			if(M("User")->where("id in ($id)")->delete()){
				$this->success('删除用户成功');
			}else{
				$this->error('删除用户失败');
			}
		}

		//编辑用户的界面
		public function mod(){
			$user = D("Profile")->relation(true)->where('uid='.$_GET['id'])->find();
			$this->assign('tmpl_sex',C('TMPL_SEX_VAR'));
			$this->assign('tmpl_edu',C('TMPL_EDU_VAR'));
			$this->assign('user',$user);
			$this->display('mod');
		}

		//执行编辑
		public function doMod(){
			//1.实例化对象
			$profile = D('Profile');

			//判断是否有文件上传
			if($_FILES['pic']['error']==0){
				//1.导入上传类
				import('ORG.Net.UploadFile');
				//2.实例化上传类
				$upload = new UploadFile();// 实例化上传类
				//3.指定最大文件大小
				$upload->maxSize = 5000000;
				//4.指定文件的后缀名
				$upload->allowExts = array('jpeg','jpg','png','gif','bmp');
				//5.限制mime的类型
				$upload->allowTypes = array('image/png','image/jpeg','image/gif','image/wbmp');
				//6.指定移动目录
				//6.执行移动
				$save = str_replace("\\","/",dirname(dirname(dirname(dirname(__FILE__)))))."/Public/uploads/";
				$upload->savePath = $save;
				//对图片进行缩略处理
				$upload->thumbRemoveOrigin = true;
				$upload->thumb = true;
				$upload->thumbMaxWidth = '200,120,45';
				$upload->thumbMaxHeight = '200,120,45';
				$upload->thumbPrefix = "big_,middle_,small_";

				if($upload->upload()){
					$info = $upload->getUploadFileInfo();
					//插入数据库
					$_POST['pic'] = $info[0]['savename'];
					

				}else{
					$this->error($upload->getErrorMsg());
					exit;
				}
			}

			//2.压入数据并且验证
			if($data = $profile->create()){
				//3.修改
				if($profile->where('uid='.$data['uid'])->save($data)){
					$this->success('修改成功',U('User/index'));
				}else{
					$this->error('您没有修改',U('User/index'));
				}
			}else{
				$this->error($profile->getError());
			}
		}

		public function setrole(){
			//查询出用户名
			$username = M("User")->where("id=".$_GET['id'])->getField("username");
			//查询出所有的角色
			$roles = M("Role")->select();
			//查询出所有的rid
			$res = M("User_role")->where("uid=".$_GET['id'])->select();
			foreach($res as $val){
				$rids[] = $val['rid'];
			}
			$this->assign('rids',$rids);
			$this->assign("roles",$roles);
			$this->assign("username",$username);
			$this->display("roles");
		}

		//执行添加角色的方法
		public function addRole(){
			//1.先删除该用户所有的角色
			M("user_role")->where("uid=".$_POST['uid'])->delete();
			//2.批量添加
			foreach($_POST['rid'] as $rid){
				$data[] = array('uid'=>$_POST['uid'],'rid'=>$rid);
			}
			if(M("user_role")->addAll($data)){
				$this->success("设置成功");
			}else{
				$this->error("设置失败");
			}
		}
	}