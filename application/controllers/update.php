<?php
header("Content-Type: text/plain; charset=utf-8"); 

class Update extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		$this->output->enable_profiler(TRUE);
		$type_id = 129;
		$code_list = $this->db->get_where("codes", array("type_id" => $type_id))->result();
		$code_id_list = array();
		
		foreach($code_list as $code){
			$code_id_list[] = $code->id;			
		}		
		
		$this->benchmark->mark('grades_start');

		$code_str = implode(",", $code_id_list);
		$q2 = $this->db->query("SELECT * FROM grades where code_id IN ($code_str) group by name")->result();		
		echo count($q2);
		$this->benchmark->mark('grades_end');
		/*------------------------------*/
		$this->benchmark->mark('grades2_start');

		$this->db->select("grades2.*");
		$this->db->join("code_grade", "code_grade.grade_id = grades2.id");
		$this->db->where("code_grade.code_id IN ($code_str)");
		$this->db->group_by("grades2.id");
		$q3 = $this->db->get("grades2")->result();
		echo count($q3)."<br />";
		$this->benchmark->mark('grades2_end');

		var_dump($q2); var_dump($q3);		
		

	}
	function code_grade()
	{
		$grade_list = $this->db->get("grades")->result();
		foreach($grade_list as $grade)
		{
			$grade2_id = $this->db->query("select id from grades2 where name = '{$grade->name}'")->row()->id;
			$this->db->query("INSERT INTO code_grade(code_id, grade_id) values('{$grade->code_id}', '{$grade2_id}')");
		}
		echo "DONE";
	}
}