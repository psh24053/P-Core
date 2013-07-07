<?php
/**
 * 接收数据参数
 */
include 'core.php';
/*
 * 判断请求方式
 */
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	/*
	 * 判断json参数在post中是否存在，如果不存在则exit()
	*/
	$json = file_get_contents("php://input");	

	handlerRequest($json);
}else{
	/*
	 * 判断json参数在get中是否存在，如果不存在则exit()
	*/
	if(!isset($_GET['json'])){
		exit();
	}else{
		$json = $_GET['json'];
	}
	handlerRequest($json);
}

