<?php
// traffic data accessor

header('Content-Type: application/json');

$start = strtotime(trim($_GET['start']??'last month'));
$end = strtotime(trim($_GET['end']??'now'));
if($start === false || $end === false) {
	http_response_code(400);
	echo json_encode(['error'=>'bad start/end query']);
	exit();
}
$bucket_size = trim($_GET['bucket']??'day');
echo json_encode(getTraffic($start, $end, $bucket_size));


function auto_increment(&$var){
	if(isset($var)) $var += 1;
	else $var = 1;
}

class Traffic {
	
	//buckets into which to break down all the rest of the statistics
	//will parse timestamps into strings into which to index items
	private $bucket_size;
	
	//the rest are broken into what, then bucket
	
	//these two count views to legitimate content/general pages, not including robot visitors
	private $content;
	private $general;
	
	private $browsers; //views per browser
	private $bots; //views per bot
	private $languages; //views per language
	
	private $referrers; //external sites that link to us, what they link to, and how many visits come from them.
	private $bad_actors; //IPs requesting URLS that are common targets of villains
	
	//track maximum load times per page in case some are taking too long.
	private $max_load_times;
	
	function __construct($bucket){
		
		//calculate bucket breakup. If not second/minute/.../year, assume user specified their own format string to group data by time.
		$bkt = '';
		switch (strtolower($bucket)){
			case 'second':
				$bkt = 's '.$bkt;
			case 'minute':
				$bkt = 'i '.$bkt;
			case 'hour':
				$bkt = 'H '.$bkt;
			case 'day':
				$bkt = 'd '.$bkt;
			case 'week':
				$bkt = 'W '.$bkt;
			case 'month':
				$bkt = 'm '.$bkt;
			case 'year':
				$bkt = 'Y '.$bkt;
				break;
			default:
				$bkt = $bucket;
				break;
		}
		$this->bucket_size = $bkt;
		
		//initialize data slots
		$this->content = array();
		$this->general = array();
		$this->browsers = array();
		$this->bots = array();
		$this->languages = array();
		$this->referrers = array();
		$this->bad_actors = array();
		$this->max_load_times = array();
	}
	
	//parse raw data into usable info and add it to records
	function addRaw($row){
		list($timestamp, $ip, $page, $query,
			$referrer, $user_agent, $user_lang,
			$status, $load_time)
			= str_getcsv($row, ' ');
		$bucket = $this->getBucket($timestamp);
		
		// log load times for all pages requested for site profiling.
		if(isset($this->max_load_times[$page][$bucket])) {
			if($this->max_load_times[$page][$bucket] < $load_time)
				$this->max_load_times[$page][$bucket] = $load_time;
		}
		else $this->max_load_times[$page][$bucket] = $load_time;
		
		// bad actors
		if( strpos($referrer, '/wp-') || strpos($page, '/wp-')
			|| strpos($referrer, '.bak') || strpos($page, '.bak')
			|| strpos($referrer, '/config') || strpos($page, '/config')) 
		{
			auto_increment($this->bad_actors[$ip][$bucket]);
			return;
		}
		
		// bots
		$browser = self::uaToBrowser($user_agent);
		if(self::isBrowserBot($browser)){
			auto_increment($this->bots[$browser][$bucket]);
			return;
		}
		
		// actual visitors
		//figure out if the page is a content page or a general page.
		require_once 'constants.php';
		$pagetype = '';
		foreach(array('content'=>constants\CONTENT_PAGES, 'general'=>constants\GENERAL_PAGES) as $_ptype => $_pages){
			foreach($_pages as $_page){
				if(in_array($page, $_page)) {
					$page = $_page[0];
					$pagetype = $_ptype;
					break;
				}
			}
			if($pagetype != '') break;
		}
		//If neither content nor general page, do not track it further.
		if($pagetype == '')
			return;
		
		//log the page view
		if($pagetype === 'content'){
			auto_increment($this->content[$page.'?'.$query][$bucket]);
		}elseif($pagetype === 'general'){
			auto_increment($this->general[$page][$bucket]);
		}
		
		//browser
		auto_increment($this->browsers[$browser][$bucket]);
		//language
		$language = self::ulToLanguage($user_lang);
		auto_increment($this->languages[$user_lang][$bucket]);
		//referrer if out-of-site
		if(strpos($referrer, constants\SITE_ROOT) !== 0)
			auto_increment($this->referrers[$referrer][$bucket]);
		
		
		//TODO WIP
	}
	
	function addProcessed($row){
		//TODO
		//allow compressed file information to be added.
	}
	
	function get(){
		return array(
			'bucket_size'=>$this->bucket_size,
			'content'=>$this->content,
			'general'=>$this->general,
			'browsers'=>$this->browsers,
			'bots'=>$this->bots,
			'languages'=>$this->languages,
			'referrers'=>$this->referrers,
			'bad_actors'=>$this->bad_actors
		);
	}
	
	private function getBucket($timestamp) : string {
		return date($this->bucket_size, $timestamp);
	}
	
	
	//source 256kilobytes.com/content/show/1922/how-to-parse-a-user-agent-in-php-with-minimal-effort
	private static function uaToBrowser($user_agent){
		// Make case insensitive.
		$t = strtolower($user_agent);

		// If the string *starts* with the string, strpos returns 0 (i.e., FALSE). Do a ghetto hack and start with a space.
		// "[strpos()] may return Boolean FALSE, but may also return a non-Boolean value which evaluates to FALSE."
		//        http://php.net/manual/en/function.strpos.php
		$t = " " . $t;

		// Humans / Regular Users      
		if     (strpos($t, 'opera'     ) || strpos($t, 'opr/')		) return 'Opera'            ;
		elseif (strpos($t, 'edge'      )							) return 'Edge'             ;
		elseif (strpos($t, 'chrome'    )							) return 'Chrome'           ;
		elseif (strpos($t, 'safari'    )							) return 'Safari'           ;
		elseif (strpos($t, 'firefox'   )							) return 'Firefox'          ;
		elseif (strpos($t, 'msie'      ) || strpos($t, 'trident/7')	) return 'Internet Explorer';

		// Search Engines  
		elseif (strpos($t, 'google'    )							) return '[Bot] Googlebot'   ;
		elseif (strpos($t, 'bing'      )							) return '[Bot] Bingbot'     ;
		elseif (strpos($t, 'slurp'     )							) return '[Bot] Yahoo! Slurp';
		elseif (strpos($t, 'duckduckgo')							) return '[Bot] DuckDuckBot' ;
		elseif (strpos($t, 'baidu'     )							) return '[Bot] Baidu'       ;
		elseif (strpos($t, 'yandex'    )							) return '[Bot] Yandex'      ;
		elseif (strpos($t, 'sogou'     )							) return '[Bot] Sogou'       ;
		elseif (strpos($t, 'exabot'    )							) return '[Bot] Exabot'      ;
		elseif (strpos($t, 'msn'       )							) return '[Bot] MSN'         ;

		// Common Tools and Bots
		elseif (strpos($t, 'mj12bot'   )							) return '[Bot] Majestic'     ;
		elseif (strpos($t, 'ahrefs'    )							) return '[Bot] Ahrefs'       ;
		elseif (strpos($t, 'semrush'   )							) return '[Bot] SEMRush'      ;
		elseif (strpos($t, 'rogerbot'  ) || strpos($t, 'dotbot')	) return '[Bot] Moz or OpenSiteExplorer';
		elseif (strpos($t, 'frog'      ) || strpos($t, 'screaming')	) return '[Bot] Screaming Frog';
		elseif (strpos($t, 'blex'      )							) return '[Bot] BLEXBot'       ;

		// Miscellaneous 
		elseif (strpos($t, 'facebook'  )							) return '[Bot] Facebook'     ;
		elseif (strpos($t, 'pinterest' )							) return '[Bot] Pinterest'    ;

		// Check for strings commonly used in bot user agents   
		elseif (strpos($t, 'crawler' ) || strpos($t, 'api'    ) ||
			strpos($t, 'spider'  ) || strpos($t, 'http'   ) ||
			strpos($t, 'bot'     ) || strpos($t, 'archive') || 
			strpos($t, 'info'    ) || strpos($t, 'data'   )    ) return '[Bot] Other'   ;

		return 'Other (Unknown)';
	}

	private static function isBrowserBot($browser){
		return strncmp($browser, '[Bot]', 5)===0;
	}

	//suggestion of developer.mozilla.org/en-US/docs/Web/HTTP/Browser_detection_using_the_user_agent  Section OS: Mobile, Tablet or Desktop
	private static function isUAMobile($user_agent){
		$t = ' ' . strtolower($user_agent);
		return strpos($t, 'mobi') !== false;
	}

	private static function ulToLanguage($ul){
		$langs = explode(',', $ul);
		$result = 'none'; $high_q = 0;
		foreach ($langs as $lang){
			$lang = explode(';q=', $lang);
			if(!isset($lang[1])) $lang[1] = 1;
			if($lang[1]>$high_q) {
				list($result, $high_q) = $lang;
			}
		}
		return $result;
	}
	
}



/*
* @params $start, $end: Unix timestamps
*/
function getTraffic(int $start, int $end, string $bucket_size){
	if($end < $start) return array();
	
	$results = new Traffic($bucket_size);
	$errors = array();
	
	require_once 'sourcing/logs.php';
	$now = $start;
	while($now < strtotime('+1 month',$end)){
		
		$log_name = 'logs/'.log\whichLog($now);
		
		if(file_exists($log_name) && ($handle = fopen($log_name, 'r'))){
			while(($line = fgets($handle)) !== false){
				$results->addRaw($line);
				//TODO deal with condensed log files.
			}
			fclose($handle);
		}else{
			$errors[] = "$log_name not found/readable";
		}
		
		$now = strtotime('+1 month', $now);
	}
	
	return $results->get();
}





