<?php
class Lookup extends CI_Controller
{
	function __construct()
	{
		parent::__construct();	
	}
	
	function index()
	{
		$maker_iauc_id = "00";
		$type_list = $this->auction->get_type_list_by_maker_iauc_id($maker_iauc_id);

		$data['maker_iauc_id'] = $maker_iauc_id;
		$data['maker'] = "Toyota";
		$data['type_list'] = $type_list;

		$this->load->view("db_view", $data);
	}
	function view()
	{
		$data['maker_list'] = $this->auction->get_maker_list();
		$data['type_list'] = array();
		$data['code_list'] = array();
		$data['grade_list'] = array();
		$this->load->view("view", $data);
	}
	function img()
	{
		$src = $this->input->get("src");
		if(!empty($src)){
			echo "<img src='{$src}' />";
		}
	}
	
	function look_up()
	{
		$maker_id = intval($this->input->post("maker_id"));
		$type_id = intval($this->input->post("type_id"));
		$code_id = intval($this->input->post("code_id"));
		$grade_id = intval($this->input->post("grade_id"));
		
		$result = $this->auction->look_up($maker_id, $type_id, $code_id, $grade_id);
		if($result == NULL) $result = array();
		echo json_encode($result);
	}
	
	
	function get_type_list($maker_id)
	{
		$type_list = $this->auction->get_type_list_by_maker_id($maker_id);
		echo "<option>--- Select Type ---</option>\n";
		foreach($type_list as $type)
		{
			echo "<option value='{$type->id}'>{$type->name_jp}</option>\n";
		}
	}	
	function get_code_list($type_id)
	{
		$code_list = $this->auction->get_code_list_by_type_id($type_id);		
		echo "<option>--- Select Code ---</option>\n";
		if($code_list != NULL)
		{
			foreach($code_list as $code)
			{
				echo "<option value='{$code->id}'>{$code->name}</option>\n";
			}
		}
	}
	function get_grade_list($code_id)
	{
		$grade_list = $this->auction->get_grade_list_by_code_id($code_id);
		echo "<option>--- Select Grade ---</option>\n";
		if($grade_list != NULL)
		{
			foreach($grade_list as $grade)
			{
				echo "<option value='{$grade->id}'>{$grade->name}</option>\n";
			}
		}
	}
	function get_all_grade($type_id)
	{
		//$code_list = $this->auction->get_code_list_by_type_id($type_id);
		$code_list = $this->db->query("SELECT * FROM codes WHERE type_id = '{$type_id}' GROUP BY name")->result();
		foreach($code_list as $code)
		{
			$grade_list = $this->auction->get_grade_list_by_code_id($code->id);
			foreach($grade_list as $grade)
			{
				echo "<option value='{$grade->name}'>{$grade->name}</option>\n";
			}
		}		
	}
	
}