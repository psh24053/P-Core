<?php
class workservice {
	
	/**
	 * 删除指定id的work
	 * @param int $id
	 */
	public function Delete($id){
		$db = new ixg_mysql();
		$db->Connect();
	
		$id = mysql_real_escape_string($id);
	
		$sql = "delete from my_process where work_id = ".$id;
		$result = 0;
		$db->query($sql);
	
		if($db->isGo()){
			$result = $db->getUpdateNum();
		}else{
			log_error($db->getError());
		}
		
		$sql = "delete from my_work where work_id = ".$id;
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
	 * 更新work
	 * @param object $work
	 * @return boolean
	 */
	public function Update($work){
		$db = new ixg_mysql();
		$db->Connect();
	
		$name = mysql_real_escape_string($work->name);
		$status = mysql_real_escape_string($work->status);
		$desc = mysql_real_escape_string($work->desc);
		$img = mysql_real_escape_string($work->img);
		$id = mysql_real_escape_string($work->id);
		$everyday = mysql_real_escape_string($work->everyday);
		
		$sql = "update my_work set work_name = '".$name."',work_status = ".$status.",work_desc = '".$desc."',work_img = '".$img."',work_lasttime = UNIX_TIMESTAMP(),work_everyday = '.$everyday.' where work_id = ". $id;
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
	 * 插入一个work到数据库
	 * @param object $work
	 */
	public function Insert($work){
		$db = new ixg_mysql();
		$db->Connect();
		
		$name = mysql_real_escape_string($work->name);
		$status = mysql_real_escape_string($work->status);
		$desc = mysql_real_escape_string($work->desc);
		$img = mysql_real_escape_string($work->img);
		$everyday = mysql_real_escape_string($work->everyday);
		
		$sql = "INSERT INTO my_work(work_name,work_status,work_desc,work_img,work_createtime,work_lasttime,work_everyday) VALUES('".$name."',".$status.",'".$desc."','".$img."',UNIX_TIMESTAMP(),UNIX_TIMESTAMP(),'.$everyday.')";
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
	 * 返回work，根据传入的startindex和count来决定起始和数量
	 * 默认的排序规则为：work_status asc,work_lasttime desc
	 * @param int $startindex
	 * @param int $count
	 */
	public function SelectAll($startindex = 0, $count = 10){
		$db = new ixg_mysql();
		$db->Connect();
		
		$startindex = mysql_real_escape_string($startindex);
		$count = mysql_real_escape_string($count);
		
		$sql = 'SELECT *,(SELECT COUNT(*) FROM my_target WHERE work_id = w.work_id and target_status != 2) AS target_count FROM my_work w ORDER BY target_count DESC,w.work_status ASC,w.work_lasttime DESC LIMIT '.$startindex.','.$count;
		log_error($sql);
		$db->query($sql);
		
		$resultArray = array();
		
		// 判断是否执行成功
		if($db->isGo()){
			while ($row = $db->getRow()){
				$row['work_createtimevalue'] = date('Y-m-d H:i:s',$row['work_createtime']);
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