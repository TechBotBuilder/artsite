<?php

namespace log;

function whichLog(int $time = null){
	if(is_null($time)) $time = time();
	return date('Y-F', $time).'.log'; //year-monthname.log
}
