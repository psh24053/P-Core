<?php

/**
 * 生成AUT，返回32位md5值，并且会将$obj保存到服务器
 * @param object $obj
 * @return string
 */
function GenerateAut($obj){
	$autMap = null;
	if(isset($GLOBALS['aut_map'])){
		$autMap = $GLOBALS['aut_map'];
	}
	
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
	$autMap = null;
	if(isset($GLOBALS['aut_map'])){
		$autMap = $GLOBALS['aut_map'];
	}
	
	$obj = $autMap[$aut];
	
	return isset($obj);
	
}
/**
 * 获取aut对应的对象
 * @param string $aut
 * @return object
 */
function getAutObject($aut){
	$autMap = null;
	if(isset($GLOBALS['aut_map'])){
		$autMap = $GLOBALS['aut_map'];
	}
	
	return $autMap[$aut];
	
}
/**
 * 清除某个aut信息
 * @param string $aut
 */
function removeAut($aut){
	$autMap = null;
	if(isset($GLOBALS['aut_map'])){
		$autMap = $GLOBALS['aut_map'];
	}
	unset($autMap[$aut]);
	$GLOBALS['aut_map'] = $autMap;
}
/**
 * 清除所有的aut信息
 */
function clearAutMap(){
	$autMap = null;
	if(isset($GLOBALS['aut_map'])){
		$autMap = $GLOBALS['aut_map'];
	}
	unset($autMap);
	$GLOBALS['aut_map'] = $autMap;
}