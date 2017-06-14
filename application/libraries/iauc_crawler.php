<?php
/**
 * iauc.co.jp Crawler
 * @author VuLD@LifetimeTech
 * @version 1
 * @date 11/2011
 * Last update 05/2012
 */

date_default_timezone_set("Asia/Tokyo");
class Iauc_crawler
{
	private $server_location = "default";
	private $auction_url = "https://www.iauc.co.jp/auction/";
	private	$home_url = "https://www.iauc.co.jp/";
	private $top_page = "https://www.iauc.co.jp/pv/top1.html";

	private $preintginftl01_url_timestamp;

	private $counter = 0;

	// sleep interval
	private $sleep_interval = 5;

	// logging
	private $logger;
	private $log_path; // log dir
	private $log_file;
	private $write_log = TRUE;

	// get code, grade
	public $get_code_grade_only = FALSE;
	public $get_total_result_only = FALSE;

	// login action?
	public $do_login = FALSE;

	//
	private $maker;
	private $type;

	function __construct()
	{
		$this->CI = & get_instance();
		$this->log_path = FCPATH . "data/log/";
		$this->log_file = "crawl-".date("Y-m-d").".log";
		$this->logger = fopen($this->log_path.$this->log_file, "a");
	}
	function __destruct()
	{
		/*
		try{
			$content = file_get_contents($this->log_path.$this->log_file);
			$filename = $this->log_path.$this->log_file.".gz";
			$zp = gzopen($filename, "w9");
			gzwrite($zp, $content);
			unlink($this->log_path.$this->log_file);
			gzclose($zp);
		}
		catch(Exception $e){

		}
		*/
		@fclose($this->logger);
	}
	// write some thing to log file
	function _write_log($str = "")
	{
		if($this->write_log == TRUE) fwrite($this->logger, $str);
	}
	// set write log
	function set_write_log($val = TRUE)
	{
		$this->write_log = $val;
	}
	// set sleep time
	function set_sleep_interval($seconds)
	{
		$this->sleep_interval = $seconds;
	}
	// set server location
	function set_server_location($location)
	{
		$this->server_location = $location;
	}

	function test()
	{
		$html = file_get_contents(FCPATH."tmp/detail_1.htm");
		$html = mb_convert_encoding($html, "UTF-8", "SHIFT-JIS");
		file_put_contents("tmp/converted.html", $html);
		$this->_process_detail_page("1", "いすゞ", "ｴﾙﾌ", $html);
	}

	/*
	 * RUN CRAWLER
	 */
	function run($maker, $type)
	{
		$this->maker = $maker;
		$this->type = $type;
		$maker_id = $maker->id;
		$maker_iauc_id = $maker->iauc_id;
		$type_id = $type->id;
		$type_encoded = $type->encoded;

		//echo "\n---Maker={$maker->name_jp}; type={$type->name_jp};---";
		$this->_write_log("\n---Maker={$maker->name_jp}; type={$type->name_jp};---");
		/* GET DATA in 1 week for イスズ (Isuzu) > ｴﾙﾌ (Elf)
		 * STEPS
		 * Top page:"https://www.iauc.co.jp/pv/top1.html";
		 * 0 START https://www.iauc.co.jp/auction/preframe01.jsp[[?timestamp=1322206222620]]
		 * 1 GET https://www.iauc.co.jp/auction/preindex01.jsp?timestamp=1322206223516
		 * 2 GET https://www.iauc.co.jp/auction/preframecar01.jsp?timestamp=1322206224557 [REF https://www.iauc.co.jp/auction/preindex01.jsp?timestamp=1322206223516]
		 * 3 POST https://www.iauc.co.jp/auction/preexcar01.jsp?timestamp=1322206371811
		 * 		data: cb1%5B1%5D=25%2C2%2C1384&cb1%5B8%5D=12%2C2%2C501&cb1%5B15%5D=14%2C2%2C488&cb1%5B22%5D=13%2C2%2C563&cb1%5B29%5D=15%2C2%2C458&cb1%5B36%5D=11%2C2%2C229&cb1%5B43%5D=10%2C2%2C296&cb1%5B50%5D=65%2C2%2C1474&cb1%5B2%5D=2%2C3%2C588&cb1%5B9%5D=4%2C3%2C353&cb1%5B16%5D=1%2C3%2C233&cb1%5B23%5D=20%2C3%2C6263&cb1%5B30%5D=22%2C3%2C6264&cb1%5B37%5D=23%2C3%2C6265&cb1%5B44%5D=21%2C3%2C6266&cb1%5B51%5D=163%2C3%2C6267&cb1%5B58%5D=93%2C3%2C1190&cb1%5B65%5D=28%2C3%2C947&cb1%5B72%5D=62%2C3%2C1516&cb1%5B79%5D=63%2C3%2C1456&cb1%5B86%5D=68%2C3%2C1432&cb1%5B93%5D=71%2C3%2C1207&cb1%5B100%5D=80%2C3%2C1210&cb1%5B107%5D=206%2C3%2C759&cb1%5B114%5D=186%2C3%2C281&cb1%5B121%5D=185%2C3%2C463&cb1%5B128%5D=160%2C3%2C360&cb1%5B135%5D=117%2C3%2C443&cb1%5B142%5D=142%2C3%2C288&cb1%5B149%5D=148%2C3%2C105&cb1%5B156%5D=146%2C3%2C62&cb1%5B163%5D=147%2C3%2C59&cb1%5B170%5D=192%2C3%2C20&cb1%5B177%5D=193%2C3%2C20&cb1%5B184%5D=197%2C3%2C24&cb1%5B191%5D=198%2C3%2C30&cb1%5B3%5D=3%2C4%2C1139&cb1%5B10%5D=89%2C4%2C1638&cb1%5B17%5D=165%2C4%2C269&cb1%5B24%5D=40%2C4%2C619&cb1%5B31%5D=91%2C4%2C945&cb1%5B38%5D=114%2C4%2C403&cb1%5B45%5D=111%2C4%2C965&cb1%5B52%5D=162%2C4%2C186&cb1%5B59%5D=7%2C4%2C2723&cb1%5B66%5D=90%2C4%2C610&cb1%5B73%5D=43%2C4%2C1012&cb1%5B80%5D=59%2C4%2C1502&cb1%5B87%5D=57%2C4%2C1187&cb1%5B94%5D=140%2C4%2C557&cb1%5B101%5D=139%2C4%2C99&cb1%5B108%5D=194%2C4%2C44&cb1%5B4%5D=18%2C5%2C6258&cb1%5B11%5D=19%2C5%2C6259&cb1%5B18%5D=16%2C5%2C6260&cb1%5B25%5D=143%2C5%2C6261&cb1%5B32%5D=39%2C5%2C347&cb1%5B39%5D=42%2C5%2C1114&cb1%5B46%5D=6%2C5%2C1306&cb1%5B53%5D=29%2C5%2C1173&cb1%5B60%5D=35%2C5%2C1047&cb1%5B67%5D=37%2C5%2C1808&cb1%5B74%5D=70%2C5%2C1456&cb1%5B81%5D=79%2C5%2C1366&cb1%5B88%5D=54%2C5%2C1334&cb1%5B95%5D=61%2C5%2C1499&cb1%5B102%5D=60%2C5%2C1460&cb1%5B109%5D=67%2C5%2C1135&cb1%5B116%5D=95%2C5%2C627&cb1%5B123%5D=141%2C5%2C329&cb1%5B130%5D=88%2C5%2C531&cb1%5B137%5D=119%2C5%2C583&cb1%5B144%5D=161%2C5%2C234&cb1%5B151%5D=183%2C5%2C225&cb1%5B158%5D=187%2C5%2C315&cb1%5B165%5D=196%2C5%2C20&cb1%5B172%5D=195%2C5%2C44&cb1%5B5%5D=86%2C6%2C1545&cb1%5B12%5D=55%2C6%2C1403&cb1%5B19%5D=64%2C6%2C1149&cb1%5B26%5D=53%2C6%2C1370&cb1%5B33%5D=66%2C6%2C1472&cb1%5B40%5D=82%2C6%2C1295&cb1%5B47%5D=48%2C6%2C1439&cb1%5B54%5D=30%2C6%2C1080&cb1%5B61%5D=73%2C6%2C705&cb1%5B68%5D=33%2C6%2C1036&cb1%5B75%5D=41%2C6%2C588&cb1%5B82%5D=113%2C6%2C1129&cb1%5B6%5D=5%2C7%2C589&cb1%5B13%5D=74%2C7%2C1343&cb1%5B20%5D=78%2C7%2C1127&cb1%5B27%5D=31%2C7%2C5854&cb1%5B34%5D=17%2C7%2C6262&cb1%5B41%5D=34%2C7%2C742&cb1%5B48%5D=36%2C7%2C564&cb1%5B55%5D=38%2C7%2C238
		 * 4 POST https://www.iauc.co.jp/auction/prertinf03.jsp?timestamp=1322206485195
		 * 		data: step=2&maker=08&carList=%25B4%25D9%25CC
		 * 5 POST https://www.iauc.co.jp/auction/preintginftl01.jsp?timestamp=1322206587361
		 * 		data: KATALIST%5B%5D=&GRADELIST%5B%5D=&COLORLIST%5B%5D=&SLCT_NENF=&SLCT_NENT=&SLCT_MILEAGEF=&SLCT_MILEAGET=&SLCT_ESTF=&SLCT_ESTT=&SLCT_SYAKEN=&SLCT_SHIFT=&SLCT_AUCCNT=1&cond=yes
		 */
		$init_timestamp = ""; // preframe01

		$preframe01_url = "https://www.iauc.co.jp/auction/preframe01.jsp"; 			//
		$preframe02_url = "https://www.iauc.co.jp/auction/preframe02.jsp"; 			// step 0, no need timestamp
		$preindex01_url = "https://www.iauc.co.jp/auction/preindex01.jsp"; 			// step 1
		$preframecar01_url = "https://www.iauc.co.jp/auction/preframecar01.jsp"; 	// step 2

		$preexcar01_url = "https://www.iauc.co.jp/auction/preexcar01.jsp?timestamp=1439615307894";

		$auctionSearchCar21_url = "https://www.iauc.co.jp/auction/auctionSearchCar21.jsp?timestamp=1439615554184&pIntg=1";

		$auctionSearchCar22_url = "https://www.iauc.co.jp/auction/auctionSearchCar22.jsp?timestamp=1439615943997";

		// auction result url
		$preintgvedtl01_url = "https://www.iauc.co.jp/auction/preintgvedtl01.jsp?timestamp=1439616964069";

		// $preexcar01_url = "https://www.iauc.co.jp/auction/preexcar01.jsp"; 			// step 3
		$prertinf03_url = "https://www.iauc.co.jp/auction/prertinf03.jsp"; 			// step 4
		$preintginftl01_url = "https://www.iauc.co.jp/auction/preintginftl01.jsp"; 	// step 5 [final]


		// init timestamps
		$preframe01_url_timestamp = $preframe01_url;
		$preframe02_url_timestamp = $preframe02_url;
		//$preindex01_url_timestamp = $preindex01_url;


		// *********************** LOGIN **************************************//

		if(!defined("COOKIE_PATH")) define("COOKIE_PATH", FCPATH."tmp/cookie.txt");
		$login_attempt = 1;
		$do_login = FALSE;
		if($this->do_login == TRUE){
			while($do_login == FALSE && $login_attempt <= 3){
				$do_login = $this->_login();
				$login_attempt++;
			}
			if(!$do_login){
				//echo "LOGIN FAILED!!!";
				return;
			}
		}

		//return;
		//*************************** END LOGIN **********************************//

		// start here
		$preindex01_url_timestamp = $preindex01_url."?timestamp=".$this->_get_preindex01_timestamp();
		if(!$preindex01_url_timestamp) return;
		//echo $preindex01_url_timestamp;
		// fetch preindex01

		// OK
		$preframecar01_timestamp = $this->_get_timestamp("preframecar01", $preindex01_url_timestamp, $preframe01_url_timestamp);
		if(!$preframecar01_timestamp) return;
		// echo "preframecar01: ".$preframecar01_timestamp.";";
		$preframecar01_url_timestamp = $preframecar01_url."?timestamp=".$preframecar01_timestamp;
		echo "preframecar01_url_timestamp: ". $preframecar01_url_timestamp . "\n";

		// OK
		// fetch preframecar01 to get preexcar01 info
		$preexcar01_timestamp = $this->_get_timestamp("preexcar01", $preframecar01_url_timestamp, $preindex01_url_timestamp);
		if(!$preexcar01_timestamp) return;
		//echo "preexcar01_timestamp: ".$preexcar01_timestamp.";";
		$preexcar01_url_timestamp = $preexcar01_url."?timestamp=".$preexcar01_timestamp;
		echo "preexcar01_url_timestamp: " . $preexcar01_url_timestamp . "\n";

		// fetch preexcar01 to get auctionSearchCar21 data
		$auctionSearchCar21_timestamp = $this->_get_timestamp("auctionSearchCar21", $preexcar01_url_timestamp, $preframecar01_url_timestamp);
		if(!$auctionSearchCar21_timestamp) return;
		//echo "preexcar01_timestamp: ".$preexcar01_timestamp.";";
		$auctionSearchCar21_url_timestamp = $auctionSearchCar21_url."?timestamp=".$auctionSearchCar21_timestamp;
		echo "auctionSearchCar21_url_timestamp: " . $auctionSearchCar21_url_timestamp . "\n";


		// OK
		// fetch auctionSearchCar21 to get auctionSearchCar22 data
		$post_data = "cb1%5B6%5D=5%2C7%2C771&cb1%5B13%5D=74%2C7%2C1521&cb1%5B20%5D=78%2C7%2C1309&cb1%5B27%5D=56%2C7%2C868&cb1%5B34%5D=87%2C7%2C969&cb1%5B41%5D=31%2C7%2C6033&cb1%5B48%5D=235%2C7%2C1567&cb1%5B55%5D=17%2C7%2C8037&cb1%5B62%5D=34%2C7%2C920&cb1%5B69%5D=36%2C7%2C741&cb1%5B76%5D=38%2C7%2C416&cb1%5B1%5D=25%2C2%2C1567&cb1%5B8%5D=12%2C2%2C683&cb1%5B15%5D=14%2C2%2C670&cb1%5B22%5D=13%2C2%2C746&cb1%5B29%5D=15%2C2%2C640&cb1%5B36%5D=11%2C2%2C411&cb1%5B43%5D=10%2C2%2C479&cb1%5B50%5D=65%2C2%2C1656&cb1%5B57%5D=231%2C2%2C1155&cb1%5B2%5D=2%2C3%2C769&cb1%5B9%5D=4%2C3%2C534&cb1%5B16%5D=1%2C3%2C414&cb1%5B23%5D=20%2C3%2C8038&cb1%5B30%5D=22%2C3%2C8039&cb1%5B37%5D=23%2C3%2C8040&cb1%5B44%5D=21%2C3%2C8041&cb1%5B51%5D=163%2C3%2C8042&cb1%5B58%5D=93%2C3%2C1373&cb1%5B65%5D=28%2C3%2C1129&cb1%5B72%5D=62%2C3%2C1701&cb1%5B79%5D=63%2C3%2C1639&cb1%5B86%5D=68%2C3%2C1612&cb1%5B93%5D=71%2C3%2C1390&cb1%5B100%5D=80%2C3%2C1391&cb1%5B107%5D=206%2C3%2C940&cb1%5B114%5D=186%2C3%2C369&cb1%5B121%5D=185%2C3%2C551&cb1%5B128%5D=160%2C3%2C447&cb1%5B135%5D=117%2C3%2C624&cb1%5B142%5D=142%2C3%2C466&cb1%5B149%5D=148%2C3%2C282&cb1%5B156%5D=139%2C3%2C287&cb1%5B163%5D=146%2C3%2C134&cb1%5B170%5D=147%2C3%2C133&cb1%5B177%5D=192%2C3%2C64&cb1%5B184%5D=193%2C3%2C86&cb1%5B191%5D=211%2C3%2C76&cb1%5B198%5D=216%2C3%2C56&cb1%5B205%5D=219%2C3%2C31&cb1%5B212%5D=197%2C3%2C202&cb1%5B219%5D=198%2C3%2C208&cb1%5B226%5D=217%2C3%2C188&cb1%5B233%5D=212%2C3%2C160&cb1%5B3%5D=3%2C4%2C1319&cb1%5B10%5D=89%2C4%2C1823&cb1%5B17%5D=165%2C4%2C460&cb1%5B24%5D=40%2C4%2C801&cb1%5B31%5D=91%2C4%2C1126&cb1%5B38%5D=43%2C4%2C1197&cb1%5B45%5D=114%2C4%2C586&cb1%5B52%5D=111%2C4%2C1146&cb1%5B59%5D=162%2C4%2C273&cb1%5B66%5D=224%2C4%2C18&cb1%5B73%5D=7%2C4%2C2906&cb1%5B80%5D=90%2C4%2C800&cb1%5B87%5D=59%2C4%2C1684&cb1%5B94%5D=57%2C4%2C1365&cb1%5B101%5D=84%2C4%2C1286&cb1%5B108%5D=52%2C4%2C1104&cb1%5B115%5D=81%2C4%2C889&cb1%5B122%5D=140%2C4%2C735&cb1%5B129%5D=194%2C4%2C223&cb1%5B4%5D=18%2C5%2C8033&cb1%5B11%5D=19%2C5%2C8034&cb1%5B18%5D=16%2C5%2C8035&cb1%5B25%5D=143%2C5%2C8036&cb1%5B32%5D=39%2C5%2C530&cb1%5B39%5D=42%2C5%2C1298&cb1%5B46%5D=6%2C5%2C1494&cb1%5B53%5D=29%2C5%2C1355&cb1%5B60%5D=35%2C5%2C1227&cb1%5B67%5D=37%2C5%2C1989&cb1%5B74%5D=70%2C5%2C1635&cb1%5B81%5D=79%2C5%2C1549&cb1%5B88%5D=54%2C5%2C1516&cb1%5B95%5D=61%2C5%2C1680&cb1%5B102%5D=60%2C5%2C1642&cb1%5B109%5D=67%2C5%2C1308&cb1%5B116%5D=95%2C5%2C808&cb1%5B123%5D=88%2C5%2C711&cb1%5B130%5D=119%2C5%2C762&cb1%5B137%5D=161%2C5%2C321&cb1%5B144%5D=183%2C5%2C313&cb1%5B151%5D=187%2C5%2C404&cb1%5B158%5D=196%2C5%2C109&cb1%5B165%5D=195%2C5%2C222&cb1%5B5%5D=30%2C6%2C1262&cb1%5B12%5D=73%2C6%2C888&cb1%5B19%5D=33%2C6%2C1216&cb1%5B26%5D=41%2C6%2C772&cb1%5B33%5D=113%2C6%2C1307&cb1%5B40%5D=221%2C6%2C40&cb1%5B47%5D=222%2C6%2C40&cb1%5B54%5D=223%2C6%2C40&cb1%5B61%5D=86%2C6%2C1725&cb1%5B68%5D=55%2C6%2C1585&cb1%5B75%5D=64%2C6%2C1331&cb1%5B82%5D=53%2C6%2C1552&cb1%5B89%5D=66%2C6%2C1654&cb1%5B96%5D=82%2C6%2C1477&cb1%5B103%5D=48%2C6%2C1622&cb0%5BA990%5D=990%2C9%2C99999&cb0%5BA26%5D=26%2C9%2C2422&cb0%5BA225%5D=225%2C9%2C68&cb0%5BA205%5D=205%2C9%2C225&cb0%5BA208%5D=208%2C9%2C218&cb0%5BA214%5D=214%2C9%2C166&cb0%5BA226%5D=226%2C9%2C62&cb0%5BA227%5D=227%2C9%2C45&cb0%5BA991%5D=991%2C9%2C99999&cb0%5BA958%5D=958%2C9%2C2422&cb0%5BA6%5D=on&cb0%5BA7%5D=on&cb0%5BA8%5D=on";
		$auctionSearchCar22_timestamp = $this->_get_timestamp("auctionSearchCar22", $auctionSearchCar21_url_timestamp, $preexcar01_url_timestamp, "POST", $post_data);
		if(!$auctionSearchCar22_timestamp) return;
		$auctionSearchCar22_url_timestamp = $auctionSearchCar22_url."?timestamp=".$auctionSearchCar22_timestamp;
		echo "auctionSearchCar22_url_timestamp: " . $auctionSearchCar22_url_timestamp . "\n";

		// POST auctionSearchCar22 to get preintgvedtl01 timestamp
		$post_data = "cb2%5B0%5D=00&cb2%5B1%5D=01&cb2%5B2%5D=03&cb2%5B3%5D=02&cb2%5B4%5D=04&cb2%5B5%5D=05&cb2%5B6%5D=06&cb2%5B7%5D=07&cb2%5B8%5D=08&cb2%5B26%5D=12&cb2%5B9%5D=29";
		$preintgvedtl01_timestamp = $this->_get_timestamp("preintgvedtl01", $auctionSearchCar22_url_timestamp, $auctionSearchCar21_url_timestamp, "POST", $post_data);
		if(!$preintgvedtl01_timestamp) return;
		$preintgvedtl01_url_timestamp = $preintgvedtl01_url."?timestamp=".$preintgvedtl01_timestamp;
		echo "preintgvedtl01_url_timestamp: " . $preintgvedtl01_url_timestamp . "\n";

		$this->preintgvedtl01_url_timestamp = $preintgvedtl01_url_timestamp;

		// GET search result
		// https://www.iauc.co.jp/auction/preintgvedtl01.jsp?timestamp=1439634123422
		$car_name = str_replace("%", "%25", $type_encoded);
		echo "CAR_NAME: {$car_name}\n";
		$post_data = "slct1%5B%5D={$car_name}&slct=yes&pIntg=1";
		// $post_data = "slct1%5B%5D=MR-S&slct=yes&pIntg=1";
		$pagesize = 100;
		$ref = $auctionSearchCar22_url_timestamp;
		$preintgvedtl01_curl = $this->_download_page($this->preintgvedtl01_url_timestamp, array(
			'ref' => $ref,
			'post_data' => $post_data,
			'page' => 'type_'.$type_id,
			'method' => "POST",
		));
		$preintgvedtl01_html = $preintgvedtl01_curl[0]; // <=== List auctions page

		// echo $preintgvedtl01_html;

		// fetch $preexcar01 [POST 1]
		// $post_data = "cb1%5B1%5D=25%2C2%2C1384&cb1%5B8%5D=12%2C2%2C501&cb1%5B15%5D=14%2C2%2C488&cb1%5B22%5D=13%2C2%2C563&cb1%5B29%5D=15%2C2%2C458&cb1%5B36%5D=11%2C2%2C229&cb1%5B43%5D=10%2C2%2C296&cb1%5B50%5D=65%2C2%2C1474&cb1%5B2%5D=2%2C3%2C588&cb1%5B9%5D=4%2C3%2C353&cb1%5B16%5D=1%2C3%2C233&cb1%5B23%5D=20%2C3%2C6263&cb1%5B30%5D=22%2C3%2C6264&cb1%5B37%5D=23%2C3%2C6265&cb1%5B44%5D=21%2C3%2C6266&cb1%5B51%5D=163%2C3%2C6267&cb1%5B58%5D=93%2C3%2C1190&cb1%5B65%5D=28%2C3%2C947&cb1%5B72%5D=62%2C3%2C1516&cb1%5B79%5D=63%2C3%2C1456&cb1%5B86%5D=68%2C3%2C1432&cb1%5B93%5D=71%2C3%2C1207&cb1%5B100%5D=80%2C3%2C1210&cb1%5B107%5D=206%2C3%2C759&cb1%5B114%5D=186%2C3%2C281&cb1%5B121%5D=185%2C3%2C463&cb1%5B128%5D=160%2C3%2C360&cb1%5B135%5D=117%2C3%2C443&cb1%5B142%5D=142%2C3%2C288&cb1%5B149%5D=148%2C3%2C105&cb1%5B156%5D=146%2C3%2C62&cb1%5B163%5D=147%2C3%2C59&cb1%5B170%5D=192%2C3%2C20&cb1%5B177%5D=193%2C3%2C20&cb1%5B184%5D=197%2C3%2C24&cb1%5B191%5D=198%2C3%2C30&cb1%5B3%5D=3%2C4%2C1139&cb1%5B10%5D=89%2C4%2C1638&cb1%5B17%5D=165%2C4%2C269&cb1%5B24%5D=40%2C4%2C619&cb1%5B31%5D=91%2C4%2C945&cb1%5B38%5D=114%2C4%2C403&cb1%5B45%5D=111%2C4%2C965&cb1%5B52%5D=162%2C4%2C186&cb1%5B59%5D=7%2C4%2C2723&cb1%5B66%5D=90%2C4%2C610&cb1%5B73%5D=43%2C4%2C1012&cb1%5B80%5D=59%2C4%2C1502&cb1%5B87%5D=57%2C4%2C1187&cb1%5B94%5D=140%2C4%2C557&cb1%5B101%5D=139%2C4%2C99&cb1%5B108%5D=194%2C4%2C44&cb1%5B4%5D=18%2C5%2C6258&cb1%5B11%5D=19%2C5%2C6259&cb1%5B18%5D=16%2C5%2C6260&cb1%5B25%5D=143%2C5%2C6261&cb1%5B32%5D=39%2C5%2C347&cb1%5B39%5D=42%2C5%2C1114&cb1%5B46%5D=6%2C5%2C1306&cb1%5B53%5D=29%2C5%2C1173&cb1%5B60%5D=35%2C5%2C1047&cb1%5B67%5D=37%2C5%2C1808&cb1%5B74%5D=70%2C5%2C1456&cb1%5B81%5D=79%2C5%2C1366&cb1%5B88%5D=54%2C5%2C1334&cb1%5B95%5D=61%2C5%2C1499&cb1%5B102%5D=60%2C5%2C1460&cb1%5B109%5D=67%2C5%2C1135&cb1%5B116%5D=95%2C5%2C627&cb1%5B123%5D=141%2C5%2C329&cb1%5B130%5D=88%2C5%2C531&cb1%5B137%5D=119%2C5%2C583&cb1%5B144%5D=161%2C5%2C234&cb1%5B151%5D=183%2C5%2C225&cb1%5B158%5D=187%2C5%2C315&cb1%5B165%5D=196%2C5%2C20&cb1%5B172%5D=195%2C5%2C44&cb1%5B5%5D=86%2C6%2C1545&cb1%5B12%5D=55%2C6%2C1403&cb1%5B19%5D=64%2C6%2C1149&cb1%5B26%5D=53%2C6%2C1370&cb1%5B33%5D=66%2C6%2C1472&cb1%5B40%5D=82%2C6%2C1295&cb1%5B47%5D=48%2C6%2C1439&cb1%5B54%5D=30%2C6%2C1080&cb1%5B61%5D=73%2C6%2C705&cb1%5B68%5D=33%2C6%2C1036&cb1%5B75%5D=41%2C6%2C588&cb1%5B82%5D=113%2C6%2C1129&cb1%5B6%5D=5%2C7%2C589&cb1%5B13%5D=74%2C7%2C1343&cb1%5B20%5D=78%2C7%2C1127&cb1%5B27%5D=31%2C7%2C5854&cb1%5B34%5D=17%2C7%2C6262&cb1%5B41%5D=34%2C7%2C742&cb1%5B48%5D=36%2C7%2C564&cb1%5B55%5D=38%2C7%2C238";
		// $ref = $preframecar01_url_timestamp;
		// $prertinf03_timestamp = $this->_get_timestamp("prertinf03", $preexcar01_url_timestamp, $ref, "POST", $post_data);
		// if(!$prertinf03_timestamp) return;
		// //echo "prertinf03_timestamp: ".$prertinf03_timestamp.";";
		// $prertinf03_url_timestamp = $prertinf03_url."?timestamp=".$prertinf03_timestamp;

		// // fetch prertinf03 [POST 2]
		// $ref = $preexcar01_url_timestamp;
		/*** RESERVED */

		// Auction data
		/*
		$maker_id = 1; // == 00 toyota; 2 = nissan
		$maker_iauc_id = "00";

		$type_id = 112;
		$type_encoded = "%C0%DE%B2%C5";
		*/
		// end auction data

		//$carList = $this->_encode_uri("ハイエースバン");
		//$carList =  "%25CA%25B2%25B4%25B0%25BD%25CA%25DE%25DD"; // carlist = type
		//$carList = str_replace("%", "%25", $type_encoded);// "iQ"; iauc change carList to SLCT_CARNAME on 16-05-2012
		// $car_name = str_replace("%", "%25", $type_encoded);
		// $post_data = "slct1%5B%5D={$car_name}&slct=yes&pIntg=1";
		// $post_data = "step=2&maker={$maker_iauc_id}&SLCT_CARNAME={$car_name}";
		// $preintginftl01_timestamp = $this->_get_timestamp("preintginftl01", $prertinf03_url_timestamp, $ref, "POST", $post_data);
		// if(!$preintginftl01_timestamp) return;

		//echo "preintginftl01_timestamp: ".$preintginftl01_timestamp.";";
		/*****/

		// GET CODE AND GRADE WHEN NEEDED, RUN ONCE
		if($this->get_code_grade_only == TRUE){
			$maker_list = $this->CI->auction->get_maker_list();
			foreach($maker_list as $maker)
			{
				$type_list = $this->CI->auction->get_type_list_by_maker_iauc_id($maker->iauc_id);
				$fix_list = array(53, 81, 155, 156, 157, 158, 159);
				foreach($type_list as $type)
				{
					if(!in_array($type->id, $fix_list)) continue;
					sleep($this->sleep_interval);
					echo $type->id."<br />";
					//$carList = $this->_encode_uri($type->name_jp);
					$carList = str_replace("%", "%25", $type->encoded);
					$post_data = "step=2&maker={$maker->iauc_id}&carList={$carList}";

					$curl = $this->_download_page($prertinf03_url_timestamp, array(
						'ref' => $ref,
						'post_data' => $post_data,
						'page' => "prertinf03_".$maker->iauc_id,
						'method' => "POST",
					));
					//$html = $curl[0];
					$this->gen_code_grade($type->name_jp, $maker->iauc_id);
					flush();
					echo "Waiting..<br />";
				}

			}
		}
		//return;

		/********************************************************************************************************/
		// preintginftl01: RESULT PAGE [POST 3]
		// $this->preintginftl01_url_timestamp = $preintginftl01_url."?timestamp=".$preintginftl01_timestamp; // FINAL URL
		// $pagesize = 100;
		// $post_data = "KATALIST%5B%5D=&GRADELIST%5B%5D=&COLORLIST%5B%5D=&SLCT_NENF=&SLCT_NENT=&SLCT_MILEAGEF=&SLCT_MILEAGET=&SLCT_ESTF=&SLCT_ESTT=&SLCT_SYAKEN=&SLCT_SHIFT=&SLCT_AUCCNT=1&cond=yes&pagesize={$pagesize}"; // Toyota bB
		// $ref = $prertinf03_url_timestamp;
		// $preintginftl01_curl = $this->_download_page($this->preintginftl01_url_timestamp, array(
		// 	'ref' => $ref,
		// 	'post_data' => $post_data,
		// 	'page' => 'type_'.$type_id,
		// 	'method' => "POST",
		// ));
		// $preintginftl01_html = $preintginftl01_curl[0]; // <=== List auctions page

		// GET TOTAL RESULT
		$total_result = $this->_get_total_result($preintgvedtl01_html);

		if($this->get_total_result_only == TRUE)
		{
			echo "<br />Total result: ".$total_result;
			return;
		}

		//echo $preintginftl01_html; // ok <----------------------------------
		echo "<br />Total result: ".$total_result;
		$this->_write_log("\nTotal Result: $total_result");

		if($total_result ==0) return;

		$total_page = ceil($total_result / $pagesize);

		echo "<hr />Detail page list:<br />";
		// PROCESS FIRST PAGE
		$this->_process_result_page_xpath($preintgvedtl01_html, $maker_id, $type_id);

		//return;

		// Download other pages if total_page > 1
		if($total_page > 1){
			$cur_page = 2; // page 1 already download
			while($cur_page <= $total_page){
				echo "<hr />Page:".$cur_page."<br />";
				$this->_write_log("\n-----Page: {$cur_page}-----\n");
				$next_page_html = $this->_next_page($cur_page);
				//$this->_process_result_page($next_page_html );
				$this->_process_result_page_xpath($next_page_html, $maker_id, $type_id);
				$cur_page++;
			}
		}

		// end PREINTGVEDT1010

		/*****************************************************************************************/
	}
	/**
	 * Get total result
	 * @param htmlContent $html (shift-jis): first result page
	 */
	function _get_total_result($html)
	{
		$total_result = 0;
		$total_result_matched = preg_match('@([0-9]+)件@', mb_convert_encoding($html, "UTF-8", "SHIFT-JIS"), $matches);
		if($total_result_matched){
			$total_result = $matches[1];
		}
		return $total_result;
	}

	/**
	 * Move result to next page
	 * @return html of next page
	 */
	function _next_page($page = 0)
	{
		$redirector = "https://www.iauc.co.jp/auction/preforward01.jsp?href=preintgvedtl01.jsp%3Fmode%3D1%26pages%3Dnext&target=_self";
		$next_page = "https://www.iauc.co.jp/auction/preintgvedtl01.jsp?mode=1&pages=next";

		// $redirector = "	https://www.iauc.co.jp/auction/preforward01.jsp?href=preintginftl01.jsp%3Fmode%3D1%26pages%3Dnext&target=_self";
		// $next_page = "https://www.iauc.co.jp/auction/preintginftl01.jsp?mode=1&pages=next";
		// $next_page = "https://www.iauc.co.jp/auction/preintgvedtl01.jsp?mode=1&pages=next";
		$curl = $this->_download_page($next_page, array(
			'ref' => $redirector,
			'page' => 'page_'.$page
		));
		return $curl[0];
	}

	/**
	 * Process result page, download detail page, etc..
	 * TODO NOT IN USED
	 */
	function _process_result_page($html)
	{
		$detail_url_matched = preg_match_all('/predtslct01.jsp\?type=(.*)&display=list&conferenceid=(?P<CONFERENCE_ID>[0-9]+)&holdingid=(?P<HOLDING_ID>[0-9]+)&auctionid=(?P<AUCTION_ID>[0-9]+)/', $html, $matches);
		if($detail_url_matched){
			$url_list = $matches[0];
			$i = 0;
			foreach($url_list as $url){
				//echo "[{$i}]".$url."<br />";
				$auction_id = $matches['AUCTION_ID'][$i];
				$conference_id = $matches['CONFERENCE_ID'][$i];
				$holding_id = $matches['HOLDING_ID'][$id];
				$detail_url = $this->auction_url.$url;
				$this->_write_log("Downloading [{$detail_url}]...");
				if($this->_download_detail_page($detail_url, $conference_id, $holding_id, $auction_id)){
					$this->_write_log("OK");
					$i++;
				}
				else $this->_write_log("Failed");
			}

		}
	}
	// use xpath
	function _process_result_page_xpath($html, $maker_id, $type_id)
	{
		//$html = mb_convert_encoding($html, "UTF-8", "SHIFT-JIS");
		$dom = new DOMDocument();
		@$dom->loadHTML($html);
		$xpath = new DOMXPath($dom);

		$root_path = '//*[@id="T2_INTG"]'; // result table
		$detail_link_path = "/td[2]/table[1]/tr[1]/td[2]/div/a"; // value: predtslct01.jsp?type=7&display=list&conferenceid=31&holdingid=5854&auctionid=3413
		$code_name_path = "/td[5]/span"; // value like NKR81A
		$grade_name_path = "/td[4]/span[2]";
		$conference_path = "/td[2]/span";

		$query = $xpath->query('//*[@id="T2_INTG"]/tr'); // for get total items
		$total_item = $query->length; // total detail page link on this result page
		echo "TOTAL: $total_item";

		$url_list = array();
		$code_list = array();
		$grade_list = array();
		$conference_list = array();
		for($i=1; $i<=$total_item; $i++){
			$href_q = $xpath->query($root_path."/tr[$i]".$detail_link_path);
			if(empty($href_q)) continue;
			$href = $href_q->item(0)->getAttribute("href");
			$url_list[$i] = $href;

			// TODO: if code name or grade name not found, maybe need to re-login?
			// code name
			$code_q = $xpath->query($root_path."/tr[$i]".$code_name_path);
			if($code_q->length > 0)	{
				$code = $code_q->item(0)->nodeValue;
			}
			else{
				$code = "";
			}
			$code_list[$i] = trim($code);

			// grade name
			$grade_q = $xpath->query($root_path."/tr[$i]".$grade_name_path);
			if($grade_q->length > 0){
				$grade = $grade_q->item(0)->textContent;
			}
			else{
				$grade = "";
			}
			$grade_list[$i] = trim($grade);

			// conference (area)
			$confer_q = $xpath->query($root_path."/tr[$i]".$conference_path);
			if($confer_q->length > 0){
				$confer = $confer_q->item(0)->nodeValue;
			}
			else{
				$confer = "";
			}
			$conference_list[$i] = trim($confer);
		}

		// Now downloading each detail page
		for($i=1; $i <= $total_item; $i++){
			flush();
			$this->counter++;

			$url = $url_list[$i];
			if(empty($url)) continue;

			$conference_id_m = preg_match("/conferenceid=([0-9]+)/", $url, $matches);
			if($conference_id_m) $conference_id = $matches[1];
			$holding_id_m = preg_match("/holdingid=([0-9]+)/", $url, $matches);
			if($holding_id_m) $holding_id = $matches[1];
			$auction_id_matched = preg_match("/auctionid=([0-9]+)/", $url, $matches);
			if($auction_id_matched){
				$auction_id = $matches[1];
			}
			else{
				//die("auction id not found!"); //TODO ?
				continue;
			}

			// check if auction exists
			if($this->CI->auction->auction_exists($type_id, $conference_id, $holding_id, $auction_id)){
				continue;
			}

			// Process conference name
			if(!$this->CI->auction->conference_exists($conference_id)){
				@$this->CI->auction->add_conference($conference_id, $conference_list[$i]);
			}

			$detail_url = $this->auction_url.$url;
			//echo "<br />Downloading [{$detail_url}]...";
			$this->_write_log("\nDownloading [{$detail_url}]...");
			//echo "grade:". $grade_list[$i];
			if($this->_download_detail_page($detail_url, $conference_id, $holding_id, $auction_id, $maker_id, $type_id, $code_list[$i], $grade_list[$i])){
				//echo " Done<br />";
				$this->_write_log("[Done]");
			}
			else
			{
				//echo "Failed!";
				$this->_write_log("[Failed!]");
			}
			//ob_flush();
      		flush();
			echo "Sleeping...<br />";
			$this->_write_log("\nSleeping...");
			sleep($this->sleep_interval);
			//if($this->counter == 5) break;
		}


	}

	/**
	 *
	 * Downoad Detail page [IMG]
	 * @param string $detail_url
	 * @param int $auc_id
	 */

	function _download_detail_page($detail_url, $conference_id, $holding_id, $auc_id, $maker_id, $type_id, $code_name, $grade_name)
	{
		//echo "GRADE: ".$grade_name."<br />";
		$detail_curl = $this->_download_page($detail_url, array(
			// "ref" => $this->preintginftl01_url_timestamp,
			"ref" => $this->preintgvedtl01_url_timestamp,
			"page" => "detail_".$auc_id
		));
		if(!$detail_curl) return FALSE;

		$detail_html = $detail_curl[0];
		if(empty($detail_html)) return FALSE; // TODO empty html, why ?
		$detail_html = mb_convert_encoding($detail_html, "UTF-8", "SHIFT-JIS");

		// DOWNLOAD IMAGE on detail page
		$img_filename_list = array();

		$img_matched = preg_match_all('@prezoom01\.jsp\?imgname=/pv/IMG_SVR_PASS/(.*)/(.*)/(WWW|www)/(.*)/(.*)/(?P<NAME>.*)\.(?P<EXT>[A-Z]{3,4})@', $detail_html, $matches);
		if($img_matched){
			// image dir
			$img_dir = FCPATH."data/img/".$this->maker->name_en."/".$type_id."/".$conference_id."/".$holding_id."/".$auc_id."/";
			if(!file_exists($img_dir)){
				mkdir($img_dir, 0777, TRUE);
			}

			$img_list = $matches[0];
			$i = 0;
			foreach($img_list as $img)
			{
				$img_link = $this->home_url."pv/IMG_SVR_PASS/".$matches[1][$i]."/".$matches[2][$i]."/www/".$matches[4][$i]."/".$matches[5][$i]."/".$matches[6][$i].".".$matches[7][$i];

				$img_filename = $matches['NAME'][$i].".".$matches['EXT'][$i];
				$img_path = $img_dir.$img_filename;
				if(!file_exists($img_path)){
					$img_curl = $this->_download_page($img_link, array(
						'ref' => $this->preintginftl01_url_timestamp,
					));

					if($img_curl[0])
					{
						file_put_contents($img_path, $img_curl[0]);
					}
				}
				array_push($img_filename_list, $img_filename);
				$i++;
			}
		}
		else{
			//echo "image not found!";
		}

		//process data and insert to db
		//$this->_process_detail_page($auc_id, $code_name, "いすゞ", "ｴﾙﾌ", $detail_html);
		$this->_process_detail_page($conference_id, $holding_id, $auc_id, $maker_id, $type_id, $code_name, $grade_name, $detail_html, $img_filename_list);
		//var_dump($detail_html);

		return TRUE;

	}

	/*
	 * PROCESS detail page and insert into database
	 */
	//function _process_detail_page($auction_id, $code_name, $maker, $car_type, $html, $opt = NULL)
	function _process_detail_page($conference_id, $holding_id, $auction_id, $maker_id, $type_id, $code_name, $grade_name, $html, $img_filename_list = array(), $opt = NULL)
	{
		$fields = array(
			"point" => "評価点",
			"distance" => "走行",
			"grade"				=> "グレード", // for checking only, do not insert to db
			"color"				=> "色",
			"cooling"			=> "冷房",
			"year"				=> "年式",
			"fuel"				=> "燃料",
			"cubic_capacity"		=> "排気量", // phan khoi
			"body"				=> "ﾎﾞﾃﾞｨ形状",
			"capacity"			=> "定員",
			"loading"			=> "積載|積載量", // trong tai
			"shift"				=> "シフト",
			"equipment"			=> "装備",
			"comment"			=> "特記",
			"start_price" 		=> "スタート",
			"result_price"		=> "結果",
			"venue"				=> "会場名", // dia diem
			"auction_day"		=> "開催日",
			"corner"			=> "ｺｰﾅｰ名",
			"unique_number"		=> "Unique number",
		);

		$db_fields = array();
		$key_list = array();
		foreach($fields as $en => $jp){
			$db_fields[$en] = "";
			$key_list[] = $en;
		}
		$db_fields['conference_id'] = $conference_id;
		$db_fields['holding_id'] = $holding_id;
		$db_fields["auction_id"] = $auction_id;
		//$db_fields["code_name"] = $code_name;

		// img list, separate by comma
		$img_filename_list_str = "";
		if(sizeof($img_filename_list) > 0){
			$img_filename_list_str = implode(",", $img_filename_list);
		}
		$db_fields['img'] = $img_filename_list_str;
		// IF LAYOUT 1 (almost detail pages)
		foreach($fields as $en => $jp){
			$matched = preg_match("@>\s*({$jp})</td>\s*<td.*>(.*)(&nbsp;<span style=\"color: red;\">&nbsp;</span>)*</td>@", $html, $matches);
			if(!$matched){
				$matched = preg_match("@>\s*({$jp})</td>\s*<td.*>(.*)</td>@", $html, $matches);
			}
			// grade failed
			if($en == "grade" && !$matched){
				$jp = "駆動";
				$matched = preg_match("@>\s*({$jp})</td>\s*<td.*>(.*)</td>@", $html, $matches);
			}
			// distance failed
			if($en == "distance" && !$matched){
				$matched = preg_match("@>\s*({$jp})</td><td.*>([0-9]+)千km</td>@", $html, $matches);
			}

			if($matched){
				$val = trim(strip_tags($matches[2]));
				$val = str_replace("&nbsp;", " ", $val);
				$db_fields[$en] = $val;
			}
		}
		// IF LAYOUT 2 i.e 6090, 4070
		// net to re-process: auction_day, start_price, cubic_capacity, year, distance, shift, point, comment, color, cooling, equipment
		if(empty($db_fields["auction_day"])){
			echo "Layout 2";
			$dom = new DOMDocument();
			@$dom->loadHTML($html);
			$xpath = new DOMXPath($dom);
			//start_price
			$start_price_path = "/html/body/form[3]/div[3]/table/tr/td[3]/table/tr/td/table/tr/td[2]/table/tr/td";
			$q = $xpath->query($start_price_path);
			//$start_price = $q->item(0)->nodeValue;
			if($q->length > 0) $db_fields['start_price'] = $q->item(0)->nodeValue;

			// year
			$year_path = "/html/body/form[3]/div[2]/table/tr/td/table/tr[2]/td[3]";
			$q = $xpath->query($year_path);
			//$year = $q->item(0)->nodeValue;
			if($q->length > 0) $db_fields['year'] = $q->item(0)->nodeValue;

			// cubic_capacity
			$cc_path = "/html/body/form[3]/div[2]/table/tr/td/table/tr[2]/td[5]";
			$q = $xpath->query($cc_path);
			//$cc = $q->item(0)->nodeValue;
			if($q->length > 0) $db_fields['cubic_capacity'] = $q->item(0)->nodeValue;

			// distance
			$distance_path = "/html/body/form[3]/div[2]/table/tr/td/table/tr[2]/td[7]";
			$q = $xpath->query($distance_path);
			//$distance = $q->item(0)->nodeValue;
			if($q->length > 0) $db_fields['distance'] = $q->item(0)->nodeValue;

			// shift
			$shift_path = "/html/body/form[3]/div[2]/table/tr/td/table/tr[2]/td[8]";
			$q = $xpath->query($shift_path);
			//$shift = $q->item(0)->nodeValue;
			if($q->length > 0) $db_fields['shift'] = $q->item(0)->nodeValue;

			// point
			$point_path = "/html/body/form[3]/div[2]/table/tr/td/table/tr[2]/td[10]";
			$q = $xpath->query($point_path);
			//$point = $q->item(0)->nodeValue;
			if($q->length > 0) $db_fields['point'] = $q->item(0)->nodeValue;

			// comment
			$comment_path = "/html/body/form[3]/div[3]/table/tr/td/table/tr/td[4]";
			$q = $xpath->query($comment_path);
			//$comment = $q->item(0)->nodeValue;
			if($q->length > 0) $db_fields['comment'] = $q->item(0)->nodeValue;

			// color (exterior color)
			$color_path = "/html/body/form[3]/div[3]/table/tr/td/table/tr[3]/td[2]";
			$q = $xpath->query($color_path);
			//$color = $q->item(0)->nodeValue;
			if($q->length > 0) $db_fields['color'] = $q->item(0)->nodeValue;

			// cooling
			$cooling_path = "/html/body/form[3]/div[3]/table/tr/td/table/tr/td[2]";
			$q = $xpath->query($cooling_path);
			//$cooling = $q->item(0)->nodeValue;
			if($q->length > 0) $db_fields['cooling'] = $q->item(0)->nodeValue;

			// equipment
			$equipment_path = "/html/body/form[3]/div[3]/table/tr/td/table/tr[8]/td[2]";
			$q = $xpath->query($equipment_path);
			//$equipment = $q->item(0)->nodeValue;
			if($q->length > 0) $db_fields['equipment'] = $q->item(0)->nodeValue;
		}


		// LAYOUT 3, e.g 3114, @see html_check folder
		if(trim($db_fields['grade']) == "年式"){
			echo "Layout 3";
			$this->_write_log("[Layout3]");

			mb_internal_encoding("SJIS");

			$dom = new DOMDocument();
			@$dom->loadHTML($html);
			$xpath = new DOMXPath($dom);

			//var_dump(preg_match('/年式/', $html));

					// label
			$label_list = array(
				"year" 		=> "å¹´å¼", //"年式"
				"cc" 		=> "ææ°é", //"排気量",
				//"grade"		=> "グレード", "ã°ã¬ã¼ã",
				"distance" 	=> "èµ°è¡", //"走行",//
				"shift" 	=> "ã·ãã", //"シフト", //
				"point"		=> "è©ä¾¡ç¹",
			);

			$label_list2 = array(
				"year" 		=> '年式', //"年式"
				"cc" 		=> '排気量', //"排気量",
				"distance" 	=> "走行", //"走行",//
				"shift" 	=> 'シフト', //"シフト", //
				"point"		=> "評価点",//評価点
			);
			$db_fields['year'] = $this->_layout3_get_value($html, $xpath, "year", '年式', 'å¹´å¼');
			$db_fields['cubic_capacity'] = $this->_layout3_get_value($html, $xpath, "cc",'排気量', "ææ°é");
			$db_fields['distance'] = $this->_layout3_get_value($html, $xpath, "distance", '走行', "èµ°è¡");
			$db_fields['shift'] = $this->_layout3_get_value($html, $xpath, "shift", 'シフト',  "ã·ãã");
			$db_fields['point'] = $this->_layout3_get_value($html, $xpath, "point", '評価点', "è©ä¾¡ç¹");
        	$db_fields['equipment'] = $this->_layout3_get_value($html, $xpath, "equipment", '装備', "装備");
			if(empty($db_fields['comment'])){
				$db_fields['comment'] = $this->_layout3_get_value($html, $xpath, "comment", "ｱｲｵｰｸｺﾒﾝﾄ", "ｱｲｵｰｸｺﾒﾝﾄ");
			}

		      if(empty($db_fields['venue'])){
			$db_fields['venue'] = $this->_layout3_get_value($html, $xpath, "venue", "会場名", "開催会場");
		      }
			//$year = $db_fields['year'];
			//echo "year: $year; cc: $cc; distance: $distance; point: $point; shift: $shift"; return;

			// FIX point and shift == holding_id | year
			if($db_fields['shift'] == $holding_id || $db_fields['shift'] == $db_fields['year']) $db_fields['shift'] = "";
			if($db_fields['point'] == $holding_id || $db_fields['point'] == $db_fields['year']) $db_fields['point'] = "";

		}
		// end Layout 3


		//echo "<table border='1'>";
		foreach($db_fields as $key => $val){
			//echo "<tr><td>{$key}</td><td>".$fields[$key]."</td><td>{$val}</td></tr>";
			$db_fields[$key] = trim($val);
		}

		// year value. sample: 63年, S61..
		$year_jp = intval(preg_replace("@[A-Za-z]+@", "", $db_fields['year']));
		$year_conversion = $this->CI->config->item("year_conversion");
		if(array_key_exists($year_jp, $year_conversion)){
			$year_std = $year_conversion[$year_jp];
			$db_fields['year'] = $year_std;
		}
		else{
			$db_fields['year'] = 0;
		}

		// loading
		$db_fields["loading"] = str_replace(",", "", $db_fields["loading"]);
		$db_fields["loading"] = intval($db_fields["loading"]);

		// auction day 2011年11月30日
		$day_matched = preg_match("@([0-9]{2,4})年([0-9]{1,2})月([0-9]{1,2})@", $html, $day_matches);
		if($day_matched){
			$db_fields["auction_day"] = $day_matches[1]."-".$day_matches[2]."-".$day_matches[3];
		}

		// RESULT PRICE
		if(empty($db_fields["result_price"])){
			/*
			$rp_matched = preg_match('@成約.*<td align="right" bgcolor="#FFFFFF" class="tableT">(.*)万円</td>@ims', $html, $rp_matches);
			if(!$rp_matched){
				$rp_matched = preg_match('@成約.*<td.*>(.*)万円</td>@ims', $html, $rp_matches);
			}
			*/
			$rp_matched = preg_match('@成約(.*)万円@ims', $html, $rp_matches);
			if($rp_matched){
				//echo $rp_matches[1];
				$db_fields["result_price"] = trim(strip_tags($rp_matches[1]));
			}
		}

		// Do not store zero-result_price auction
		if(floatval($db_fields['result_price']) <= 0)
		{
			$this->_write_log("[Result price = 0 => skipped]");
			return;
		}

		// CODE_NAME, UNIQUE NUMBER
		// いすゞ  ｴﾙﾌ NKR58E-7109601
		for($i = 10; $i >= 6 ; $i--){
			$mk_matched = preg_match("@{$code_name}.*([\d]{{$i}})@", $html, $mk_matches);
			if($mk_matched){
				$db_fields["unique_number"] = $mk_matches[1];
				break;
			}
		}


		$db_fields["maker_id"] = $maker_id;
		$db_fields["type_id"] = $type_id;
		//$code =  $this->CI->auction->get_code_by_name($code_name);
		$code_id = $this->CI->auction->get_code_type($code_name, $type_id);
		// if new code, add to db
		if($code_id == NULL){
			$code_id = $this->CI->auction->add_code($code_name, $type_id);
		}
		$db_fields["code_id"] = $code_id;

		// grade name
		$grade_name = trim($grade_name);
		//$db_fields['grade'] = $grade_name;

		// get grade id
		if(!empty($grade_name)){
			$grade = $this->CI->auction->get_grade_by_name($grade_name);
			// not found? try with no spaces
			if($grade == NULL){
				$grade = $this->CI->auction->get_grade_by_name(str_replace(" ", "", $grade_name));
			}
			// still not found, add new one
			if($grade == NULL){
				$grade_id = $this->CI->auction->add_grade($grade_name, $code_id);
			}
			else{
				$grade_id = $grade->id;
			}
			$db_fields['grade_id'] = $grade_id;

			if(!$this->CI->auction->code_grade_exists($code_id, $grade_id)){
				$this->CI->auction->add_code_grade($code_id, $grade_id);
			}
		}
		// grade's mission ends
		unset($db_fields['grade']);

		// TODO Exception
		// TODO if old auction => update
		$this->_write_log("[Adding to db...");
		$this->CI->auction->add($db_fields);
		$this->_write_log("OK]");
	}

	// for layout 3, separate to a function due to encoding error on amazon server (or php 5.3 array ?)
	// Fields: {year, distance, point, shift}
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
						if(
						  preg_match('@\<td.*align="left" class="tableT".*\>[HS]([0-9]+).*\<\/td\>@', $html, $matches)
						  || preg_match('@\<td.*class="tableT" align="left".*\>[HS]([0-9]+).*\<\/td\>@', $html, $matches)
						  || preg_match("/<td.*>([0-9]{1,2})年/", $html, $matches)
						  || preg_match("/<td.*>([0-9]{1,2})å¹´/", $html, $matches)
						  ){
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
							  if(preg_match("@km.*\s*<\/td>\s*<td.*>\s*([HLMATF0-9]+)\s*<\/td>@", $html, $matches)){
								  $value = $matches[1];
							  }
							  break;
						  case 'point':
							  if(preg_match("@km.*\s*</td>(\s*<td.*>.*</td>\s*)+<td.*>\s*([RBW0-6.]+)\s*<\/td>@", $html, $matches)){
								  $value = $matches[2];
							  }
							  break;
						  case 'equipment':
							  if(preg_match("/<td.*>装備<\/td>\s*<td.*>\s*[<tbody><tr>]*\s*<td.*>(.*)<\/td>/", $html, $matches)){
								  $value = strip_tags($matches[1]);
							  }
							  break;
					 case 'comment':
						if(preg_match('@<td.*class="tableT".*>ｱｲｵｰｸｺﾒﾝﾄ</td>\s*<td.*class="tableTred".*>(.*)</td>@', $html, $matches)){
						  $value = stripslashes(strip_tags($matches[1]));
						}
						break;
					}
				}
			}
		}
		else{ // xpath failed
			switch($field){
				case 'year':
				  if(
				    preg_match('@\<td.*align="left" class="tableT".*\>[HS]([0-9]+).*\<\/td\>@', $html, $matches)
				    || preg_match('@\<td.*class="tableT" align="left".*\>[HS]([0-9]+).*\<\/td\>@', $html, $matches)
				    || preg_match("/<td.*>([0-9]{1,2})年/", $html, $matches)
				    || preg_match("/<td.*>([0-9]{1,2})å¹´/", $html, $matches)
				    ){
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
					if(preg_match("@km.*\s*<\/td>\s*<td.*>\s*([HLMATF0-9]+)\s*<\/td>@", $html, $matches)){
						$value = $matches[1];
					}
					break;
				case 'point':
					if(preg_match("@km.*\s*</td>(\s*<td.*>.*</td>\s*)+<td.*>\s*([RBW0-6.]+)\s*<\/td>@", $html, $matches)){
						$value = $matches[2];
					}
					break;
        		case 'equipment':
          		if(preg_match("/<td.*>装備<\/td>\s*<td.*>\s*[<tbody><tr>]*\s*<td.*>(.*)<\/td>/", $html, $matches)){
	            		$value = strip_tags($matches[1]);
          		}
			break;
			case 'venue':
			  if(preg_match('@<td.*class="tableT".*>開催会場</td>\s*<td.*class="tableT".*>(.*)</td>@', $html, $matches)){
			    $value = stripslashes(strip_tags($matches[1]));
			  }
			  break;
			}
		}

		return $value;
	}
	/// end _layout3_get_value

	/**
	 * Get timestamp
	 */
	function _get_timestamp($regex_name, $url, $ref, $method = NULL, $post_data = "")
	{
		$page = preg_replace("@{$this->auction_url}(.*)\.jsp(.*)@", "$1", $url);
		$curl = $this->_download_page($url, array(
			'ref' => $ref,
			'post_data' => $post_data,
			'page' => $page,
			'method' => $method,
		));
		$html = $curl[0];
		// if ($regex_name == "preintgvedtl01") {
		// 	echo $html;
		// }
		$matched = preg_match("/{$regex_name}\.jsp\?timestamp=([0-9]+)/", $html, $matches);
		if(!$matched){
			$this->_write_log("Couldn't get [{$regex_name}] timestamp");
			print("Couldn't get {$regex_name} timestamp"); //TODO die?
			return FALSE;
		}
		$timestamp = $matches[1];
		return $timestamp;
	}

	 /**
	 *
	 * Download using curl
	 * @param String $url
	 * @param Array $opt{page_name, method, String post_data, bool return_header}
	 */

	function _download_page($url, $opt = array())
	{
		$ff_cookie = "Cookie:uid=srvrui_hQMFUyu; ucd=srvrui_hQMFUyu; save=off; sessIdInternal=4E289058FB49197D0E007BA66CFB5DAB; gspagesize=100; uid_en=sztVlou2Lp6WUyM.Ms; ucd_en=oLPLlxJvVlkpMC; save_en=on; sessIdInternal_en=803A8D87ED556C37114E5AD989CA4712; pagesize=100; ATTR_LOGIN_SITE=; JSESSIONID=4E289058FB49197D0E007BA66CFB5DAB; __utma=120947088.1185210350.1320058303.1321582797.1321587169.27; __utmz=120947088.1320058303.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); loginid=W70695600; loginid_en=W70695600; asn9udajkasn=iaucap03; __utmc=120947088; __utmb=120947088.2.10.1321587169";

		$user_agent_chr = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/15.0.874.120 Safari/535.2";
		$user_agent_ff = "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.24) Gecko/20111103 Firefox/3.6.24";

		$ch = curl_init($url);
		if(isset($opt['method']) && $opt['method'] == "POST"){
			curl_setopt ($ch, CURLOPT_POST, 1);
			curl_setopt ($ch, CURLOPT_POSTFIELDS, $opt['post_data']);
		}

		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt ($ch, CURLOPT_COOKIEJAR, COOKIE_PATH);
		curl_setopt ($ch, CURLOPT_COOKIEFILE, COOKIE_PATH);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, $user_agent_ff);
		curl_setopt($ch, CURLOPT_REFERER, $opt['ref']);
		if(isset($opt['return_header']) && $opt['return_header'] == TRUE){
			curl_setopt($ch, CURLOPT_HEADER, 1);
		}

		$header = array("Host: www.iauc.co.jp","Accept-Language: ja-JP", "UA-CPU: x86", "Accept: */*", "Connection: Keep-Alive");
		$accept_encoding = "Accept-Encoding: gzip, deflate";
		if(isset($opt['gzip']) && $opt['gzip'] == TRUE){
			$header[] = $accept_encoding;
		}
		//$header[] = "Cookie: 	uid=srvrui_hQMFUyu; ucd=srvrui_hQMFUyu; save=off; sessIdInternal=47AF439072A2A6E88F395F0FFD924E26; gspagesize=100; uid_en=sztVlou2Lp6WUyM.Ms; ucd_en=oLPLlxJvVlkpMC; save_en=on; sessIdInternal_en=803A8D87ED556C37114E5AD989CA4712; pagesize=100; ATTR_LOGIN_SITE=; JSESSIONID=47AF439072A2A6E88F395F0FFD924E26; __utma=120947088.1185210350.1320058303.1321599040.1321604313.30; __utmz=120947088.1320058303.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); loginid=W70695600; loginid_en=W70695600; asn9udajkasn=iaucap03; __utmc=120947088; __utmb=120947088.1.10.1321604313"
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$html = curl_exec ($ch);
		if(isset($opt["page"])){
			$file = FCPATH."data/".$opt["page"].".html";
	//		if(!empty($accept_encoding)){
	//			$file .= ".zip";
	//		}
			fwrite(fopen($file, "w"), $html);
		}
		return array($html, $ch);
	}

	function _login()
	{
		global $init_timestamp, $login_attempt, $prelogin01_url_timestamp, $preframe01_url_timestamp;
		$return = FALSE;

		$this->_remove_old_html();

		$this->_write_log("\nLogging in...");

		if($login_attempt === 1){
			@unlink(COOKIE_PATH);
		}

		// TODO check login: if already logged in, return;
		$p1 = "https://www.iauc.co.jp/pv/top1.html";
		$pre_login_url = "https://www.iauc.co.jp/auction/prelogin01.jsp";
		$login_page = $this->_download_page($pre_login_url, array(
			'return_header' => TRUE,
			'ref'=>$p1,
			'page' => 'login',
			//"accept_encoding" => ""
		));
		$html = $login_page[0];
		$ch = $login_page[1];
		$header  = curl_getinfo( $ch );
		$real_login_url = $header['url'];
		$prelogin01_url_timestamp = $real_login_url;

		$login_url = "https://www.iauc.co.jp/auction/servlet/authenticate";


		$post_data ="mode=login&member_cd=W706956&pwd=856423&step=1&fnc=login&prelogin_chk=on&normal_login=%92%CA%8F%ED%83%82%81%5B%83h&DuringNegotiations=";

		$login_curl = $this->_download_page($login_url, array(
			"page" => "preframe01_after_login",
			"post_data" => $post_data,
			"ref" => $real_login_url,
			"method" => "POST",
			//"gzip" => TRUE,
			//'return_header' => TRUE,
			//"accept_encoding" => "",
		));
		$ch2 = $login_curl[1];
		if($ch2){
			$header  = curl_getinfo( $ch2 );
			$preframe01_url_timestamp = $header['url'];
			if($preframe01_url_timestamp){
				$this->_write_log("OK");
				$return = TRUE;
			}
			else{
				$this->_write_log("FAILED");
				$return = FALSE;
			}
		}
		else{
			$this->_write_log("FAILED");
			$return = FALSE;
		}
		return $return;

	}
	/*
	 * TODO
	 * Check if logged in
	 */
	function _is_logged_in()
	{

	}
	/*
	 * Remove downloaded html for new login
	 */
	function _remove_old_html()
	{
		$dir = scandir(FCPATH."data");
		foreach($dir as $file){
			if(preg_match("@\.html@", $file)){
				unlink(FCPATH."data/".$file);
			}
		}
	}

	function _get_preindex01_timestamp()
	{
		// get preindex01 timestamp
		$preindex01_html = file_get_contents(FCPATH."data/preframe01_after_login.html");
		$preindex01_timestamp_matched = preg_match("/preindex01\.jsp\?timestamp=([0-9]+)/", $preindex01_html, $matches);
		if($preindex01_timestamp_matched){
			$preindex01_timestamp = $matches[1];
			return $preindex01_timestamp;
		}
		return FALSE;
	}
	// encoding uri for posting, mostly for car type. e.g ｴﾙﾌ => %B4%D9%CC
	function _encode_uri($utf8_name)
	{
		return str_replace("%", "%25", rawurlencode(mb_convert_encoding($utf8_name, "SHIFT-JIS", "UTF-8")));
	}

	// ****** MAKER > TYPE > CODE > GRADE
	// get code, grade
	function gen_code_grade($type_name_jp, $maker_iauc_id)
	{
		//$type_name_jp = rawurldecode($type_name_jp);
		$type = $this->CI->auction->get_type_by_name_jp($type_name_jp);
		if($type == NULL) die("Type not found!");

		$file = FCPATH."data/prertinf03_{$maker_iauc_id}.html";
		$html = mb_convert_encoding(file_get_contents($file), "UTF-8", "SHIFT-JIS");
		$code_matched = preg_match("/arrKata = (.*);/", $html, $matches);
		if($code_matched){
			$code_list = json_decode($matches[1]); // CODE LIST
			foreach($code_list as $name => $id){
				$this->CI->db->query("INSERT INTO codes(type_id, name, iauc_id) VALUES('{$type->id}', '{$name}', '{$id}')");
				$code_id = $this->CI->db->insert_id();
				$grade_matched = preg_match("/arrType{$id} = (.*);/", $html, $matches);
				if($grade_matched){
					$grade_list = json_decode($matches[1]);
					foreach($grade_list as $name => $encoded){
						$this->CI->db->query("INSERT INTO grades(code_id, name, encoded) VALUES('{$code_id}', '{$name}', '{$encoded}')");
					}
				}
			}
		}

	}
	// generate type list for each maker. RUN ONCE
	function gen_type_list()
	{
		$file = FCPATH."data/preexcar01.html";
		$html = mb_convert_encoding(file_get_contents($file), "UTF-8", "SHIFT-JIS");

		$maker_list = $this->CI->db->get("makers")->result();
		foreach($maker_list as $maker){
			$matched = preg_match("/arrType{$maker->iauc_id} = (.*);/", $html, $matches);
			if($matched){
				$type_list = json_decode($matches[1]);
				foreach($type_list as $name => $encoded){
					$this->CI->db->query("insert into car_types(maker_iauc_id, name_jp, encoded) values('{$maker->iauc_id}', '$name', '$encoded');");
				}
			}
		}
	}
}
