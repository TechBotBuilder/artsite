<?php

namespace log;

function whichLog(int $time = now()){
	return date('Y-F', $time).'.log'; //year-monthname.log
}
