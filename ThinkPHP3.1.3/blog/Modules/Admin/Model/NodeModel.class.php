<?php
	class NodeModel extends Model{
		public function getList(){
			$controllers = $this->where("level=1")->select();
			foreach($controllers as &$controller){
				$controller['actions'] = $this->where("pid=".$controller['id'])->select();
			}
			return $controllers;
		}
	}