<?php
	class ArticleModel extends RelationModel{
		protected $_link = array(
			'author'=>array(
				'mapping_type'=>BELONGS_TO,
				'class_name'=>'User',
				'foreign_key'=>'uid',
				'mapping_fields'=>'username',
				'as_fields'=>'username',
			),
			'cate'=>array(
				'mapping_type'=>BELONGS_TO,
				'class_name'=>'Category',
				'foreign_key'=>'cid',
				'mapping_fields'=>'name',
				'as_fields'=>'name:pname',
			),
		);
	}