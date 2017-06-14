<?php
$current_page_count = ($current_page -1) * $limit + 1;
$current_item_bottom = $current_page_count;
$current_item_top = ($current_page_count + $limit - 1) < $total_result ? ($current_page_count + $limit - 1) : $total_result; 
$current_items = "&nbsp;&nbsp; *** "."<b><i>". $current_item_bottom."-".$current_item_top . 
				" of ". number_format($total_result)."</i></b>"; 
?>
<?php echo $pagination . $current_items;?>
<table cellspacing="0" cellpadding="0">
	<tr>
		<td>
				<table width="985" cellspacing="0" cellpadding="0" bordercolor="#666666" border="0" id="T1_INTG">
								<tbody><tr bgcolor="#ccffff">
									<td class="col_kaijo_T1">
										<a onclick="OpenSbrkm(this, 'preintgsbrkm02.jsp?srch=preintginftl01&amp;sbrkm=07', 'preintginftl01', '');" href="#"><img border="0" alt="絞込み" src="<?php echo base_url().'static/img'?>/intg_btn_kaijo.gif"></a><br>
												<span style="text-align: center ;" class="kihon12">出品番号</span>
										<a id="id_asc" href="auction_list?maker=<?php echo $maker_id;?>&type=<?php echo $type_id;?>&code=<?php echo $code_id;?>&grade=<?php echo $grade_id;?>&color=<?php echo $color;?>&year1=<?php echo $year1;?>&year2=<?php echo $year2;?>&shift=<?php echo $shift;?>&distance1=<?php echo $distance1;?>&distance2=<?php echo $distance2;?>&point1=<?php echo $point1;?>&point2=<?php echo $point2;?>&span=<?php echo $span;?>&order_by=id&order_type=asc"><img border="0" alt="並び替え" src="<?php echo base_url().'static/img'?>/intg_btn_up01.gif"></a>
										<a id="id_desc" href="auction_list?maker=<?php echo $maker_id;?>&type=<?php echo $type_id;?>&code=<?php echo $code_id;?>&grade=<?php echo $grade_id;?>&color=<?php echo $color;?>&year1=<?php echo $year1;?>&year2=<?php echo $year2;?>&shift=<?php echo $shift;?>&distance1=<?php echo $distance1;?>&distance2=<?php echo $distance2;?>&point1=<?php echo $point1;?>&point2=<?php echo $point2;?>&span=<?php echo $span;?>&order_by=id&order_type=desc"><img border="0" alt="並び替え" src="<?php echo base_url().'static/img'?>/intg_btn_down01.gif"></a>
									<img width="1" height="0" border="0" src="<?php echo base_url().'static/img'?>/shim.gif">
									</td>
									<td align="center" class="col_year_T1">
										<a onclick="OpenSbrkm(this, 'preintgsbrkm02.jsp?srch=preintginftl01&amp;sbrkm=08', 'preintginftl01', '');" href="#"><img border="0" alt="絞込み" src="<?php echo base_url().'static/img'?>/intg_btn_nenshiki.gif"></a><br>
										<a id="year_asc" href="auction_list?maker=<?php echo $maker_id;?>&type=<?php echo $type_id;?>&code=<?php echo $code_id;?>&grade=<?php echo $grade_id;?>&color=<?php echo $color;?>&year1=<?php echo $year1;?>&year2=<?php echo $year2;?>&shift=<?php echo $shift;?>&distance1=<?php echo $distance1;?>&distance2=<?php echo $distance2;?>&point1=<?php echo $point1;?>&point2=<?php echo $point2;?>&span=<?php echo $span;?>&order_by=year&order_type=asc"><img border="0" alt="並び替え" src="<?php echo base_url().'static/img'?>/intg_btn_up01.gif"></a>
										<a  id="year_desc" href="auction_list?maker=<?php echo $maker_id;?>&type=<?php echo $type_id;?>&code=<?php echo $code_id;?>&grade=<?php echo $grade_id;?>&color=<?php echo $color;?>&year1=<?php echo $year1;?>&year2=<?php echo $year2;?>&shift=<?php echo $shift;?>&distance1=<?php echo $distance1;?>&distance2=<?php echo $distance2;?>&point1=<?php echo $point1;?>&point2=<?php echo $point2;?>&span=<?php echo $span;?>&order_by=year&order_type=desc"><img border="0" alt="並び替え" src="<?php echo base_url().'static/img'?>/intg_btn_down01.gif"></a>
									</td>
									<td class="col_car_T1">
										<a onclick="OpenSbrkm(this, 'preintgsbrkm02.jsp?srch=preintginftl01&amp;sbrkm=01', 'preintginftl01', '');" href="#"><img border="0" alt="絞込み" src="<?php echo base_url().'static/img'?>/intg_btn_syamei.gif"></a>
										<a id="types_asc" href="auction_list?maker=<?php echo $maker_id;?>&type=<?php echo $type_id;?>&code=<?php echo $code_id;?>&grade=<?php echo $grade_id;?>&color=<?php echo $color;?>&year1=<?php echo $year1;?>&year2=<?php echo $year2;?>&shift=<?php echo $shift;?>&distance1=<?php echo $distance1;?>&distance2=<?php echo $distance2;?>&point1=<?php echo $point1;?>&point2=<?php echo $point2;?>&span=<?php echo $span;?>&order_by=types&order_type=asc"><img border="0" alt="並び替え" src="<?php echo base_url().'static/img'?>/intg_btn_up01.gif"></a>
										<a id="types_desc" href="auction_list?maker=<?php echo $maker_id;?>&type=<?php echo $type_id;?>&code=<?php echo $code_id;?>&grade=<?php echo $grade_id;?>&color=<?php echo $color;?>&year1=<?php echo $year1;?>&year2=<?php echo $year2;?>&shift=<?php echo $shift;?>&distance1=<?php echo $distance1;?>&distance2=<?php echo $distance2;?>&point1=<?php echo $point1;?>&point2=<?php echo $point2;?>&span=<?php echo $span;?>&order_by=types&order_type=desc"><img border="0" alt="並び替え" src="<?php echo base_url().'static/img'?>/intg_btn_down01.gif"></a><br>
										<a onclick="OpenSbrkm(this, 'preintgsbrkm02.jsp?srch=preintginftl01&amp;sbrkm=02', 'preintginftl01', '');" href="#"><img border="0" alt="絞込み" src="<?php echo base_url().'static/img'?>/intg_btn_grade.gif"></a>
										<a id="grades_asc" href="auction_list?maker=<?php echo $maker_id;?>&type=<?php echo $type_id;?>&code=<?php echo $code_id;?>&grade=<?php echo $grade_id;?>&color=<?php echo $color;?>&year1=<?php echo $year1;?>&year2=<?php echo $year2;?>&shift=<?php echo $shift;?>&distance1=<?php echo $distance1;?>&distance2=<?php echo $distance2;?>&point1=<?php echo $point1;?>&point2=<?php echo $point2;?>&span=<?php echo $span;?>&order_by=grades&order_type=asc"><img border="0" alt="並び替え" src="<?php echo base_url().'static/img'?>/intg_btn_up01.gif"></a>
										<a id="grades_desc" href="auction_list?maker=<?php echo $maker_id;?>&type=<?php echo $type_id;?>&code=<?php echo $code_id;?>&grade=<?php echo $grade_id;?>&color=<?php echo $color;?>&year1=<?php echo $year1;?>&year2=<?php echo $year2;?>&shift=<?php echo $shift;?>&distance1=<?php echo $distance1;?>&distance2=<?php echo $distance2;?>&point1=<?php echo $point1;?>&point2=<?php echo $point2;?>&span=<?php echo $span;?>&order_by=grades&order_type=desc"><img border="0" alt="並び替え" src="<?php echo base_url().'static/img'?>/intg_btn_down01.gif"></a>
									</td>
									<td class="col_kata_T1">
										<a onclick="OpenSbrkm(this, 'preintgsbrkm02.jsp?srch=preintginftl01&amp;sbrkm=03', 'preintginftl01', '');" href="#"><img border="0" alt="絞込み" src="<?php echo base_url().'static/img'?>/intg_btn_katashiki.gif"></a><br>
										<a onclick="OpenSbrkm(this, 'preintgsbrkm02.jsp?srch=preintginftl01&amp;sbrkm=09', 'preintginftl01', '');" href="#"><img border="0" alt="絞込み" src="<?php echo base_url().'static/img'?>/intg_btn_haikiryou.gif"></a>
										<a id="cubic_capacity_asc" href="auction_list?maker=<?php echo $maker_id;?>&type=<?php echo $type_id;?>&code=<?php echo $code_id;?>&grade=<?php echo $grade_id;?>&color=<?php echo $color;?>&year1=<?php echo $year1;?>&year2=<?php echo $year2;?>&shift=<?php echo $shift;?>&distance1=<?php echo $distance1;?>&distance2=<?php echo $distance2;?>&point1=<?php echo $point1;?>&point2=<?php echo $point2;?>&span=<?php echo $span;?>&order_by=cubic_capacity&order_type=asc"><img border="0" alt="並び替え" src="<?php echo base_url().'static/img'?>/intg_btn_up01.gif"></a>
										<a id="cubic_capacity_desc" href="auction_list?maker=<?php echo $maker_id;?>&type=<?php echo $type_id;?>&code=<?php echo $code_id;?>&grade=<?php echo $grade_id;?>&color=<?php echo $color;?>&year1=<?php echo $year1;?>&year2=<?php echo $year2;?>&shift=<?php echo $shift;?>&distance1=<?php echo $distance1;?>&distance2=<?php echo $distance2;?>&point1=<?php echo $point1;?>&point2=<?php echo $point2;?>&span=<?php echo $span;?>&order_by=cubic_capacity&order_type=desc"><img border="0" alt="並び替え" src="<?php echo base_url().'static/img'?>/intg_btn_down01.gif"></a>
									</td>
									<td align="center" class="col_shaken_T1">
										<span class="col_shaken_title">車検</span>
										<a href="preforward01.jsp?href=preintginftl01.jsp%3Fmode%3D1%26skey%3D11&amp;target=_self"><img border="0" alt="並び替え" src="<?php echo base_url().'static/img'?>/intg_btn_up01.gif"></a>
										<a href="preforward01.jsp?href=preintginftl01.jsp%3Fmode%3D1%26skey%3D12&amp;target=_self"><img border="0" alt="並び替え" src="<?php echo base_url().'static/img'?>/intg_btn_down01.gif"></a><br>
										<a onclick="OpenSbrkm(this, 'preintgsbrkm02.jsp?srch=preintginftl01&amp;sbrkm=10', 'preintginftl01', '');" href="#"><img border="0" alt="絞込み" src="<?php echo base_url().'static/img'?>/intg_btn_soukou.gif"></a>
										<a id="distance_asc" href="auction_list?maker=<?php echo $maker_id;?>&type=<?php echo $type_id;?>&code=<?php echo $code_id;?>&grade=<?php echo $grade_id;?>&color=<?php echo $color;?>&year1=<?php echo $year1;?>&year2=<?php echo $year2;?>&shift=<?php echo $shift;?>&distance1=<?php echo $distance1;?>&distance2=<?php echo $distance2;?>&point1=<?php echo $point1;?>&point2=<?php echo $point2;?>&span=<?php echo $span;?>&order_by=distance&order_type=asc"><img border="0" alt="並び替え" src="<?php echo base_url().'static/img'?>/intg_btn_up01.gif"></a>
										<a id="distance_desc" href="auction_list?maker=<?php echo $maker_id;?>&type=<?php echo $type_id;?>&code=<?php echo $code_id;?>&grade=<?php echo $grade_id;?>&color=<?php echo $color;?>&year1=<?php echo $year1;?>&year2=<?php echo $year2;?>&shift=<?php echo $shift;?>&distance1=<?php echo $distance1;?>&distance2=<?php echo $distance2;?>&point1=<?php echo $point1;?>&point2=<?php echo $point2;?>&span=<?php echo $span;?>&order_by=distance&order_type=desc"><img border="0" alt="並び替え" src="<?php echo base_url().'static/img'?>/intg_btn_down01.gif"></a>
									</td>
									<td class="col_color_T1">
										<a onclick="OpenSbrkm(this, 'preintgsbrkm02.jsp?srch=preintginftl01&amp;sbrkm=04', 'preintginftl01', '');" href="#"><img border="0" alt="絞込み" src="<?php echo base_url().'static/img'?>/intg_btn_color.gif"></a><br>
										<span class="kihon12">色No.</span>
									</td>
									<td class="col_shift_T1">
										<a onclick="OpenSbrkm(this, 'preintgsbrkm02.jsp?srch=preintginftl01&amp;sbrkm=05', 'preintginftl01', '');" href="#"><img border="0" alt="絞込み" src="<?php echo base_url().'static/img'?>/intg_btn_shift.gif"></a><br>
										<span class="kihon12">冷房</span>
									</td>
									<td align="center" class="col_hyoka_T1">
										<a onclick="OpenSbrkm(this, 'preintgsbrkm02.jsp?srch=preintginftl01&amp;sbrkm=06', 'preintginftl01', '');" href="#"><img border="0" alt="絞込み" src="<?php echo base_url().'static/img'?>/intg_btn_hyouka.gif"></a><br>
										<span class="kihon12">外内装</span>
									</td>
									<td align="center" class="col_kng_T1">
										<a onclick="OpenSbrkm(this, 'preintgsbrkm02.jsp?srch=preintginftl01&amp;sbrkm=12', 'preintginftl01', '');" href="#"><img border="0" alt="絞込み" src="<?php echo base_url().'static/img'?>/intg_btn_start.gif"></a><br>
										<a id="start_price_asc" href="auction_list?maker=<?php echo $maker_id;?>&type=<?php echo $type_id;?>&code=<?php echo $code_id;?>&grade=<?php echo $grade_id;?>&color=<?php echo $color;?>&year1=<?php echo $year1;?>&year2=<?php echo $year2;?>&shift=<?php echo $shift;?>&distance1=<?php echo $distance1;?>&distance2=<?php echo $distance2;?>&point1=<?php echo $point1;?>&point2=<?php echo $point2;?>&span=<?php echo $span;?>&order_by=start_price&order_type=asc"><img border="0" alt="並び替え" src="<?php echo base_url().'static/img'?>/intg_btn_up01.gif"></a>
										<a id="start_price_desc" href="auction_list?maker=<?php echo $maker_id;?>&type=<?php echo $type_id;?>&code=<?php echo $code_id;?>&grade=<?php echo $grade_id;?>&color=<?php echo $color;?>&year1=<?php echo $year1;?>&year2=<?php echo $year2;?>&shift=<?php echo $shift;?>&distance1=<?php echo $distance1;?>&distance2=<?php echo $distance2;?>&point1=<?php echo $point1;?>&point2=<?php echo $point2;?>&span=<?php echo $span;?>&order_by=start_price&order_type=desc"><img border="0" alt="並び替え" src="<?php echo base_url().'static/img'?>/intg_btn_down01.gif"></a>
									</td>
									<td align="center" style="border-right: 1px solid #666666;" class="col_ymd_T1">
										<span class="kihon12">取引価格</span><br>
										<a id="result_price_asc" href="auction_list?maker=<?php echo $maker_id;?>&type=<?php echo $type_id;?>&code=<?php echo $code_id;?>&grade=<?php echo $grade_id;?>&color=<?php echo $color;?>&year1=<?php echo $year1;?>&year2=<?php echo $year2;?>&shift=<?php echo $shift;?>&distance1=<?php echo $distance1;?>&distance2=<?php echo $distance2;?>&point1=<?php echo $point1;?>&point2=<?php echo $point2;?>&span=<?php echo $span;?>&order_by=result_price&order_type=asc"><img border="0" alt="並び替え" src="<?php echo base_url().'static/img'?>/intg_btn_up01.gif"></a>
										<a id="result_price_desc" href="auction_list?maker=<?php echo $maker_id;?>&type=<?php echo $type_id;?>&code=<?php echo $code_id;?>&grade=<?php echo $grade_id;?>&color=<?php echo $color;?>&year1=<?php echo $year1;?>&year2=<?php echo $year2;?>&shift=<?php echo $shift;?>&distance1=<?php echo $distance1;?>&distance2=<?php echo $distance2;?>&point1=<?php echo $point1;?>&point2=<?php echo $point2;?>&span=<?php echo $span;?>&order_by=result_price&order_type=desc"><img border="0" alt="並び替え" src="<?php echo base_url().'static/img'?>/intg_btn_down01.gif"></a>
									</td>
								</tr>
							</tbody></table>
						</td>
					</tr>
	<tr>
	<td>
	<div style="">
	<table cellspacing="0" cellpadding="0">
	<?php $count = 0;?>
	<?php //die(var_dump($lookup_result));?>
	<?php foreach($lookup_result as $auc):?>
	<?php //die(var_dump($auc));?>
	<?php $count++;?>
	<?php //$conference = $this->auction->get_conference($auc->conference_id);?>					
	<tr>
		<td>		
			<table id="T2_INTG" cellspacing="0" cellpadding="0">
				<?php if ($count == sizeof($lookup_result)){?>
				<tr id=fix_last>
				<?php }else{?>
				<tr>
				<?php }?>
					<td class="col_kaijo_T2" style="">
						<div><?php if (trim($auc->conference_name," ") != NULL) echo $auc->conference_name; else echo "&nbsp;";?></div>	
						<div class="auction_id"  style="float: left; width: 30px;">
							<?php echo $auc->auction_id?>
						</div>
						<div class="btnDetail" style="float: left">
							<a href='<?php echo base_url()."admin/auction_show?conference_id={$auc->conference_id}&holding_id={$auc->holding_id}&auction_id={$auc->auction_id}&type_id={$auc->type_id}"?>'>出品票</a>
						</div>
						<div class="clear"></div>
					</td>
					
					<td class="col_year_T2" style="">
						<?php if($auc->year){ if ($year_reverse[$auc->year]>=40 && $year_reverse[$auc->year]<=63) echo ("S".$year_reverse[$auc->year]); else echo ("H".$year_reverse[$auc->year]); } else echo "&nbsp;";?>
					</td>
					
					<td class="col_car_T2" style=""><?php if(!trim($auc->type_name," ")) echo "&nbsp;"."<br />".$auc->grade_name; else echo $auc->type_name."<br />". $auc->grade_name;?></td>
					<td  style="width: 98px;"><?php if (!trim($auc->code_name," ")) echo "&nbsp;"."<br />".$auc->cubic_capacity; else echo $auc->code_name."<br />".$auc->cubic_capacity;?>cc</td>
					<td style="width: 95px;"><?php if ($auc->distance) echo ($auc->distance."千km"); else echo "&nbsp;";?></td>
					
					<td style="width: 83px;"><?php if(!trim($auc->color," ")) echo "&nbsp;";else echo $auc->color?></td>
					
					<td style="width: 53px;"><?php if (!trim($auc->shift," ")) echo "&nbsp;"."<br />".$auc->cooling; else echo $auc->shift."<br />".$auc->cooling;?></td>
					
					<td style="width: 54px;text-align : center;"><?php if(!trim($auc->point," ")) echo "&nbsp;"; else echo $auc->point?></td>
					
					<td style="width: 103px;" align = "center"><?php if ($auc->start_price) echo ($auc->start_price."万円"); else echo "&nbsp;";?></td>
					
					<td style="width: 89px;border-right : 1px solid Gray;" align = "center">
					<?php if ($auc->auction_day!=0) echo $auc->auction_day?></br>
					<?php if ($auc->result_price) echo $auc->result_price."万円"; else echo "&nbsp;";?>
					</td>
					
				</tr>
			</table>
		</td>
	</tr>
	<?php endforeach;?>
	</table>
	</div>
	</td>
	</tr>
</table>

<?php echo $pagination . $current_items;?>
<br /><br /><br />
<script type="text/javascript">
<?php
	$order_list=Array("id","year","types","grades","cubic_capacity","distance","start_price","result_price");
	foreach ($order_list as $order){
		if ($order == $order_by){
			if ($order_type== "asc"){
		?>
			$('#<?php echo $order."_asc"?> img').attr("src","<?php echo base_url().'static/img'?>/intg_btn_up01_on.gif");		
			$('#<?php echo $order."_asc"?>').click(function() {return false;});
		<?php }
			else{?>
			$('#<?php echo $order."_desc";?> img').attr("src","<?php echo base_url().'static/img'?>/intg_btn_down01_on.gif");	
			$('#<?php echo $order."_desc";?>').click(function() {return false;});
			<?php }
		}
	} 
?>
</script>