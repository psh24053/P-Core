<?php
class targetservice {
	
	
	/**
	 * 删除指定id的target
	 * @param int $id
	 */
	public function Delete($id){
		$db = new ixg_mysql();
		$db->Connect();
		
		$id = mysql_real_escape_string($id);
		
		$sql = "delete from my_target where work_id = ".$id;
		$result = 0;
		$db->query($sql);
		
		if($db->isGo()){
			$result = $db->getUpdateNum();
		}else{
			log_error($db->getError());
		}
		// 关闭数据库连接
		$db->Close();
		return $result > 0;
	}
	/**
	 * 获取某个指定的workid下的target数量
	 * @param int $workid
	 */
	public function Count($workid){
		$db = new ixg_mysql();
		$db->Connect();
		
		$workid = mysql_real_escape_string($workid);
		
		$result = 0;
		$sql = "select count(*) as count from my_target where work_id = ". $workid;
		$db->query($sql);
		
		if($db->isGo() && $db->getSelectNum() > 0){
			if($row = $db->getRow()){
				$result = $row['count'];
			}
		}else{
			log_error($db->getError());
		}
		
		// 关闭数据库连接
		$db->Close();
		return $result;
	}
	
	/**
	 * 插入一个target到数据库
	 * @param object $work
	 */
	public function Insert($target){
		$db = new ixg_mysql();
		$db->Connect();
		
		$content = mysql_real_escape_string($target->content);
		$workid = mysql_real_escape_string($target->workid);
		
		$sql = "INSERT INTO my_target(target_content,work_id,target_status,target_createtime) VALUES('".$content."',".$workid.",0,UNIX_TIMESTAMP())";
		$result = 0;
		$db->query($sql);
		
		if($db->isGo()){
			$result = $db->getUpdateNum();
		}else{
			log_error($db->getError());
		}
		
		$sql = "update my_work set work_lasttime = UNIX_TIMESTAMP() where work_id = ". $workid;
		$db->query($sql);
		
		if($db->isGo()){
			$result = $db->getUpdateNum();
		}else{
			log_error($db->getError());
		}
		
		// 关闭数据库连接
		$db->Close();
		return $result > 0;
		
	}
	/**
	 * 根据指定的id，更新status
	 * @param int $targetid
	 */
	public function UpdateStatus($targetid, $status = 2){
		$db = new ixg_mysql();
		$db->Connect();
		
		$id = mysql_real_escape_string($targetid);
		$status = mysql_real_escape_string($status);
		
		$sql = "update my_target set target_status = ".$status." where target_id = ".$id;
		$result = 0;
		$db->query($sql);
		
		if($db->isGo()){
			$result = $db->getUpdateNum();
		}else{
			log_error($db->getError());
		}
		// 关闭数据库连接
		$db->Close();
		return $result > 0;
	}
	
	/**
	 * 返回target，根据传入的startindex和count来决定起始和数量
	 * 默认的排序规则为：target_createtime asc
	 * @param int $workid
	 * @param int $startindex
	 * @param int $count
	 */
	public function Select($workid, $startindex = 0, $count = 10){
		$db = new ixg_mysql();
		$db->Connect();
		
		$startindex = mysql_real_escape_string($startindex);
		$count = mysql_real_escape_string($count);
		$workid = mysql_real_escape_string($workid);
		
		$sql = 'SELECT * FROM my_target where work_id = '.$workid.' and target_status != 2 ORDER BY target_createtime ASC LIMIT '.$startindex.','.$count;
		
		log_error($sql);
		$db->query($sql);
		
		$resultArray = array();
		
		// 判断是否执行成功
		if($db->isGo()){
			
			while ($row = $db->getRow()){
				array_push($resultArray, $row);
			}
			
		}else{
			log_error($db->getError());
		}
		// 关闭数据库连接		
		$db->Close();
		return $resultArray;
	}
	
	
}

?>