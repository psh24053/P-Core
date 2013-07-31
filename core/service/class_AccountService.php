<?php

/**
 * account Service
 * @author Panshihao
 *
 */
class AccountService extends Service {
	
	/**
	 * 检查用户名是否存在
	 * @param string $username
	 * @return boolean
	 */
	public function checkUsernameExist($username){
		$db = $GLOBALS['mysql'];
		$db->Connect();
		
		
		$sql = 'select * from pt_account where username = "' . mysql_real_escape_string($username) . '"';
		
		$db->query($sql);

		$result = false;
		
		if($db->isGo()){
			//执行成功
			if($this->item = $db->getRow()){
				$result = true;
			}
		}else{
			log_error($db->getError());
		}
		// 关闭数据库连接
		$db->Close();
		return $result;
	}
	/**
	 * 检查密码是否正确
	 * @param string $username
	 * @param string $password
	 */
	public function validationPassword($username, $password){
		$db = $GLOBALS['mysql'];
		$db->Connect();
		
		$sql = 'select * from pt_account where username = "' . mysql_real_escape_string($username) . '" and password = "' . mysql_real_escape_string($password) . '"';
		
		$db->query($sql);
		
		$result = false;
		
		if($db->isGo()){
			//执行成功
			if($this->item = $db->getRow()){
				$result = true;
			}
		}else{
			log_error($db->getError());
		}
		// 关闭数据库连接
		$db->Close();
		return $result;
		
	}
	
}

?>