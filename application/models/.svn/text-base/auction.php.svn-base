<?php
class Auction extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function add($data = array())
	{
		$this->db->insert("auction", $data);
	}
	
	/*
	 * Check if auction already exists
	 */
	function auction_exists($type_id, $conference_id, $holding_id, $auction_id)
	{
		$this->db->select('id');
		$this->db->where('type_id', $type_id);
		$this->db->where('conference_id', $conference_id);
		$this->db->where('holding_id', $holding_id);
		$this->db->where('auction_id', $auction_id);
		$q = $this->db->get('auction');
		if ($q->num_rows() > 0) return TRUE;
		return FALSE;
	}
	
	/*
	 * Ge maker list
	 */
	function get_maker_list()
	{
		return $this->db->get("makers")->result(); 
	}
	/*
	 * Get maker by id
	 */
	function get_maker_by_id($maker_id)
	{
		$this->db->where("id", $maker_id);
		$q = $this->db->get("makers");
		if($q->num_rows() > 0) return $q->row();
		return NULL;		
	}
	/*
	 * Get maker by iauc id
	 */
	function get_maker_by_iauc_id($maker_iauc_id)
	{
		$this->db->where("iauc_id", $maker_id);
		$q = $this->db->get("makers");
		if($q->num_rows() > 0) return $q->row();
		return NULL;		
	}
	/*
	 * get type list by maker_id
	 * Filter: type_list array from config
	 */
	function get_type_list_by_maker_id($maker_id, $filter = NULL)
	{
		$this->db->where("maker_id", $maker_id);
		$q = $this->db->get("types");
		if($q->num_rows() > 0){
			$type_list = $q->result();
			if($filter !== NULL){
				foreach($type_list as $key => $type){
					if(!in_array($type->id, $filter)) unset($type_list[$key]);
				}
			}
			return $type_list;
		} 
		return NULL;
	}
	
	
	/*
	 * get type list by maker_iauc_id
	 */
	function get_type_list_by_maker_iauc_id($maker_iauc_id)
	{
		$this->db->where("maker_iauc_id", $maker_iauc_id);
		$q = $this->db->get("types");
		if($q->num_rows() > 0) return $q->result();
		return NULL;
	}
	/*
	 * Get type by id
	 */
	function get_type_by_id($type_id)
	{
		$this->db->where("id", $type_id);
		$q = $this->db->get("types");
		if($q->num_rows() > 0){
			return $q->row();
		}
		return NULL;
	}
	/*
	 * Get car type by name_jp
	 */
	function get_type_by_name_jp($type_name_jp)
	{
		$this->db->where("name_jp", $type_name_jp);
		$q = $this->db->get("types");
		if($q->num_rows() > 0){
			return $q->row();
		}
		return NULL;
	}
	/*
	 * Get code list by type id
	 */
	function get_code_list_by_type_id($type_id)
	{
		$this->db->where("type_id", $type_id);
		//$this->db->group_by("name");
		$this->db->order_by("name", "asc");
		$q = $this->db->get("codes");
		if($q->num_rows() > 0) return $q->result();
		return NULL;
	}
	/*
	 * Get code by id
	 */
	function get_code_by_id($code_id)
	{
		$this->db->where("id", $code_id);
		$q = $this->db->get("codes");
		if($q->num_rows() > 0){
			return $q->row();
		}
		return NULL;		
	}
	
	/*
	 * Get code by name
	 */
	function get_code_by_name($code_name)
	{
		$this->db->where("name", $code_name);
		$q = $this->db->get("codes");
		if($q->num_rows() > 0){
			return $q->row();
		}
		return NULL;		
	}
	/*
	 * Get pair type, code
	 */
	function get_code_type($code_name, $type_id)
	{
		$this->db->select("id");
		$this->db->where("type_id", $type_id);
		$this->db->where("name", $code_name);
		$q = $this->db->get("codes");
		if($q->num_rows() > 0) return $q->row()->id;
		return NULL;
	}
	/*
	 * Insert new code when needed
	 */		
	function add_code($code_name, $type_id, $iauc_id = "")
	{
		$q = $this->db->query("INSERT INTO codes(name, type_id, iauc_id) VALUES('$code_name', '$type_id', '$iauc_id')");
		return $this->db->insert_id();
	}
	/*
	 * Get grade list by code id
	 */
	function get_grade_list_by_code_id($code_id)
	{
		$this->db->where("code_id", $code_id);
		//$this->db->order_by("name", "asc");
		$q = $this->db->get("code_grade");
		if($q->num_rows() > 0)
		{
			$grade_list = $q->result();
			foreach($grade_list as &$grade){
				$grade = $this->get_grade_by_id($grade->grade_id);
			}
			return $grade_list;
		}
		return NULL;		
	}
	/*
	 * Get grade by ID 
	 */
	function get_grade_by_id($grade_id)
	{
		$this->db->where("id", $grade_id);
		$q = $this->db->get("grades");
		if($q->num_rows() > 0){
			return $q->row();
		}
		return NULL;			
	}
	
	/*
	 * Get grade by name
	 */
	function get_grade_by_name($grade_name)
	{
		$this->db->where("name", $grade_name);
		$q = $this->db->get("grades");
		if($q->num_rows() > 0){
			return $q->row();
		}
		return NULL;			
	}
	/*
	 * Add grade
	 */
	function add_grade($grade_name, $code_id = NULL)
	{
		$encoded = rawurlencode($grade_name);
		$this->db->query("INSERT INTO grades(name, encoded) VALUES('$grade_name', '$encoded')");
		$grade_id = $this->db->insert_id();
		if($code_id != NULL){
			$this->add_code_grade($code_id, $grade_id);
		}
		return $grade_id;
	}
	/*  
	 * Check if a pair of code, grade exists 
	 */
	function code_grade_exists($code_id, $grade_id)
	{
		$this->db->where("code_id", $code_id);
		$this->db->where("grade_id", $grade_id);
		$q = $this->db->get("code_grade");
		
		if($q->num_rows() > 0) return TRUE;
		return FALSE;
	}
	/*
	 * Add code_grade pair
	 */
	function add_code_grade($code_id, $grade_id)
	{
		$this->db->query("INSERT INTO code_grade(code_id, grade_id) VALUES('$code_id', '$grade_id')");
	}
	
	/*
	 * LOOK UP
	 */
	function look_up($maker_id, $type_id, $code_id, $grade_id, $color,$year1,$year2,$shift,$distance1,$distance2,$point1,$point2,$span, $order_by='id',$order_type='asc',$page,$count=False)
	{
		$order_by_arr = array(
			'id' => 'auction.auction_id',
			'conferences' => 'conference_name',
			'grades' => 'grade_name',
			'year' => 'auction.year',
			'types' => 'type_name',
			'codes' => 'code_name',
			'cubic_capacity' => 'auction.cubic_capacity',
			'distance' => 'auction.distance',
			'color' => 'auction.color',
			'start_price' => 'auction.start_price',
			'result_price' => 'auction.result_price'
		);
		$this->db->from('auction');		
		if (!$count){
			$this->db->select('auction.*');
			$this->db->select('grades.name as grade_name');
			$this->db->select('codes.name as code_name');
			$this->db->select('types.name_jp as type_name');
			$this->db->select('conferences.name as conference_name');
		}
		else{
			$this->db->select("count(auction.id) as total_rows");
		}
		//$this->db->from('conferences');
		$this->db->join('conferences','conferences.id=auction.conference_id');
		$this->db->join('grades','grades.id=auction.grade_id');
		$this->db->join('codes','codes.id=auction.code_id');
		$this->db->join('types','types.id=auction.type_id');
		if($maker_id > 0) $this->db->where("auction.maker_id", $maker_id);
		if($type_id > 0) $this->db->where("types.id", $type_id);
		if($code_id > 0) $this->db->where("codes.id", $code_id);
		if($grade_id > 0) $this->db->where("grades.id", $grade_id);
		if ($span > 0):
			switch ($span) {
		    case 30:
		        $this->db->where("auction.auction_day BETWEEN date_sub(curdate(), INTERVAL 30 DAY) AND CURDATE() ");
		        break;
		    case 60:
		        $this->db->where("auction.auction_day BETWEEN date_sub(curdate(), INTERVAL 60 DAY) AND CURDATE() ");
		        break;
		    case 90:
		        $this->db->where("auction.auction_day BETWEEN date_sub(curdate(), INTERVAL 90 DAY) AND CURDATE() ");
		        break;
		    case 120:
		        $this->db->where("auction.auction_day BETWEEN date_sub(curdate(), INTERVAL 120 DAY) AND CURDATE() ");
		        break;
		    case 150:
		        $this->db->where("auction.auction_day BETWEEN date_sub(curdate(), INTERVAL 150 DAY) AND CURDATE() ");
		        break;
		    case 180:
		        $this->db->where("auction.auction_day BETWEEN date_sub(curdate(), INTERVAL 180 DAY) AND CURDATE() ");
		        break;
		    case 1:
		        $this->db->where("auction.auction_day BETWEEN date_sub(curdate(), INTERVAL 1 YEAR) AND CURDATE() ");
		        break;
		   	case 2:
		        $this->db->where("auction.auction_day BETWEEN date_sub(curdate(), INTERVAL 2 YEAR) AND CURDATE() ");
		        break;
			case 3:
		    	$this->db->where("auction.auction_day BETWEEN date_sub(curdate(), INTERVAL 3 YEAR) AND CURDATE() ");
		        break;
			}
		endif;
		if(!empty($color)) $this->db->like("auction.color", $color);
		if ($year1 == 1983) $this->db->where("auction.year <=", $year1);
		else if($year1 > 0) $this->db->where("auction.year >=", $year1);
		if($year2 > 0) $this->db->where("auction.year <=", $year2);
		if($distance1 > 0) $this->db->where("auction.distance >=", $distance1);
		if($distance2 > 0) $this->db->where("auction.distance <=", $distance2);
		if(!empty($point1)) $this->db->where("auction.point >=", $point1);
		if(!empty($point2)) $this->db->where("auction.point <=", $point2);
		if(!empty($shift)) $this->db->where("auction.shift", $shift);
		
		if (!$count) $this->db->order_by($order_by_arr[$order_by],$order_type);
		if (!$count) $this->db->limit(50,50*($page-1));
		$q = $this->db->get();
		if ($count) return $q->row()->total_rows; 
		if($q->num_rows() > 0) return $q->result();
		return NULL;
	}
	
	/*
	 * Conference
	 */
	function get_conference($confer_id)
	{
		$q = $this->db->get_where("conferences", array("id" => $confer_id));
		if($q->num_rows() > 0){
			return $q->row();
		}
		return NULL;
		
	}
	function get_grade_list_by_type_id($type_id)
	{
		$this->db->select("grades.*");
		$this->db->from("codes");
		$this->db->from("grades");
		$this->db->join("code_grade","code_grade.code_id=codes.id AND grades.id = code_grade.grade_id");
		$this->db->group_by("code_grade.grade_id");
		$this->db->where("codes.type_id", $type_id);		
		//$this->db->where("grades.id = code_grade.grade_id");
		$q = $this->db->get();
		if($q->num_rows() > 0){
			return $q->result();
		}
		return NULL;
	}
	/* grades*/
	function get_grade($grade_id)
	{
		$q = $this->db->get_where("grades", array("id" => $grade_id));
		if($q->num_rows() > 0){
			return $q->row();
		}
		return NULL;
		
	}
	/*codes*/
	function get_code($code_id)
	{
		$q = $this->db->get_where("codes", array("id" => $code_id));
		if($q->num_rows() > 0){
			return $q->row();
		}
		return NULL;
		
	}
	/*types*/
	function get_type($type_id)
	{
		$q = $this->db->get_where("types", array("id" => $type_id));
		if($q->num_rows() > 0){
			return $q->row();
		}
		return NULL;
		
	}
	function conference_exists($confer_id)
	{
		$this->db->where("id", $confer_id);
		$q = $this->db->get("conferences");
		if($q->num_rows() > 0){
			return TRUE;
		}
		return FALSE;
	}
	// add conference
	function add_conference($confer_id, $confer_name)
	{
		$this->db->query("INSERT INTO conferences(id, name) VALUES('{$confer_id}', '{$confer_name}')");
	}
	function get_auction($auctionId,$coferenceId,$holdingId,$typeId)
	{
		$q = $this->db->get_where("auction", array("auction_id" => $auctionId,"conference_id" => $coferenceId,"holding_id" => $holdingId,"type_id" => $typeId));
		if($q->num_rows() > 0){
			return $q->row();
		}
		return NULL;
	}
}