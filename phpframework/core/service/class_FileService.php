<?php
class FileService {
	
	
	/**
	 * 删除指定id的file
	 * @param String $file_id
	 */
	public function Delete($file_id){
		$db = $GLOBALS['mysql'];
		$db->Connect();
	
		$file_id = mysql_real_escape_string($file_id);
	
		$sql = "delete from ly_files where file_id = '".$file_id."'";
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
	 * 插入一个file到数据库
	 * @param object $file
	 */
	public function Insert($file){
		$db = $GLOBALS['mysql'];
		$db->Connect();
	
		$file_id = mysql_real_escape_string($file->file_id);
		$file_name = mysql_real_escape_string($file->file_name);
		$file_mime = mysql_real_escape_string($file->file_mime);
		$file_size = mysql_real_escape_string($file->file_size);
		$createtime = mysql_real_escape_string($file->createtime);
		
		$sql = "insert into ly_files(file_id, file_name, file_mime, file_size, createtime) values('".$file_id."','".$file_name."','".$file_mime."','".$file_size."',".$createtime.")";
		
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
	 * 返回files，根据传入的startindex和count来决定起始和数量
	 * 默认的排序规则为：file_time desc
	 * @param int $workid
	 * @param int $startindex
	 * @param int $count
	 */
	public function Select($file_id, $startindex = 0, $count = 10){
		$db = $GLOBALS['mysql'];
		$db->Connect();
	
		$startindex = mysql_real_escape_string($startindex);
		$count = mysql_real_escape_string($count);
		$file_id = mysql_real_escape_string($file_id);
	
		$sql = 'SELECT * FROM ly_files where file_id = "'.$file_id.'" ORDER BY createtime DESC LIMIT '.$startindex.','.$count;
	
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