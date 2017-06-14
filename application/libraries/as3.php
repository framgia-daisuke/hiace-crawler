<?php
/*
 * Amazon S3 utilities class
 * @author VuLD@LTT
 * @date 03/2012
 * last update 03/2012
 */
class As3
{
	private $bucket;
	private $local_dir;	
	private $tmp_dir;
	private $s3object;
	
	private $CI;
	
	function __construct()
	{
		require_once 'aws-sdk/sdk.class.php';

		$this->CI = & get_instance();
		
		$this->bucket = "iauc-img";// $this->CI->config->item("s3_bucket");
		$this->tmp_dir = FCPATH."tmp/img/";
		
		$this->s3object = new AmazonS3();	
	}
	
	function upload_image_to_s3($s3_dir, $local_dir, $filename)
	{
		$img_path = $local_dir.$filename;
		if(!file_exists($img_path)) return FALSE;
		$thumb = $this->create_local_thumb($local_dir, $filename);
		if($thumb){
			$img_uploaded = $this->upload_file_tos3($s3_dir, $this->tmp_dir, $filename);
			
			if($img_uploaded){
				@unlink($this->tmp_dir.$filename);
				return TRUE;
			}
		}
		return FALSE;
	}
	
	// upload a local file to s3
	function upload_file_tos3($s3_dir, $local_dir, $file_name, $opt = NULL)
	{
		$file_path_local = $local_dir.$file_name;
		$file_path_s3 = $s3_dir.$file_name;
		$response = $this->s3object->create_mpu_object($this->bucket, $file_path_s3,
		    array(
			    'fileUpload' => $file_path_local,
			    'acl' => AmazonS3::ACL_PUBLIC,
			    'storage' => AmazonS3::STORAGE_REDUCED,
				'headers'     => array( // raw headers
	                          'Cache-Control'    => 'max-age',
	                          'Expires'       => 'Tue, 31 Dec 2030 16:00:00 GMT',
		    	    		'Content-Type' => 'image/jpeg',
	          	),	    
			));				
		if($response->status == 200){
			return TRUE;
			//$file_url_s3 = str_replace(".s3.amazonaws.com", "", $s3_obj->get_object_url(BUCKET, $file_path_s3));
			//return $file_url_s3;
		}	
		return FALSE;
	}
	
	// create thumbnail
	// return thumb path on success or False on error
	function create_local_thumb($local_dir, $filename, $thumb_width = 470) 
	{
		$img_path = $local_dir."/".$filename; 
	    $img = imagecreatefromstring (file_get_contents($img_path));
	      $width = imagesx( $img );
	      $height = imagesy( $img );
	      if($width <= $thumb_width){
	      	if(copy($img_path, $this->tmp_dir.$filename)){
	      		return TRUE;
	      	}
	      	else{
	      		return FALSE;
	      	}
	      }
	
	      $new_width = $thumb_width;
	      $new_height = floor( $height * ( $thumb_width / $width ) );
	
	      $tmp_img = imagecreatetruecolor( $new_width, $new_height );
	
	      imagecopyresampled( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
	
	      $thumb_path = $this->tmp_dir.$filename;
	      $ok = imagejpeg( $tmp_img, $thumb_path, 75);
	      if(!$ok) return FALSE;
	      //crop image 
	      if($new_height > $new_width){
	      	$new_height =  $new_height > $new_width ? 470 : $new_height;
			$img = imagecreatefromjpeg($thumb_path); 
			$crop = imagecreatetruecolor($new_width, $new_height); 
			imagecopyresampled ( $crop, $img, 0, 0, 0, 0, $new_width, $new_height, $new_width, $new_height ); 
			if(imagejpeg($crop,$thumb_path)) return TRUE;       	      	
	      } 
	      elseif($ok){
	      	return TRUE;
	      }
	      return FALSE;
	}

	
}