<?php
/**
 * Action的基类
 * @author Panshihao
 *        
 */
abstract class Action {
	// TODO - Insert your code here
	
	public $actionCode;
	public $actionName;
	
	/**
	 * 响应action的方法，需要返回一个结果，调用toSuccess或同toError方法进行返回
	 * @param object $action
	 * @return object $response
	 */
	public abstract function doAction($action);
		
	/**
	 * 用于doAction方法中返回成功结果
	 * @param object $action
	 * @param object $pld
	 * @return object $response
	 */
	public function toSuccess($action, $pld = null){

		$response->cod = $action->cod;
		$response->res = true;
		$response->pld = isset($pld) ? $pld : '{}';
		
		return $response;
	}
	/**
	 * 用于doAction方法中返回失败结果
	 * @param object $action
	 * @param int $errcode
	 * @param String $errmsg
	 * @return object $response
	 */
	public function toError($action, $errcode = 5000, $errmsg = 'Action Execute Exception !'){
		
		$response->cod = $action->cod;
		$response->res = false;
		$response->pld->errcode = $errcode;
		$response->pld->errmsg = $errmsg;
		
		return $response;
	}
}

?>