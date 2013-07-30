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
 * 返回错误信息
 * @param int $errorCode
 * @param string $customMsg
 */
function responseErrorByString($errorCode, $customMsg = ""){
	$response = 'ErrorCode -> ' . $errorCode . ' ,ErrorMsg -> ' . ErrorCode::$ERROR_CODE[$errorCode] . ' ,CustomMsg -> ' . $customMsg;
	
	return $response;
}
/**
 * 返回错误信息，格式为json
 * @param int $errorCode
 * @param string $customMsg
 */
function responseErrorByJSON($errorCode, $actionCode, $customMsg = ""){
	$response->cod = $actionCode;
	$response->res = false;
	$response->pld->errorCode = $errorCode;
	$response->pld->errorMsg = ErrorCode::$ERROR_CODE[$errorCode];
	$response->pld->customMsg = $customMsg;
	
	return json_encode($response);
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
		$responseError = responseErrorByString(ErrorCode::ERROR_CODE_NOT_JSON_STRING);
		log_error($responseError);
		return $responseError;
	}
	/*
	 * 验证json的格式是否正确
	*/
	if(!validationRequest($jsonObject)){
		$responseError = responseErrorByString(ErrorCode::ERROR_CODE_ACTION_FORMAT_ERROR);
		log_error($responseError);
		return $responseError;
	}
	$actions = $GLOBALS['actions'];
	/*
	 * 获取cod，并判断其在$action中是否存在
	*/
	$cod = $jsonObject->cod;
	if(!array_key_exists($cod, $actions)){
		$responseError = responseErrorByJSON(ErrorCode::ERROR_CODE_ACTION_NOT_FOUND, $cod);
		log_error($responseError);
		return $responseError;
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