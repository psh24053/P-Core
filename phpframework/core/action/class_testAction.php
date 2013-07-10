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
		
		
		
		return $this->toSuccess($action, null);
	}

	

	

	
	
}

?>
