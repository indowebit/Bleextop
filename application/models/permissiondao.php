<?php

class PermissionDao extends CI_Model{
	
	public function get($id){
		$rs = $this->db->where("permission_k",$id)
						->get("permissions");
						
		return $rs->result_array();
	}
	public function getAll(){
		$rs = $this->db->get("permissions");
		
		return $rs->result_array();
	}
	
	public function save($data){
		$this->db->insert("permissions",$data);
	}
	
	public function update($data){
		$this->db->where("permission_k",$data->permission_k)
				->update("permissions",$data);
	}
	
	public function delete($data){
		$this->db->where("permission_k",$data["permission_k"])
				->delete("permissions");
	}
	
	public function getByApplication($application_k){
		$rs = $this->db->get_where("permissions",array(
				"application_k"	=> $application_k
			));
		
		return $rs->result_array();
	}
	
	public function deleteRolePermissions($data){
		$this->db->where("role_permission_k",$data["role_permission_k"])
				->delete("role_permissions");
	}
	
	public function updateRolePermissions($data){
		return $this->db->where(array(
					"permission_k"	=> $data->permission_k,
					"role_k"		=> $data->role_k
				))
				->update("role_permissions",$data);
		
	}
	
	//add a permission to a role
	public function addRolePermissions($data){
		$this->db->insert("role_permissions",$data);
	}
	
	public function getRolePermissions($application_k){
		$rs = $this->db->select("RP.*")
						->from("role_permissions RP")
						->join("roles R","R.role_k=RP.role_k")
						->join("permissions P","P.permission_k=RP.permission_k")
						->where("P.application_k",$application_k)
						->get();

		return $rs->result_array();
	}
	
}