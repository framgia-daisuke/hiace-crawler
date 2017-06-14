<?php
class Auction_list extends CI_Controller
{
	function __construct()
	{
		parent::__construct();	
	}
	
	function index()
	{
		$data['maker_list'] = get_crawl_maker_list();// $this->auction->get_maker_list();
		$data['type_list'] = array();
		$data['code_list'] = array();
		$data['grade_list'] = array();
		$data['span_list'] = array();
		

		$maker_id = intval($this->input->get("maker"));
		$type_id = intval($this->input->get("type"));
		$code_id = intval($this->input->get("code"));
		$grade_id = intval($this->input->get("grade"));
		$order_by = $this->input->get("order_by");
		$order_type = $this->input->get("order_type");
		$page = intval($this->input->get("page"));
		//$limit = intval($this->input->get('filter'));
		$year1 = intval($this->input->get('year1'));
		$year2 = intval($this->input->get('year2'));
		$distance1 = intval($this->input->get('distance1'));
		$distance2 = intval($this->input->get('distance2'));
		$point1 = $this->input->get('point1');
		$point2 = $this->input->get('point2');
		$shift = $this->input->get('shift');
		$color = $this->input->get('color');
		$span = intval($this->input->get('span'));
		$limit=50;
		$count1 = FALSE;
		if ($page==0 || $page==1) $page = 1;
		if ($order_by==FALSE) $order_by='id';
		if ($order_type==FALSE) $order_type='asc';
			
		$data['maker_id'] = $maker_id;
		$data['type_id'] = $type_id;
		$data['code_id'] = $code_id;
		$data['grade_id'] = $grade_id;
		$data['order_by'] = $order_by;
		$data['order_type'] = $order_type;
		$data['page'] = $page;
		$data['count1'] = $count1;
		$data['limit'] = $limit;
		$data['year1'] = $year1;
		$data['year2']= $year2;
		$data['distance1']= $distance1;
		$data['distance2'] = $distance2;
		$data['point1'] = $point1;
		$data['point2'] = $point2;
		$data['shift'] = $shift;
		$data['color'] = $color;
		$data['span'] = $span;
		
		$year_conversion = $this->config->item("year_conversion");
			$year_reverse = array_flip($year_conversion);
			$data['year_reverse'] = $year_reverse;
		$distance_list = $this->config->item("distance_list");
		$data['distance_list'] = $distance_list;
		$point_list = $this->config->item("point_list");
		$data['point_list'] = $point_list;
		$shift_list = $this->config->item("shift_list");
		$color_list = $this->config->item("color_list");
		$span_list = $this->config->item("span_list");
		$data['shift_list'] = $shift_list;
		$data['color_list'] = $color_list;
		$data['span_list'] = $span_list;
		$data['do_lookup'] = FALSE;
		
		if($maker_id > 0)
		{
			//pagination
			$this->load->library('pagination');
			$config['base_url'] = base_url()."admin/auction_list?maker=".$maker_id."&type=".$type_id."&code=".$code_id."&grade=".$grade_id."&color=".$color."&year1=".$year1."&year2=".$year2."&shift=".$shift."&distance1=".$distance1."&distance2=".$distance2."&point1=".$point1."&point2=".$point2."&span=".$span."&order_by=".$order_by."&order_type=".$order_type;
			$total_rows = $this->auction->look_up($maker_id, $type_id, $code_id, $grade_id,$color,$year1,$year2,$shift,$distance1,$distance2,$point1,$point2,$span,$order_by,$order_type,$page,TRUE);
			$config['total_rows'] = $total_rows;
			$config['per_page'] = $limit;
			$config['use_page_numbers'] = TRUE;
			$config['page_query_string'] = TRUE;
			$config['query_string_segment'] = 'page'; 
			$config['num_links'] = 10;
	
			$this->pagination->initialize($config); 
	
			//end
			
			$data['do_lookup'] = TRUE;
			
			// year conversion
			
			// end year conversion
			$data['type_list'] = get_type_list_by_maker_id($maker_id);

		
			if($type_id > 0 && $code_id==0) {
				$data['code_list'] = $this->auction->get_code_list_by_type_id($type_id);
				$data['grade_list'] = $this->auction->get_grade_list_by_type_id($type_id);
			}
			else if ($type_id > 0 && $code_id>0){
				$data['code_list'] = $this->auction->get_code_list_by_type_id($type_id);
				$data['grade_list'] = $this->auction->get_grade_list_by_code_id($code_id);
			}
					
			$result = $this->auction->look_up($maker_id, $type_id, $code_id, $grade_id, $color, $year1,$year2,$shift,$distance1,$distance2,$point1,$point2,$span,$order_by,$order_type,$page,$count1);
			if($result == NULL) $result = array();
			
			$data['lookup_result'] = $result;
			$data['total_result'] = $total_rows;
			$data['current_page'] = $page;
			$data['pagination'] = $this->pagination->create_links();
		}
		$this->load->view("auction_list", $data);
	}
	
	function img()
	{
		$src = $this->input->get("src");
		if(!empty($src)){
			echo "<img src='{$src}' />";
		}
	}
	
	function get_type_list($maker_id)
	{
		$type_list = get_type_list_by_maker_id($maker_id);
		echo "<option value='0'>車種</option>\n";
		foreach($type_list as $type)
		{
			echo "<option value='{$type->id}'>{$type->name_jp}</option>\n";
		}
	}	
	function get_code_list($type_id)
	{
		$code_list = $this->auction->get_code_list_by_type_id($type_id);		
		echo "<option value='0'>型式</option>\n";
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
		echo "<option value='0'>グレード</option>\n";
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
		echo "<option value='0'>グレード</option>\n";
		foreach($code_list as $code)
		{
			$grade_list = $this->auction->get_grade_list_by_code_id($code->id);
			foreach($grade_list as $grade)
			{
				echo "<option value='{$grade->id}'>{$grade->name}</option>\n";
			}
		}		
	}
	function get_grade_list_type($type_id)
	{
		$grade_list = $this->auction->get_grade_list_by_type_id($type_id);
		echo "<option value='0'>グレード</option>\n";
		if($grade_list != NULL)
		{
			foreach($grade_list as $grade)
			{
				echo "<option value='{$grade->id}'>{$grade->name}</option>\n";
			}
		}
	}
	
}
