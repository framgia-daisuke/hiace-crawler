<?php
class Auction_show extends CI_Controller
{
	function __construct()
	{
		parent::__construct();	
	}
	
	function index()
	{

		$conference_id = intval($this->input->get("conference_id"));
		$holding_id = intval($this->input->get("holding_id"));
		$auction_id = intval($this->input->get("auction_id"));
		$type_id = intval($this->input->get("type_id"));
		$auction = $this->auction->get_auction($auction_id,$conference_id,$holding_id,$type_id);
		$maker = $this->auction->get_maker_by_id($auction->maker_id);			
		$type = $this->auction->get_type($auction->type_id);
		$code = $this->auction->get_code($auction->code_id);
		$grade = $this->auction->get_grade($auction->grade_id);
		$year_conversion = $this->config->item("year_conversion");
		$year_reverse = array();
			foreach($year_conversion as $jp => $std){
				$year_reverse[$std] = $jp;
			}
			$data['year_reverse'] = $year_reverse;
		$data['conference_id'] = $conference_id;
		$data['holding_id'] = $holding_id;
		$data['maker_name'] = $maker->name_jp;
		$data['type_name'] = $type->name_jp;
		$data['code_name'] = $code->name;
		$data['grade_name'] = $grade->name;
		$data['auction'] = $auction;
		$this->load->view("auction_show", $data);
	} 
}