<?php

class testAction extends Action {
	

	/**
	 * 构造方法
	 */
	public function __construct(){
		$this->actionCode = 999;
		$this->actionName = "test Action";
	}
	
	public function doAction($action) {
		
		$prm = $action->prm;
		
		
		if(!isset($prm)){
			self::toError($action, 5001, 'prm not found');
		}
		
		$pld->msg = "good";
		
		
		// TODO Auto-generated method stub
		return self::toSuccess($action, $pld);	
	}

	

	

	
	
}

?>
