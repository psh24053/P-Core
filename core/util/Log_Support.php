<?php
/**
 * 打印错误信息
 * @param string $msg
 */
function log_error($msg){
	log_write($msg, 1, 'ERROR');
}
/**
 * 打印调试信息
 * @param string $msg
 */
function log_debug($msg){
	if($GLOBALS['log_level'] == 'debug'){
		log_write($msg, 1, 'DEBUG');
	}
}
/**
 * 写出log的方法
 * @param string $msg
 * @param string $level
 */
function log_write($msg, $index = 0, $level = 'DEBUG', $path = '../core.log'){

	if($msg instanceof String){

	}else{
		$msg = json_encode($msg);
	}

	$array = debug_backtrace();

	$row = $array[$index];
	$line = $row['line'];
	$filename = $row['file'];
	$filename = substr($filename, strrpos($filename, "Core") + 7);

	$showtime = date("Y-m-d H:i:s");
	$content = "\n\r[" . $showtime . "]";
	$content .= "[".$filename.",".$line."]";
	$content .= "[".$level."]";
	$content .= " ".$msg."\n\r" ;

	file_put_contents($path, $content, FILE_APPEND);

}