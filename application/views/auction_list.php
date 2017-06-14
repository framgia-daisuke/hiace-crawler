<?php
$auction_field_list = array(
	"auction_id" => "Auction ID",
	"unique_number" => "Unique number",
	"year"		=> "Year",
	"distance"	=> "Distance(千km)",
	"point"		=> "Point",
	"start_price" => "Start Price(万円)",
	"result_price" => "End Price(万円)",
	"color"		=> "Color",
	"cooling"	=> "Cooling",
	"cubic_capacity"	=> "CC",
	"capacity"		=> "Capacity",
	"loading"	=> "Loading(Kg)",
	"shift"		=> "Shift",
	"equipment"	=> "Equipment",
	"body"		=> "Body",
	"fuel"		=> "Fuel",
	"venue"		=> "Venue",
	"corner"	=> "Corner",
	"comment"	=> "Comment",
	"img"		=> "IMG",
	
);
?>
<html>
	<head>
		<title>Auction viewer</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		<link rel="stylesheet" href="<?php echo base_url()?>static/css/main.css" type="text/css">
		<link rel="stylesheet" href="<?php echo base_url()?>static/css/preintgdtl0102inccol01.css" type="text/css">
		<link rel="stylesheet" href="<?php echo base_url()?>static/css/btnMylist.css" type="text/css">
		<link rel="stylesheet" href="<?php echo base_url()?>static/css/btnDetail.css" type="text/css">
		
		<style type="text/css">
		div.clear{
			clear: both;
		}
		</style>
		
		<!-- Ext JS 
		<link rel="stylesheet" type="text/css" href="<?php echo base_url().'js/extjs/css/ext-all-access.css'?>" />		
		<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>js/extjs/css/example.css" />
		<script type="text/javascript" src="<?php echo base_url()?>js/extjs/bootstrap.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/extjs/auction.js"></script>

		-->		
		<script type="text/javascript" src="<?php echo base_url().'static/js/jquery.min.js'?>"></script>
		<script type="text/javascript">
		var auction_field = {
			<?php
			//foreach($auction_field_list as $k => $v){
				//echo "$k: '$v',\n";
			//}
			?>
		};
		
		
		type_id1 = 0;
		function on_maker_change(maker_id)
		{
			$("#type").load("<?php echo base_url().'admin/auction_list/get_type_list/'?>" + maker_id);
			$("#code").html("<option value='0'>型式</option>");
			$("#grade").html("<option value='0'>グレード</option>");	
		}

		
		
		function on_type_change(type_id)
		{
			
			type_id1 = type_id; //set type_id for filter grade
			$("#code").load("<?php echo base_url().'admin/auction_list/get_code_list/'?>" + type_id);
			//$("#grade").html("<option value='0'>--- Select Grade ---</option>");
			$("#grade").load("<?php echo base_url().'admin/auction_list/get_grade_list_type/'?>" + type_id);			
		}	
		function on_code_change(code_id)
		{
			if (type_id1 == 0) type_id1 = <?php echo $type_id?>;
			if (code_id >0) $("#grade").load("<?php echo base_url().'admin/auction_list/get_grade_list/'?>" + code_id);
			else $("#grade").load("<?php echo base_url().'admin/auction_list/get_grade_list_type/'?>" + type_id1);
						
		}
	
		// look up
		function look_up()
		{

		}
		function on_year1_change(year1)
		{
			if (year1 == 1983) $("#year2").attr("disabled","true"); else $("#year2").removeAttr("disabled"); 
		}
		function on_filter_change()
		{
			document.auction_list.submit();
		}
		function display_img(img){
			img_val = $("#auc_img input:first-child").val();
			if(img_val != "")
			{
				img_src = "<?php echo base_url().'data/img/'?>" + img_val;
				auc_img_thumb = $("#auc_img_thumb").val();
				if(auc_img_thumb == undefined){				
					$("#auc_img").parent().append("<img id='auc_img_thumb' width='120' src='" + img_src + "' onclick='open_img(this.src)' style='cursor: pointer' title='click for full size' />");
				}
				else{
					$("#auc_img_thumb").attr("src", img_src);
				}
			}
		}
		function open_img(img_src)
		{
			window.open("<?php echo base_url().'db_view/img?src='?>" + img_src, "Auction_image", "width=640, height=480");
		}
		</script>
		
		<style type="text/css">
		#filter select{
			width: 150px;
		}
		</style>
	</head>
	<body>
		<div id="main_container">
			<div id="filter" style="float: left;">
				<form method="get" action="<?php echo base_url().'admin/auction_list'?>" name="auction_list">
				<table>
				<tr>
					<td>
					<select name="maker" id="maker" onchange="on_maker_change(this.options[selectedIndex].value)">
						<option value="0">メーカー</option>
						<?php foreach($maker_list as $maker):?>
						<?php if($maker->id == $maker_id):?>
						<option value="<?php echo $maker->id?>" selected="selected"><?php echo $maker->name_jp?></option>
						<?php else:?>
						<option value="<?php echo $maker->id?>"><?php echo $maker->name_jp?></option>
						<?php endif;?>
						<?php endforeach;?>
					</select>
					</td>
					<!-- Type -->
					<td>
					<select name="type" id="type" onchange="on_type_change(this.options[selectedIndex].value)">
						<option value="0">車種</option>
						<?php foreach($type_list as $type):?>
						<?php if($type->id == $type_id):?>
						<option value="<?php echo $type->id?>" selected="selected"><?php echo $type->name_jp?></option>
						<?php else:?>
						<option value="<?php echo $type->id?>"><?php echo $type->name_jp?></option>
						<?php endif;?>
						<?php endforeach;?>
					</select>
					</td>
					<!-- Code -->
					<td>		
					<select name="code" id="code" onchange="on_code_change(this.options[selectedIndex].value)">
						<option value="0">型式</option>
						<?php foreach($code_list as $code):?>
						<?php if($code->id == $code_id):?>
						<option value="<?php echo $code->id?>" selected="selected"><?php echo $code->name?></option>
						<?php else:?>
						<option value="<?php echo $code->id?>"><?php echo $code->name?></option>
						<?php endif;?>
						<?php endforeach;?>
					</select>				
					</td>
					<td>				
					<select name="grade" id="grade">
						<option value="0">グレード</option>
						<?php foreach($grade_list as $grade):?>
						<?php if($grade->id == $grade_id):?>
						<option value="<?php echo $grade->id?>" selected="selected"><?php echo $grade->name?></option>
						<?php else:?>
						<option value="<?php echo $grade->id?>"><?php echo $grade->name?></option>
						<?php endif;?>
						<?php endforeach;?>						
					</select>
					</td>
					<td>				
					<select name="color" id="color">
						<option value="0">Select Color</option>
						<?php foreach($color_list as $key => $value):?>
						<?php if ($key == $color):?>
						<option value = "<?php echo $key?>" selected="selected"><?php echo $value ?></option>
						<?php else:?>
						<option value = "<?php echo $key?>" ><?php echo $value ?></option>
						<?php endif;?>
						<?php endforeach;?>						
					</select>
					</td>
					<td>
					<!--<input type="submit" value="Lookup" />-->
		
									<select class="frm" name="year1" id="year1" style="vertical-align:middle;" onchange="on_year1_change(this.options[selectedIndex].value)">
										<option value="0">指定なし~</option>
										<?php if ($year1 == 1983):?>
										<option value="1983" selected="selected">~S58</option>
										<?php else:?>
										<option value="1983">~S58</option>
										<?php endif;?>
										<?php foreach ($year_reverse as $value=>$key):?>
										<?php if ($value >=1984):?>
										<?php if ($value==$year1):?>
										<option style="vertical-align:middle;" value="<?php echo $value;?>" selected="selected"><?php if ($key<=63 && $key>=40) echo "S".$key; else echo "H".$key;?></option>
										<?php else:?>
										<option style="vertical-align:middle;" value="<?php echo $value;?>"><?php if ($key<=63 && $key>=40) echo "S".$key; else echo "H".$key;?></option>
										<?php endif;?>
										<?php endif;?>
										<?php endforeach;?>
									</select>
					</td>
					<td>
									<?php if ($year1 == 1983):?>
									<select class="frm" name="year2" id="year2" disabled="disabled">
									<?php else:?>
									<select class="frm" name="year2" id="year2">
									<?php endif;?>
										<option value="0">指定なし</option>
										<?php foreach ($year_reverse as $value=>$key):?>
										<?php if ($value >=1984):?>
										<?php if ($value==$year2):?>
										<option value="<?php echo $value;?>" selected="selected"><?php if ($key<=63 && $key>=40) echo "S".$key; else echo "H".$key;?></option>
										<?php else:?>
										<option value="<?php echo $value;?>"><?php if ($key<=63 && $key>=40) echo "S".$key; else echo "H".$key;?></option>
										<?php endif;?>
										<?php endif;?>
										<?php endforeach;?>
									</select>
						
					</td>
					</tr>
					<tr>
					<td>
					
						<select class="frm" size="1" name="shift">
							<option value="0">指定なし</option>
							<?php foreach ($shift_list as $key => $value):?>
							<?php if ($key==$shift):?>
							<option value="<?php echo $key;?>" selected="selected"><?php echo $value;?></option>
							<?php else:?>
							<option value="<?php echo $key;?>"><?php echo $value;?></option>
							<?php endif;?>
							<?php endforeach;?>
						</select>
					
					</td>
					<td>
					
						
										<select class="frm" name="distance1">
											<option value="0">指定なし~</option>
											<?php foreach ($distance_list as $key => $value):?>
											<?php if ($key==$distance1):?>
											<option value="<?php echo $key;?>" selected="selected"><?php echo $value."万km";?></option>
											<?php else:?>
											<option value="<?php echo $key;?>"><?php echo $value."万km";?></option>
											<?php endif;?>
											<?php endforeach;?>
										</select>
					</td>
					<td>						
										<select class="frm" name="distance2">
											<option value="0">指定なし</option>
											<?php foreach ($distance_list as $key => $value):?>
											<?php if ($key==$distance2):?>
											<option value="<?php echo $key;?>" selected="selected"><?php echo $value."万km";?></option>
											<?php else:?>
											<option value="<?php echo $key;?>"><?php echo $value."万km";?></option>
											<?php endif;?>
											<?php endforeach;?>
										</select>
					
					</td>
					<td>
					
						
										<select class="frm" name="point1">
											<option value="0">指定なし~</option>
											<?php foreach ($point_list as $key => $value):?>
											<?php if ($key==$point1):?>
											<option value="<?php echo $key;?>" selected="selected"><?php echo $value;?></option>
											<?php else:?>
											<option value="<?php echo $key;?>"><?php echo $value;?></option>
											<?php endif;?>
											<?php endforeach;?>
										</select>
					</td>
					<td>
										<select class="frm" name="point2">
											<option value="0">指定なし</option>
											<?php foreach ($point_list as $key => $value):?>
											<?php if ($key==$point2):?>
											<option value="<?php echo $key;?>" selected="selected"><?php echo $value;?></option>
											<?php else:?>
											<option value="<?php echo $key;?>"><?php echo $value;?></option>
											<?php endif;?>
											<?php endforeach;?>
										</select>
					</td>
					<td>
						<select name="span">
								<option value="0">Span</option>
								<?php foreach ($span_list as $key => $value):?>
								<?php if ($key==$span):?>
								<option value="<?php echo $key;?>" selected="selected"><?php echo $value;?></option>
								<?php else:?>
								<option value="<?php echo $key;?>"><?php echo $value;?></option>
								<?php endif;?>
								<?php endforeach;?>
						</select>
					</td>
					<td><input type="submit" value="検索" style="background-color: yellow; width: 100%"/></td>
				</tr>
				</table>
				</form>
			</div>
			<div id="lookup_result" style="color: orange">
			<?php if($do_lookup){
				echo "Total: ".$total_result." Results";
			}?>
			</div>
			<div class="clear"></div>
			
			<div id="lookup_result">
			<?php if(isset($lookup_result) && sizeof($lookup_result) > 0)
			{
				include("lookup_result.php");
			}
			?>
			</div>
		</div>
	</body>
</html>
