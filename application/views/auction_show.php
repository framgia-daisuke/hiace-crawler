<?php
$img = explode(",",$auction->img);
$img_domain = get_auction_img_domain($auction);
$maker = get_maker_by_id($auction->maker_id);
$img_dir = $img_domain.$maker->name_en."/".$auction->type_id."/".$auction->conference_id."/".$auction->holding_id."/".$auction->auction_id."/";
?>
<html>
<head>
	<title>Detail view</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<div align="center">
	<table border="0" cellpadding="0" cellspacing="0" width="985">
		<tr>
			<td valign="top" width="300">
				<table border="1" cellpadding="1" cellspacing="1" width="280">
		   			<tr>
        				<td bordercolor="#272672" bgcolor="#FFFFFF">
            				<font color="#272672"><b><?php echo $maker_name;?><br>
                				<?php echo ($type_name." ".$code_name."-".$auction->unique_number);?></b></font>
						</td>
					</tr>
				</table>
			</td>
		</tr>
</table>
<table width="975" border="0" cellpadding="0" cellspacing="0">
      <colgroup>
      <col width="700">
      <col width="12">
      <col width="263">
      </colgroup>
      <tbody><tr valign="top">
        <!-- 黒枠 -->
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tbody><tr>
              <td bgcolor="#333333"><!-- -メインテーブル- -->
                <table width="100%" border="0" cellspacing="1" cellpadding="2">
                  <colgroup>
                  <col width="65">
                  <col width="158">
                  <col width="65">
                  <col width="158">
                  <col width="65">
                  <col width="158">
                  </colgroup>
                  <tbody><tr>
                    <td bgcolor="#CCCCFF" class="tableT" align="left" nowrap="">出品番号</td>
                    <td bgcolor="#FFFFFF" align="left" class="tableT"><div id="colList0"><?php echo $auction->auction_id;?></div></td>
                    <td bgcolor="#CCCCFF" class="tableT" align="left" nowrap="">評価点</td>
                    <td bgcolor="#FFFFFF" align="left" class="tableT"><?php echo $auction->point;?></td>
                    <td bgcolor="#CCCCFF" class="tableT" align="left" nowrap="">走行</td>
                    <td bgcolor="#FFFFFF" align="left" class="tableT"><?php echo $auction->distance."千km"?></td>
                  </tr>
                  <tr>
                    <td bgcolor="#CCCCFF" class="tableT" align="left" nowrap="">グレード</td>
                    <td bgcolor="#FFFFFF" align="left" class="tableT"><?php echo $grade_name;?></td>
                    <td bgcolor="#CCCCFF" class="tableT" align="left" nowrap="">ﾎﾞﾃﾞｨ形状</td>
                    <td bgcolor="#FFFFFF" align="left" class="tableT"><?php echo $auction->body;?></td>
                    <td align="left" bgcolor="#CCCCFF" class="tableT">冷房</td>
                    <td align="left" bgcolor="#FFFFFF" class="tableT"><?php echo $auction->cooling;?></td>
                  </tr>
                  <tr>
                    <td bgcolor="#CCCCFF" class="tableT" align="left" nowrap="">年式</td>
                    <td bgcolor="#FFFFFF" align="left" class="tableT"><?php if($auction->year > 0 ){ if ($year_reverse[$auction->year]<=63 && $year_reverse[$auction->year]>=40) echo ("S".$year_reverse[$auction->year]); else  echo ("H".$year_reverse[$auction->year]);}?></td>
                    <td bgcolor="#CCCCFF" class="tableT" align="left" nowrap="">シフト</td>
                    <td bgcolor="#FFFFFF" align="left" class="tableT"><?php echo $auction->shift;?></td>
                    <td align="left" bgcolor="#CCCCFF" class="tableT">燃料</td>
                    <td align="left" bgcolor="#FFFFFF" class="tableT"><?php echo $auction->fuel;?></td>
                  </tr>
                  <tr>
                    <td bgcolor="#CCCCFF" class="tableT" align="left" nowrap="">排気量</td>
                    <td bgcolor="#FFFFFF" align="left" class="tableT"><?php echo $auction->cubic_capacity."cc";?></td>
                    <td align="left" bgcolor="#CCCCFF" class="tableT">色</td>
                    <td align="left" bgcolor="#FFFFFF" class="tableT">
                    	<table border="0" cellpadding="0" cellspacing="0">
                        	<tbody>
                        	<tr>
                          		<td valign="bottom"><?php echo $auction->color;?></td>
							</tr>
							</tbody>
						</table>
                    </td>
                    <td align="left" bgcolor="#CCCCFF" class="tableT">定員</td>
                    <td align="left" bgcolor="#FFFFFF" class="tableT"><?php echo $auction->capacity;?></td>
                  </tr>

                  <tr>
                    <td bgcolor="#CCCCFF" class="tableT" align="left" nowrap="">積載</td>
                    <td bgcolor="#FFFFFF" align="left" class="tableT"><?php if(!empty($auction->loading)) echo $auction->loading."Kg";?></td>
                    <td align="left" bgcolor="#CCCCFF" class="tableT">ｺｰﾅｰ名</td>
                    <td bgcolor="#FFFFFF" align="left" class="tableT"><?php echo $auction->corner;?></td>
                    <td align="left" bgcolor="#CCCCFF" class="tableT"> </td>
                    <td bgcolor="#FFFFFF" align="left" class="tableT"> </td>
                                        
                   </tr>                  
                  
                  <tr>
                    <td align="left" bgcolor="#CCCCFF" class="tableT">装備</td>
                    <td colspan="5" align="left" bgcolor="#FFFFFF" class="tableT"><?php echo $auction->equipment;?></td>
                  </tr>
                  <!-- <tr height="40">
                    <td align="left" bgcolor="#CCCCFF" class="tableT" valign="top">訂正</td>
                    <td align="left" valign="top" bgcolor="#FFFFFF" class="tableTred" colspan="5">&nbsp;</td>
                  </tr> -->
                  <tr>
                    <td align="left" bgcolor="#CCCCFF" class="tableT" valign="top">ｱｲｵｰｸｺﾒﾝﾄ</td>
                    <td align="left" bgcolor="#FFFFFF" class="tableTred" colspan="5"><?php echo $auction->comment;?></td>
                  </tr>
                </tbody></table>
                <!-- -メインテーブル- -->
              </td>
            </tr>
          </tbody></table>
          <!-- -黒枠- -->
        </td>
        <td><img width="12" height="1"></td>
        <!-- 黒枠 -->
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tbody><tr>
              <td bgcolor="#333333">
                <!-- -メインテーブル- -->
                <table width="100%" border="0" cellspacing="1" cellpadding="2">
                  <colgroup>
                  <col width="55">
                  <col width="197">
                  </colgroup>
                  <tbody><tr>
                    <td bgcolor="#CCCCFF" class="tableT" align="left">スタート</td>
                    <td bgcolor="#FFFFFF" class="tableT" align="right"><?php echo $auction->start_price."万円";?></td>
                  </tr>
                  <tr>
                    <td bgcolor="#CCCCFF" class="tableT" align="left" valign="top">結果</td>
                    <td bgcolor="#FFFFFF" class="tableT" align="right"><table height="37" border="0" cellspacing="0" cellpadding="0">
                        <tbody><tr>
                          <td align="left" bgcolor="#FFFFFF" class="tableT"><table border="0" cellspacing="0" cellpadding="0">
                              <tbody><tr>
                                <td align="right">成約</td>
                              </tr>
                              <tr>
                                <td align="right" bgcolor="#FFFFFF" class="tableT"><?php echo $auction->result_price."万円";?></td>
                              </tr>
                            </tbody></table></td>
                        </tr>
                      </tbody></table></td>
                  </tr>
                  <tr>
                    <td bgcolor="#CCCCFF" class="tableT" align="left">会場名</td>
                    <td bgcolor="#FFFFFF" class="tableT" align="left"><?php echo $auction->venue;?></td>
                  </tr>
                  <tr>
                    <td bgcolor="#CCCCFF" class="tableT" align="left">開催回数</td>
                    <td bgcolor="#FFFFFF" class="tableT" align="left"><?php echo $holding_id;?></td>
                  </tr>
                  <tr>
                    <td bgcolor="#CCCCFF" class="tableT" align="left">開催日</td>
                    <td bgcolor="#FFFFFF" class="tableT" align="left"><?php echo $auction->auction_day;?></td>
                  </tr>
                  <tr>
                    <td bgcolor="#CCCCFF" class="tableT" align="left">Crawl date</td>
                    <td bgcolor="#FFFFFF" class="tableT" align="left"><?php echo $auction->insert_date;?></td>
                  </tr>
                  <!-- 
                  <tr>
                    <td bgcolor="#CCCCFF" class="tableT" align="left">状態</td>
                    <td bgcolor="#FFFFFF" class="tableT" align="left">&nbsp;</td>
                  </tr>-->
                </tbody></table>
                <!-- -メインテーブル- -->
              </td>
            </tr>
          </tbody></table>
          <!-- -黒枠- -->
        </td>
      </tr>
    </tbody></table>
</div>
	<div align="center">
    <!-- -------------●●●●----------------- -->
    <table border="0" cellpadding="0" cellspacing="0" width="975">
      <colgroup>
      <col width="470">
      <col width="129">
      <col width="372">
      </colgroup>
      <tbody><tr valign="top">
      <?php if (isset($img[0])&& $img[0]!=NULL){?>
        <td align="center" colspan="2"><table border="0" cellpadding="0" cellspacing="0">
            <colgroup>
            <col width="470">
            <col width="129">
            </colgroup>
            <tbody><tr>
              <td colspan="2" align="left"><span class="redT1"><b>&nbsp;<br>&nbsp;</b></span></td>
            </tr>
            <tr>
              <td bgcolor="white" align="center"><div id="gazoFile3"><img src="<?php echo $img_dir.$img[0]?>" width="470" height="470" border="1"></div>
                <!-- -●左画像- -->
                </td>
              
            </tr>
			      </tbody></table></td>
			<?php }?>
        <td align="right"><!-- -●●●●●右上ここから- -->
		  <span class="redT1"><br>
		  <br>
		  </span>
          <table border="0" cellspacing="0" cellpadding="0">
            <tbody>
            <?php if (isset($img[1])&& $img[1]!=NULL){?>
            <tr>
              <td bgcolor="white" align="center"><div id="gazoFile1"><img src="<?php echo $img_dir.$img[1]?>" width="320" height="240" border="1"></div>
                <!-- -●右上画像- -->
                </td>
            </tr>
            <tr>
              
            </tr>
            <?php }?>
            <tr>
              <td><img width="1" height="15" border="0"></td>
            </tr>
            <?php if (isset($img[2])&& $img[2]!=NULL){?>
            <tr>
              <td bgcolor="white" align="center"><div id="gazoFile2"><img src="<?php echo $img_dir.$img[2]?>" width="320" height="240" border="1"></div>
                <!-- -●右下画像- -->
                </td>
            </tr>
            <tr>
              
            </tr>
            <?php }?>
          </tbody></table>
          <!-- -●●●●●ここまで右下- -->
        </td>
      </tr>
    </tbody></table>
    <!-- -------------●●●●----------------- -->
  </div>
</body>
</html>
