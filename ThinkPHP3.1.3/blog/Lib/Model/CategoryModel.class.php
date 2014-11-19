<?php
	class CategoryModel extends RelationModel{
		protected $_validate = array(
			array('pid','require','请选择一个合法的上级分类',1,'',3),
			array('name','require','请填写分类名称',1,'',3),
		);

		protected $_link = array(
			'pname'=>array(
				'mapping_type'=>BELONGS_TO,
				'class_name'=>'Category',
				'foreign_key'=>'pid',
				'mapping_fields'=>'name',
				'as_fields'=>'name:pname',
				'parent_key'=>'pid',//自表关联
			),
			'author'=>array(
				'mapping_type'=>BELONGS_TO,
				'class_name'=>'User',
				'foreign_key'=>'uid',
				'mapping_fields'=>'username',
				//'as_fields'=>'username',
			),
		);

		public function getList($cates){
			foreach($cates as &$cate){
				$prefix = "";
				$c = count(explode("-",$cate['path']));
				for($i=0;$i<$c*2;$i++){
					$prefix .= "|----";
				}
				$cate['pre_name'] = $prefix.$cate['name'];
			}
			return $cates;
		}

		/*public function getTree(){
			$data = $this->where('pid=0')->select();
			foreach($data as &$cate){
				$cate['sons'] = $this->where('pid='.$cate['id'])->select();
				foreach($cate['sons'] as &$v){
					$v['sons'] = $this->where('pid='.$v['id'])->select();
				}
			}
			return $data;
		}*/

		//根据父类的主键ID找出子类
		public function getTree($pid=0){
			/*$data = $this->where('pid='.$pid)->select();
			foreach($data as &$cate){
				$cate['sons'] = $this->getTree($cate['id']);
			}*/
			$data = $this->select();
			return $data;
		}

		public function getMenu(){
			$top = $this->where("pid=0")->select();
			/*
			foreach($top as &$cate){
				$cate['sons'] = $this->where("pid=".$cate['id'])->select();
			}
			*/
			return $top;
		}
	}