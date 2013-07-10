<?php
/**
 * 加载Service，从Service目录加载Service
 * 过滤掉不是class，没有继承Service类的文件
 */
function load_Service(){
	$services = array();

	$list = scandir('core/service');
	for ($i = 0 ; $i < count($list) ; $i ++){

		// 表示这个文件是一个.php文件
		if(substr_count($list[$i], '.php')){
				
			$filename = 'core/service/' . $list[$i];
				
			$handle = fopen($filename, "r");//读取二进制文件时，需要将第二个参数设置成'rb'
				
			//通过filesize获得文件大小，将整个文件一下子读到一个字符串中
			$contents = fread($handle, filesize ($filename));
			fclose($handle);
				
				
			// 提取类名 以及父类名
			$first = strpos($contents, "{");
			$classstart = strpos($contents, 'class');
			$str = substr($contents, $classstart, $first - $classstart);
			$str = trim($str);
				
			$className = trim(substr($str, 6, strpos($str, 'extends') - 6));
			$superClass = trim(substr($str, strpos($str, 'extends') + 7));
				
			if($superClass != 'Service'){
				continue;
			}
				
			// 构造Service信息
			$obj->className = $className;
			$obj->superClass = $superClass;
			$obj->path = $filename;
				
			require_once $obj->path;
			
			array_push($services, $obj);
				
				
		}


	}

	$GLOBALS['services'] = $services;
	return $services;
}
/**
 * 加载action，从action目录加载action
 * 过滤掉不是class，没有继承Action类的文件
 */
function load_Action(){
	$actions = array();
	
	$list = scandir('core/action');
	for ($i = 0 ; $i < count($list) ; $i ++){
		
		// 表示这个文件是一个.php文件
		if(substr_count($list[$i], '.php')){
			
			$filename = 'core/action/' . $list[$i];
			
			$handle = fopen($filename, "r");//读取二进制文件时，需要将第二个参数设置成'rb'
			
			//通过filesize获得文件大小，将整个文件一下子读到一个字符串中
			$contents = fread($handle, filesize ($filename));
			fclose($handle);
			
			
			// 提取类名 以及父类名			
			$first = strpos($contents, "{");
			$classstart = strpos($contents, 'class');
			$str = substr($contents, $classstart, $first - $classstart);
			$str = trim($str);
			
			$className = trim(substr($str, 6, strpos($str, 'extends') - 6));
			$superClass = trim(substr($str, strpos($str, 'extends') + 7));
			
			if($superClass != 'Action'){
				continue;
			}
			
			// 构造action信息
			$obj->className = $className;
			$obj->superClass = $superClass;
			$obj->path = $filename;
			
			require_once $obj->path;

			$o = new $obj->className;
			
			if(isset($o) && isset($o->actionCode)){
				
				$obj->actionCode = $o->actionCode;
				$obj->actionName = $o->actionName;
				$obj->instance = $o;
				$actions[$obj->actionCode] = $obj;
			}
			
		}
		
		
	}
	
	$GLOBALS['actions'] = $actions;
	return $actions;
}