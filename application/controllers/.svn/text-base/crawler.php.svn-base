<?php
error_reporting(E_ALL);
set_time_limit(0);
//header("Content-Type: text/html; charset=utf-8");

class Crawler extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('iauc_crawler');
	}
	
	function index()
	{
		$html = file_get_contents(FCPATH."/data/detail_20300.html");
		$code_name = "RZH112V";
		$mk_matched = preg_match("@{$code_name}.*([\d]{6,10})@", $html, $mk_matches);
			if($mk_matched){
			echo $mk_matches[1];
		}		
	}
	
	function run()
	{
		//$this->iauc_crawler->get_code_grade_only = TRUE;
		//$this->iauc_crawler->test();
		$this->iauc_crawler->do_login = TRUE;
		$this->iauc_crawler->set_server_location($this->config->item("server_location"));
		
		$today = date("l");
		
		$crawl_type_cfg = $this->config->item("crawl_type_list");
		$type_id_list = $crawl_type_cfg[$today];
		
		foreach($type_id_list as $type_id)
		{
			$type = $this->auction->get_type_by_id($type_id);
			$maker = $this->auction->get_maker_by_id($type->maker_id);

			//echo $type->id.":".$type->name_jp."<br />";
			$this->iauc_crawler->run($maker, $type);
			echo "<hr />";	
			flush();
			sleep(5);
		}		
		
	}
	function test()
	{
		$html = file_get_contents(FCPATH."html_check/9551.html");
		$html = mb_convert_encoding($html, "UTF-8", "SHIFT-JIS");
			$dom = new DOMDocument();
			@$dom->loadHTML($html);
			$xpath = new DOMXPath($dom);		
			$db_fields['year'] = $this->_layout3_get_value($html, $xpath, "year", '年式', 'å¹´å¼');
			$db_fields['cubic_capacity'] = $this->_layout3_get_value($html, $xpath, "cc",'排気量', "ææ°é");
			$db_fields['distance'] = $this->_layout3_get_value($html, $xpath, "distance", '走行', "èµ°è¡");
			$db_fields['shift'] = $this->_layout3_get_value($html, $xpath, "shift", 'シフト',  "ã·ãã");
			$db_fields['point'] = $this->_layout3_get_value($html, $xpath, "point", '評価点', "è©ä¾¡ç¹");
			var_dump($db_fields);		
	}
	function _layout3_get_value($html, $xpath, $field, $label1, $label2 = "")
	{
		$value = "";
		$q = $xpath->query("/html/body/form[3]/div[2]/table//*[text()[contains(.,'{$label1}')]]");
		if($q->length == 0){
			$q = $xpath->query("/html/body/form[3]/div[2]/table//*[text()[contains(.,'{$label2}')]]");
		}
		if($q->length > 0){
			$label_path = $q->item(0)->getNodePath();
			$last_tr_td_m = preg_match("@tr\[([0-9]+)\]/td\[([0-9]+)\]$@", $label_path, $matches);
			
			if($last_tr_td_m){
				$label_tr_index = $matches[1];
				$val_tr_index = $matches[1] + 1;
				
				$label_td_index = $matches[2];
				$val_td_index = $matches[2] + 1;
				$val_path = preg_replace("@tr\[([0-9]+)\]/td\[([0-9]+)\]$@", "tr[{$val_tr_index}]/td[{$label_td_index}]", $label_path);
				//echo $val_path."<br />";
				
				$val = $xpath->query($val_path);
				if($val->length > 0){
					$field_val = $val->item(0)->nodeValue;
					//echo $field_val;
					switch($field){
						case 'year':									
							if(preg_match("@([0-9]+)å¹´@", $field_val, $matches) || preg_match("@[HS]([0-9]+)@", $field_val, $matches)){
								$year = $matches[1];
								$value = $year;
							}
							break;
							
						case 'cc':
							$cc_m = preg_match("@([0-9]+)cc@", $field_val, $matches);
							if($cc_m) $value = $matches[1];	
															
							break;	
							
						case 'grade':
							$db_fields['grade'] = $field_val;
							break;
							
						case 'distance':
							$distance_m = preg_match("@([0-9]+)åkm@", $field_val, $matches);
							if($distance_m) $value = $matches[1];									
							break;
							
						case 'shift':
							$shift_m = preg_match("@([A-Z]+)@", $field_val, $matches);
							if($shift_m) $value = $matches[1];										
							break;			
						case 'point':
							if(intval($field_val) <= 6){
								$value = $field_val;
							}														
							break;											
						default: break;			
					}
				}
			}				
		}
		else{ // xpath failed
			switch($field){
				case 'year':
					if(preg_match("/<td.*>([0-9]{1,2})年/", $html, $matches) 
						|| preg_match("/<td.*>([0-9]{1,2})å¹´/", $html, $matches)
						|| preg_match("@[HS]([0-9]+)@", $html, $matches)){
						$value = $matches[1];
					}
					break;
				case 'cc':
					if(preg_match("/<td.*>([0-9]+)cc/", $html, $matches)){
						$value = $matches[1];
					}
					break;
				case 'distance':
					if(preg_match("/<td.*>([0-9]+).*km/", $html, $matches)){
						$value = $matches[1];
					}
					break;
				case 'shift':
					if(preg_match("@km.*\s*<\/td>\s*<td.*>\s*([MATF0-9]+)\s*<\/td>@", $html, $matches)){
						$value = $matches[1];
					}
					break;
				case 'point':
					if(preg_match("@km.*\s*</td>(\s*<td.*>.*</td>\s*)+<td.*>\s*([RBW0-6.]+)\s*<\/td>@", $html, $matches)){
						$value = $matches[2];
					}
					break;
			}
		}

		return $value;		
	}
		
	
	function test2()
	{
		$ch = curl_init("http://www.google.com.vn/");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);		
		$html = curl_exec($ch);
		echo $html;
	}
	function is_year_value($string)
	{
		if(preg_match("@([0-9]+)å¹´@", $string) || preg_match("@H([0-9]+)@", $string)){
			return TRUE;
		}
		return FALSE;
	}
	
	function gen_code_grade($type_name_jp)
	{
		$type_name_jp = rawurldecode($type_name_jp);
		$type = $this->auction->get_type_by_name_jp($type_name_jp);
		if($type == NULL) die("Type not found!");
		
		$file = FCPATH."data/prertinf03.html";
		$html = mb_convert_encoding(file_get_contents($file), "UTF-8", "SHIFT-JIS");
		$code_matched = preg_match("/arrKata = (.*);/", $html, $matches);
		if($code_matched){
			$code_list = json_decode($matches[1]); // CODE LIST
			foreach($code_list as $name => $id){
				$this->db->query("INSERT INTO codes(type_id, name, iauc_id) VALUES('{$type->id}', '{$name}', '{$id}')");
				$code_id = $this->db->insert_id();
				$grade_matched = preg_match("/arrType{$id} = (.*);/", $html, $matches);
				if($grade_matched){
					$grade_list = json_decode($matches[1]);
					foreach($grade_list as $name => $encoded){
						$this->db->query("INSERT INTO grades(code_id, name, encoded) VALUES('{$code_id}', '{$name}', '{$encoded}')");		
					}
				}
			}
		}
		
	}
	// generate type list for each maker. RUN ONCE
	function gen_type_list()
	{
		$file = FCPATH."data/prertinf02.html";
		$html = mb_convert_encoding(file_get_contents($file), "UTF-8", "SHIFT-JIS");
		
		$maker_list = $this->db->get("makers")->result();
		foreach($maker_list as $maker){
			$matched = preg_match("/arrType{$maker->iauc_id} = (.*);/", $html, $matches);
			if($matched){
				$type_list = json_decode($matches[1]);
				foreach($type_list as $name => $encoded){
					$this->db->query("insert into car_types(maker_iauc_id, name_jp, encoded) values('{$maker->iauc_id}', '$name', '$encoded');");
				}
			}
		}
	}
	function update_type()
	{
		$maker_list = $this->auction->get_maker_list();
		foreach($maker_list as $m)
		{
			$this->db->query("UPDATE types SET maker_id = '{$m->id}' WHERE maker_iauc_id = '{$m->iauc_id}'");			
		}
	}
	
	function update_code_grade()
	{
		$auction_list = $this->db->get("auction")->result();
		foreach($auction_list as $auc){
			if(!$this->auction->code_grade_exists($auc->code_id, $auc->grade_id)){
				$this->auction->add_code_grade($auc->code_id, $auc->grade_id);
			}
		}
	}
	
	// check once
	function type_count()
	{
		$this->iauc_crawler->get_total_result_only = TRUE;
		$type_id_list = $this->config->item("crawl_type_list");
		
//		for($i = 0; $i < 31; $i++) array_shift($type_id_list);
//
		$type_list = array();
		foreach($type_id_list as $t){
			if($t != 425) continue;
			$type = $this->auction->get_type_by_id($t);
			$maker = $this->auction->get_maker_by_id($type->maker_id);
			$type->maker_iauc_id = $maker->iauc_id;
			array_push($type_list, $type);	
		}

//		
//		$first = array_shift($type_list);
//		$this->iauc_crawler->do_login = TRUE;
//		echo $first->id.":".$first->name_jp."<br />";
//		$this->iauc_crawler->run($first->maker_id, $first->maker_iauc_id, $first->id, $first->encoded);
//		echo "<hr />";	

		$this->iauc_crawler->do_login = TRUE;
		foreach($type_list as $type){
			echo $type->id.":".$type->name_jp."<br />";
			$this->iauc_crawler->run($type->maker_id, $type->maker_iauc_id, $type->id, $type->encoded);
			echo "<hr />";	
			flush();
			sleep(3);
		}
	}
}