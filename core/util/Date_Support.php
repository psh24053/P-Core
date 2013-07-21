<?php
/**
 * 判断时间差，返回人性化字符串
 * @param datelong
 * @returns
 */
function parseDate($datelong){
	$time = time() - $datelong;

	if($time < 60 && $time >= 0){
		return "刚刚";
	}else if($time >= 60 && $time < 3600){
		return intval($time / 60) ."分钟前";
	}else if($time >= 3600 && $time < 3600 * 24){
		return intval($time / 3600) . "小时前";
	}else if($time >= 3600 * 24 && $time < 3600 * 24 * 30 ){
		return intval($time / 3600 / 24) . "天前";
	}else if($time >= 3600 * 24 * 30 && $time < 3600 * 24 * 30 * 12){
		return intval($time / 3600 / 24 / 30) . "个月前";
	}else if($time >= 3600 * 24 * 30 * 12){
		return intval($time / 3600 / 24 / 30 / 12) . "年前";
	}else{
		return "刚刚";
	}
}