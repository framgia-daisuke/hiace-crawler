<?php
/*
 * get image domain of an auction
 * PATH: /makers/type_id/conference_id/holding_id/auction_id/img_name.jpg
 */
function get_auction_img_domain($auction_obj)
{
	if(ENVIRONMENT == "development") return base_url().'data/img/';
	
	$CI = & get_instance();
	$now = date("Y-m-d H:i:s"); 
	$auction_insert_date = date("Y-m-d H:i:s", strtotime($auction_obj->insert_date));
	$offset_date = strtotime($now) - strtotime($auction_insert_date);

	$maker = $CI->auction->get_maker_by_id($auction_obj->maker_id);
	
	// if auction insert day = half of today, get image from local server 
	if($offset_date < 43200){
		$domain = base_url().'data/img/';
	}
	// otherwise get image from s3
	else{
		$domain = $CI->config->item("s3_url");
	}
	return $domain;
}

/*
 * Get maker name by id
 */
function get_maker_by_id($maker_id)
{
	$CI = & get_instance();
	$maker = $CI->auction->get_maker_by_id($maker_id);
	return $maker;
}

/*
 * Get maker list, filter by config(crawler config)
 */
function get_crawl_maker_list($filter = TRUE)
{
	$CI = & get_instance();	
	$crawl_maker_list = $CI->config->item("crawl_maker_list");
	$maker_list = array();
	foreach($crawl_maker_list as $maker_id){
		$maker_list[] = $CI->auction->get_maker_by_id($maker_id);
	}
	return $maker_list;
}

/*
 * Get type list by maker_id and filter from config
 */
function get_type_list_by_maker_id($maker_id, $config_filter = TRUE)
{
	$CI = & get_instance();
	$type_list = array();
	if($config_filter == TRUE){
		$crawl_type_list = $CI->config->item("crawl_type_list");			
		$type_list_cfg = array();
		foreach($crawl_type_list as $type_arr){
			$type_list_cfg = array_merge($type_list_cfg, $type_arr);
		}			
		$type_list = $CI->auction->get_type_list_by_maker_id($maker_id, $type_list_cfg);
	}
	else{
		$type_list = $CI->auction->get_type_list_by_maker_id($maker_id);
	}
	return $type_list;	
}