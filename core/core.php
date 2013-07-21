<?php
// 载入JS扩展库
require_once 'util/JS_Expand.php';
// 载入Log支持库
require_once 'util/Log_Support.php';
// 载入Date支持库
require_once 'util/Date_Support.php';
// 载入MySQL支持库
require_once 'util/MySQL_Support.php';
// 载入Loader支持库
require_once 'util/Loader_Support.php';
// 载入Request支持库
require_once 'util/Request_Support.php';
/*
 * 设置字符编码
 */
header("content-type:text/html; charset=utf-8");
/*
 * 将默认时区设置为中国上海
 */
date_default_timezone_set('Asia/Shanghai');
/*
 * 设置日志级别 
 */
$GLOBALS['log_level'] = 'error';
/*
 * 配置数据库连接信息
 */
$dbconfig['host']='localhost';//数据库主机
$dbconfig['user']='root';//数据库用户名
$dbconfig['pass']='root';//数据库密码
$dbconfig['port']='3306';//数据库端口，mysql默认是3306，一般不需要修改
$dbconfig['dbname']='laoyou';//数据库名
$dbconfig['charset']='utf8';//数据库编码
// mysql全局Helper
$GLOBALS['mysql'] = new MySQL_Support($dbconfig);
/*
 * 载入Action基类
*/
require_once 'base/class_Action.php';
/*
 * 载入Service基类
*/
require_once 'base/class_Service.php';
/*
 * 载入所有action 
 */
load_Action();
/*
 * 载入所有的service
 */
load_Service();
