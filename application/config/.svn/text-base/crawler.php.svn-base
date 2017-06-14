<?php
/*
	112, // toyota 
	188, 190, 216, 225, 239, 240, // nissan
	388, 389, 400, 413, 425, 426, 451, 478, 493, // mitsubishi
	639,  640, 641, 642, 643, 647, 662,	// isuzu, 644 removed
	712, 732,747, 748, 749, 750, 755, 756, 759, 761, 765,
 */
	/* その他国産 
	 * 711 => 400
	 * 701 -> 216
	 * 759 => 425
	*/
$config['crawl_maker_list'] = array(
	1, // toyota
	2, // nissan
	4, // mitsubishi
	5, // mazda
	9, // isuzu
	10, // other
);
$config['crawl_type_list'] = array(
	'Monday' 		=> array(112, 190, 225),
	'Tuesday' 		=> array(118, 239, 240, 388, 389, 400, 413, 425, 451),
	'Wednesday' 	=> array(426, 478),
	'Thursday' 		=> array(639),
	'Friday'		=> array(640, 642, 643, 647, 662, 493, 712, 732, 747, 748),
	'Saturday' 		=> array(749, 750, 755, 756),
	'Sunday' 		=> array(761, 765, 216)
);

$config['error_message_list'] = array(
	"指定された条件に適合する車輌は見つかりませんでした", // => Vehicles that conform to the conditions specified was not found (e.g. wrong type)
	"再度ログインしてご利用ください ", // 無操作時間が長いため接続を切断しました 再度ログインしてご利用ください  Non-operation time has been disconnected for a long Please use to log in again
);

$config['server_location'] = 'default';

/* TYPE check  18/03/2012
  112 ﾀﾞｲﾅ 332
  
  118 UD 109
  190 ｱﾄﾗｽ 229
  225 ｼﾋﾞﾘｱﾝ 50
  239 ﾀﾞｯﾄｻﾝ 39
  240:ﾀﾞｯﾄｻﾝﾋﾟｯｸｱｯﾌﾟ 39
  
  388:ｷｬﾝﾀｰ 24
  389:ｷｬﾝﾀｰｶﾞｯﾂ 75
  400:ｽｰﾊﾟｰｸﾞﾚｰﾄ 53
  413:ﾃﾞﾘｶﾄﾗｯｸ 24
  425:ﾌｿｳﾄﾗｯｸ 214
  426:ﾌｿｳﾌｧｲﾀｰ 301
  451:ﾛｰｻﾞ 25
  478:ﾀｲﾀﾝ 307
  493:ﾎﾞﾝｺﾞﾄﾗｯｸ 105
  
  639:ｴﾙﾌ 1042
  640:ｴﾙﾌ100 0
  642:ｴﾙﾌ250 4
  643:ｴﾙﾌ350 1
  644:ｴﾙﾌ450 ==> WAS REMOVED BY IAUC, not see in list
  647:ｷﾞｶﾞ 47
  662:ﾌｫﾜｰﾄﾞ 289
  
  712:ｽｰﾊﾟｰﾄﾞﾙﾌｨﾝ  2
  732:ﾄﾞﾙﾌｨﾝ 1
  747:ﾋﾉ 1
  748:ﾋﾉFD 0
  749:ﾋﾉﾃﾞｭﾄﾛ 125
  750:ﾋﾉﾄﾗｯｸ 182
  755:ﾋﾉﾚｲﾝﾎﾞｰ 9
  756:ﾋﾉﾚﾝｼﾞｬｰ 301
  
  761:ﾌｿｳﾌｧｲﾀｰ 301
  765:ﾌﾟﾛﾌｨｱ 34
  216:ｺﾝﾄﾞﾙ 174
  
  
  759	10	 	ﾌｿｳﾄﾗｯｸ	%CC%BF%B3%C4%D7%AF%B8
  
*/

