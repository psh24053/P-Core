<?php
/*
 * 将默认时区设置为中国上海
 */
date_default_timezone_set('Asia/Shanghai');
$_SERVER['log_level'] = 'error';


/**
 * 本地请求action,返回完整的action Json对象
 * @param int $cod
 * @param object $prm
 */
function localRequestAction($cod, $prm){
	
	$json->cod = $cod;
	$json->prm = isset($prm) ? $prm : '{}';
	
	return handlerRequest(json_encode($json), true);
	
}

/**
 * 处理请求
 * @param $json json参数
 * @param $local 是否是内部调用
 */
function handlerRequest($json, $local = false){

	$jsonObject = json_decode(urldecode($json));
	log_debug("handler Requeset ".$json);
	/*
	 * 如果jsonobject对象为null，则说明$json不是一个JSON字符串
	*/
	if($jsonObject == NULL){
		log_error("This is not json String !");
		if($local){
			return 'This is not json String !';
		}else{
			echo 'This is not json String !';
			exit();
		}
	}
	/*
	 * 验证json的格式是否正确
	*/
	if(!validationRequest($jsonObject)){
		log_error("Action format error !");
		if($local){
			return 'Action format error !';
		}else{
			echo 'Action format error !';
			exit();
		}
	}
	/*
	 * -----------------------------------------------------------------------------------
	* 定义actionCode
	* -----------------------------------------------------------------------------------
	*/
	$action = initActionList();

	/*
	 * 获取cod，并判断其在$action中是否存在
	*/
	$cod = $jsonObject->cod;
	if(!array_key_exists($cod, $action)){
		log_error('action '.$cod.' not found !');
		if($local){
			return 'action '.$cod.' not found !';
		}else{
			echo 'action '.$cod.' not found !';
			exit();
		}
	}
	log_debug("action info ".json_encode($action[$cod]));
	/*
	 * 得到actionPath，并引入该action
	*/
	$actionPath = $action[$cod]->path;
	/*
	 * 这个action完整的信息
	*/
	$actionInfo = $jsonObject;
	$prm = $jsonObject->prm;
	include $actionPath;

}
/**
 * 初始化action
 * @return actions
 */
function initActionList(){
	// action缓存，调试模式时最好关闭
	if(isset($_SERVER['actions'])){
		return $_SERVER['actions'];
	}

	$actions = array();

	$list = scandir('action');
	for ($i = 0 ; $i < count($list) ; $i ++){
		// 表示这个文件是一个.php文件
		if(substr_count($list[$i], '.php')){
			$filename = dirname(__FILE__).'/action/' . $list[$i];
				
			$handle = fopen($filename, "r");//读取二进制文件时，需要将第二个参数设置成'rb'
				
			//通过filesize获得文件大小，将整个文件一下子读到一个字符串中
			$contents = fread($handle, filesize ($filename));
			fclose($handle);
				
			/*
			 * @Name:GetWorkList,
			* @Code:100,
			* @Desc:获取Work列表
			*/
			$info = trim(substr(trim($contents), strpos($contents, '/*')+2, strpos($contents, '*/') - 8));
			$info = trim(str_replace('*', '', $info));
			$strarray = explode(',', $info);
				
			$act = null;
				
			for($j = 0 ; $j < count($strarray) ; $j ++){
				$str = trim($strarray[$j]);

				$arr = explode(":", $str);

				if($arr[0] == '@Name'){
					$act->name = $arr[1];
				}else if($arr[0] == '@Code'){
					$act->cod = $arr[1];
				}

			}
			$act->path = 'action/' . $list[$i];
			$actions[$act->cod] = $act;
		}

	}

	$_SERVER['actions'] = $actions;
	return $actions;

}
/**
 * 验证请求
 * @param JsonObject $json
 * @return boolean
 */
function validationRequest($json){
	if(isset($json->cod) && isset($json->prm)){
		return true;
	}
	return false;
}
/**
 * 返回成功
 * @param jsonobject $actionInfo
 * @param jsonobject $pld
 * @param boolean $local 如果local为true，这代表是内部调用，如果action运行内部调用，这需要显式的传递该参数为true
 */
function toResponseSuccess($actionInfo, $pld = null, $local = false){

	$response->cod = $actionInfo->cod;
	$response->res = true;
	$response->pld = isset($pld) ? $pld : '{}';

	$responsestr = json_encode($response);

	log_debug("response success ".$responsestr);
	if($local){
		return $responsestr;
	}else{
		echo $responsestr;
		exit();
	}
	
}
/**
 * 返回错误
 * @param jsonobject $actionInfo
 * @param int $errcode
 * @param String $err
 * @param boolean $local 如果local为true，这代表是内部调用，如果action运行内部调用，这需要显式的传递该参数为true
 */
function toResponseError($actionInfo, $errcode = 5000, $errmsg = 'Action Execute Exception !', $local = false){
	$response->cod = $actionInfo->cod;
	$response->res = false;
	$response->pld->errcode = $errcode;
	$response->pld->errmsg = $errmsg;

	$responsestr = json_encode($response);

	log_debug("response success ".$responsestr);
	if($local){
		return $responsestr;
	}else{
		echo $responsestr;
		exit();
	}
}

