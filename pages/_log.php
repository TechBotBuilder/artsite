<?php

# track everyone! because poor artists can't add CustomLog directives
# since poor-level hosting plans don't allow editing main apache config.

$data = "{$_SERVER['REQUEST_TIME']} {$_SERVER['REMOTE_ADDR']} {$_SERVER['SCRIPT_NAME']} {$_SERVER['QUERY_STRING']} \"".$_SERVER['HTTP_REFERER']??''."\" \"{$_SERVER['HTTP_USER_AGENT']}\" \"{$_SERVER['HTTP_ACCEPT_LANGUAGE']}\" " . http_response_code() . " " . number_format(microtime(true)-$_SERVER['REQUEST_TIME_FLOAT'], 2);

file_put_contents('admin/logs/log.txt', $data.PHP_EOL, FILE_APPEND | LOCK_EX);