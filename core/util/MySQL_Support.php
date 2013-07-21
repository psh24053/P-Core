<?php
/**
 * MySQL操作支持类
 * @author Panshihao
 *
 */
class MySQL_Support {
	
	private $dbconfig;
	private $conn;
	private $newlink = "mysql_link";
	private $result;
	
	/**
	 * 构造方法，传入$dbconfig
	 * $dbconfig ->
	 * 		$config['host']='localhost';//数据库主机
	 *		$config['user']='root';//数据库用户名
	 *		$config['pass']='123456';//数据库密码
	 *		$config['port']='3306';//数据库端口，mysql默认是3306，一般不需要修改
	 * 		$config['dbname']='cp';//数据库名
	 *		$config['charset']='utf8';//数据库编码
	 * 
	 * 
	 * @param object $dbconfig
	 */
	function __construct($dbconfig){
		$this->dbconfig = $dbconfig;
	}
	
	/**
	 *
	 * 连接到数据库的方法
	 */
	function Connect($dbname = NULL, $newlink = null){
		if(isset($newlink)){
			$this->newlink = $newlink;
		}
		$this->conn = mysql_connect($this->dbconfig['host'].":".$this->dbconfig['port'],$this->dbconfig['user'],$this->dbconfig['pass'],$this->newlink) or die(mysql_error());
		if($dbname){
			mysql_select_db($dbname,$this->conn) or die("未找到数据库".$dbname);
		}else{
			mysql_select_db($this->dbconfig['dbname'],$this->conn) or die("未找到数据库".$this->dbconfig['dbname']);
		}
		mysql_query("set names '".str_replace("-", "", $this->dbconfig['charset'])."'",$this->conn);
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




?>