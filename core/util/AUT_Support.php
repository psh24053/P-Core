<?php

/**
 * 生成AUT，返回32位md5值，并且会将$obj保存到服务器
 * @param object $obj
 * @return string
 */
function GenerateAut($obj){
	$autMap = $GLOBALS['aut_map'];
	
	$aut = md5(time());
	
	$autMap[$aut] = $obj;
	
	$GLOBALS['aut_map'] = $autMap;
	
	return $aut;
	
}
/**
 * 判断aut是否存在，true为存在，false为不存在
 * @param string $aut
 * @return boolean
 */
function checkAutExist($aut){
	$autMap = $GLOBALS['aut_map'];
	
	$obj = $autMap[$aut];
	
	return isset($obj);
	
}

function getAutObject($aut){
	$autMap = $GLOBALS['aut_map'];
	
	
	
	
	
}