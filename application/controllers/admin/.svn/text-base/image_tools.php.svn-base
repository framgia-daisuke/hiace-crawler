<?php
class Image_tools extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('as3');
	}
	
	// run daily
	function move_image_to_s3()
	{
		$today = date("Y-m-d");
		$this->db->select("maker_id, type_id, conference_id, holding_id, auction_id, img");
		$this->db->where("insert_date >=", $today);
		$q = $this->db->get("auction");
		if($q->num_rows() > 0)
		{
			$auction_list = $q->result();
			foreach($auction_list as $a)
			{
				if(empty($a->img)) continue;
				$img_list = explode(",", $a->img);
				$maker = $this->auction->get_maker_by_id($a->maker_id);
				$s3_dir = $maker->name_en."/".$a->type_id."/".$a->conference_id."/".$a->holding_id."/".$a->auction_id."/";
				$local_dir = FCPATH."data/img/".$s3_dir;
				foreach($img_list as $img){
					if($this->as3->upload_image_to_s3($s3_dir, $local_dir, $img)){
						//echo "OK";
						$this->remove_local_file($local_dir.$img);
					}
					else{
						//echo "FAILED";
					}
				}
			}
		}
	}
	// remove local images after uploading successfully
	function remove_local_files($dir)
	{
		$file_list = scandir($dir);
		foreach($file_list as $file){
			if($file != '.' && $file != '..') $this->remove_local_file($dir.$file);
		}
	}	
	function remove_local_file($file)
	{
		unlink($file);
	}
}