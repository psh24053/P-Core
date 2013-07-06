<?php
/*
 * 将默认时区设置为中国上海
 */
date_default_timezone_set('Asia/Shanghai');
$_SERVER['log_level'] = 'error';


/**
 * 调用JS方法体，让传入的字符串运行在script标签中
 * @param String $msg
 */
function JS_func($msg = ''){
	
	echo '<script type="text/javascript">'.$msg.'</script>';
}
/**
 * 调用JS的alert方法
 * @param String $msg
 */
function JS_alert($msg = ''){
	
	echo JS_func('alert("'.$msg.'");');
	
}
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
	if($_SERVER['log_level'] == 'debug'){
		log_write($msg, 1, 'DEBUG');
	}
}
/**
 * 写出log的方法
 * @param string $msg
 * @param string $level
 */
function log_write($msg, $index = 0, $level = 'DEBUG', $path = 'mytask.log'){
	
	if($msg instanceof String){
		
	}else{
		$msg = json_encode($msg);
	}
	
	$array = debug_backtrace();
	
	$row = $array[$index];
	$line = $row['line'];
	$filename = $row['file'];
	$filename = substr($filename, strrpos($filename, "MyTask") + 7);
	
	$showtime = date("Y-m-d H:i:s");
	$content = "\n\r[" . $showtime . "]";
	$content .= "[".$filename.",".$line."]";
	$content .= "[".$level."]";
	$content .= " ".$msg."\n\r" ;
	
	//print_r($array);//信息很齐全
	
	file_put_contents($path, $content, FILE_APPEND);
	
}
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
/**
 *
 * mysql连接核心类
 * @author Administrator
 *
 */

class ixg_mysql{
	private $host;
	private $user;
	private $pass;
	private $dbname;
	private $charset;
	private $newlink;
	private $conn;
	private $result;

	/**
	 *
	 * ixg_mysql构造方法
	 */
	function __construct(){
		$this->host = 'localhost';
		$this->user = 'panshihao_cn';
		$this->pass = 'caicai520';
		$this->dbname = 'panshihao_cn';
		$this->charset = 'utf-8';
		$this->newlink = 'mytask_mysql_link';
	}

	/**
	 *
	 * 连接到数据库的方法
	 */
	function Connect($dbname = NULL, $newlink = null){
		if(isset($newlink)){
			$this->newlink = $newlink;
		}
		$this->conn = mysql_connect($this->host,$this->user,$this->pass,$this->newlink) or die(mysql_error());
		if($dbname){
			mysql_select_db($dbname,$this->conn) or die("未找到数据库".$dbname);
		}else{
			mysql_select_db($this->dbname,$this->conn) or die("未找到数据库".$this->dbname);
		}
		mysql_query("set names '".str_replace("-", "", $this->charset)."'",$this->conn);
	}

	/**
	 * 关闭数据库连接的方法
	 */
	function Close(){
		mysql_close($this->conn);
	}

	/**
	 *
	 * 统一查询接口，为了数据库连接统一
	 */
	function query($query){
		$this->result = mysql_query($query,$this->conn);
		return $this->result;
	}

	/**
	 * 获取最近一次更新语句的影响行数
	 */
	function getUpdateNum(){
		return mysql_affected_rows($this->conn);
	}
	/**
	 * 获取最近一次查询语句的记录数.
	 */
	function getSelectNum(){
		return mysql_num_rows($this->result);
	}

	/**
	 * 封装mysql_fetch_array方法，调用一次封装一次mysql_fetch_array方法
	 */
	function getRow(){
		return mysql_fetch_array($this->result,MYSQL_ASSOC);
	}

	/**
	 * 返回上次语句是否成功
	 */
	function isGo(){
		if($this->result){
			return true;
		}else{
			return false;
		}
	}

	/**
	 * 获取上次执行的错误信息
	 */
	function getError(){
		return mysql_error($this->conn);
	}

	/**
	 * 获取上一次的结果集对象
	 */
	function getResult(){
		return $this->result;
	}
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

