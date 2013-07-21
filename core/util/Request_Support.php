<?php
/**
 * 本地请求
 * @param int $cod
 * @param object $prm
 * @return object
 */
function localRequest($cod, $prm){
	
	$action->cod = $cod;
	$action->prm = isset($prm) ? $prm : '{}';
	
	return handlerRequest(json_encode($action));
	
}
/**
 * 处理请求
 * @param $json json参数
 * @return object
 */
function handlerRequest($json){

	$jsonObject = json_decode(urldecode($json));
	log_debug("handler Requeset ".$json);
	/*
	 * 如果jsonobject对象为null，则说明$json不是一个JSON字符串
	*/
	if($jsonObject == NULL){
		log_error("This is not json String !");
		return 'This is not json String !';
	}
	/*
	 * 验证json的格式是否正确
	*/
	if(!validationRequest($jsonObject)){
		log_error("Action format error !");
		return 'Action format error !';
	}
	$actions = $GLOBALS['actions'];
	/*
	 * 获取cod，并判断其在$action中是否存在
	*/
	$cod = $jsonObject->cod;
	if(!array_key_exists($cod, $actions)){
		log_error('action '.$cod.' not found !');
		return 'action '.$cod.' not found !';
	}
	log_debug("action info ".json_encode($actions[$cod]));

	$a = $actions[$cod];
	
	return $a->instance->doAction($jsonObject);

}
/**
 * 验证请求格式
 * @param JsonObject $json
 * @return boolean
 */
function validationRequest($json){
	if(isset($json->cod) && isset($json->prm)){
		return true;
	}
	return false;
}