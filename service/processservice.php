<?php
class processservice {
	
	
	/**
	 * 删除指定id的process
	 * @param int $id
	 */
	public function Delete($id){
		$db = new ixg_mysql();
		$db->Connect();
		
		$id = mysql_real_escape_string($id);
		
		$sql = "delete from my_process where process_id = ".$id;
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
	 * 插入一个process到数据库
	 * @param object $work
	 */
	public function Insert($process){
		$db = new ixg_mysql();
		$db->Connect();
		
		$content = mysql_real_escape_string($process->content);
		$desc = mysql_real_escape_string($process->desc);
		$workid = mysql_real_escape_string($process->workid);
		
		$sql = "INSERT INTO my_process(process_content,process_desc,work_id,process_time) VALUES('".$content."','".$desc."',".$workid.",UNIX_TIMESTAMP())";
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
	 * 返回process，根据传入的startindex和count来决定起始和数量
	 * 默认的排序规则为：process_time desc
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
		
		$sql = 'SELECT * FROM my_process where work_id = '.$workid.' ORDER BY process_time DESC LIMIT '.$startindex.','.$count;
		
		$db->query($sql);
		
		$resultArray = array();
		
		// 判断是否执行成功
		if($db->isGo()){
			
			while ($row = $db->getRow()){
				$row['process_timevalue'] = parseDate($row['process_time']);
				$row['process_time'] = date('Y-m-d H:i:s',$row['process_time']);
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