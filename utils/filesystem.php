<?php

namespace filesystem;

function safe_get_dir($dirname) {
	if(!is_dir($dirname)) mkdir($dirname, 0777, true);
	return $dirname;
}