<?php
	class RoleModel extends Model{
		public function getRole($data){
			foreach($data as &$role){
				$role['count'] = M("User_role")->where("rid=".$role['id'])->count();
			}
			return $data;
		}
	}