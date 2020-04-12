<?php
// traffic data accessor

header('Content-Type: application/json');

$what = $_GET['what']??'all';
$when = $_GET['when']??'all';
echo json_encode(getTraffic($what, $when));



/*
* @param $what: fields to analyze. defaults to all.
* @param $when: mmyyyy-mmyyyy or 'all'
*/
function getTraffic($what, $when){
	if(empty($what) || empty($when)) return {};
	
	// determine what months request covers, so we know what files to open
	if($when == 'all'){
		//todo lookup oldest & current month
	}else{
		list($start, $end) = split($when, '-');
		$start = [substr($start, 0, 2), substr($start, 2)];
		$months = [substr($start, 0, 2), substr($start, 2)];
		$month = $start;
	}
	
	$results = array();
	while($){
		$month = ...;
		$handle = fopen($month . '.log', 'r');
		if($handle){
			while(($line = fgets($handle)) !== false){
				//TODO append line to results if is relevant.
			}
			fclose($handle);
		}else{
			//TODO should we let the user know error? add entry to 'traffic_analysis_errors' field in results.
		}
	}
	
	return $results;
}


//source 256kilobytes.com/content/show/1922/how-to-parse-a-user-agent-in-php-with-minimal-effort
function toBrowser($user_agent){
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

//suggestion of developer.mozilla.org/en-US/docs/Web/HTTP/Browser_detection_using_the_user_agent  Section OS: Mobile, Tablet or Desktop
function isMobile($user_agent){
	$t = ' ' . strtolower($user_agent);
	return boolval( strpos($t, 'mobi') );
}
