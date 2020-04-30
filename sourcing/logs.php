<?php

namespace log;

function whichLog(int $time = time()){
	return date('Y-F', $time).'.log'; //year-monthname.log
}
