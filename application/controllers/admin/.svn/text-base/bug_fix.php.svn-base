<?php
class Bug_fix extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	
	// fix duplicate {code name, type_id}
	// TODO unknow reason
	function fix_duplicate_code_type()
	{
		$sql = "select id, name, type_id, count(*) as cnt from codes 
				group by name, type_id	having cnt > 1 order by name";
		$duplicate_list = $this->db->query($sql)->result();
		
		foreach($duplicate_list as $dup){
			if($dup->type_id == 0) continue;
			$first_code_id = $dup->id; 
			$code_list = $this->db->get_where("codes", 
				array("name" => $dup->name, "type_id" => $dup->type_id))->result();
			array_shift($code_list); // keep first row
			
			foreach($code_list as $code){
				// update auction
				$this->db->query("UPDATE auction set code_id = '$first_code_id' 
					WHERE code_id = '{$code->id}' AND type_id = '$code->type_id}'");
				echo "Auction updated: ".mysql_affected_rows()."<br />";
				// update code_grade
				$this->db->query("UPDATE code_grade SET code_id = '$first_code_id'
					WHERE code_id = '{$code->id}'");
				echo "code_grade updated: ".mysql_affected_rows()."<br />";
				// remove duplicate {code,type}
				$this->db->query("DELETE FROM codes WHERE id = '{$code->id}'");
			}
		
		}

		// remove duplicate {code_id, grade_id} in code_grade table
		$code_grade_dup = $this->db->query("SELECT *, count(*) as cnt FROM code_grade 
						group by code_id, grade_id having cnt > 1")->result();
		foreach($code_grade_dup as $dup){
			$grade_code_list = $this->db->get_where("code_grade", 
				array("code_id" => $dup->code_id, "grade_id" => $dup->grade_id))->result();
				echo count($grade_code_list);
			array_shift($grade_code_list);
			foreach($grade_code_list as $g_c){
				$this->db->query("DELETE FROM code_grade WHERE id = '{$g_c->id}'");
			}
		}
	}
}