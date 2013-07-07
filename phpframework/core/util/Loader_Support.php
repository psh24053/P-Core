<?php
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
			
			
			if(ereg("class\s\w+\sextends\s\w+", $contents, $regs)){
				echo $regs;
				echo 'class class class';
			}else{
				echo 'nonono';
			}
			
			
		}
		
		
	}
	
}


/**
 * 初始化action
 * @return actions
 */
function initActionList(){
	// action缓存，调试模式时最好关闭
	if(isset($_SERVER['actions'])){
		return $_SERVER['actions'];
	}

	$actions = array();

	$list = scandir('action');
	for ($i = 0 ; $i < count($list) ; $i ++){
		// 表示这个文件是一个.php文件
		if(substr_count($list[$i], '.php')){
			$filename = dirname(__FILE__).'/action/' . $list[$i];

			$handle = fopen($filename, "r");//读取二进制文件时，需要将第二个参数设置成'rb'

			//通过filesize获得文件大小，将整个文件一下子读到一个字符串中
			$contents = fread($handle, filesize ($filename));
			fclose($handle);

			/*
			 * @Name:GetWorkList,
			* @Code:100,
			* @Desc:获取Work列表
			*/
			$info = trim(substr(trim($contents), strpos($contents, '/*')+2, strpos($contents, '*/') - 8));
			$info = trim(str_replace('*', '', $info));
			$strarray = explode(',', $info);

			$act = null;

			for($j = 0 ; $j < count($strarray) ; $j ++){
				$str = trim($strarray[$j]);

				$arr = explode(":", $str);

				if($arr[0] == '@Name'){
					$act->name = $arr[1];
				}else if($arr[0] == '@Code'){
					$act->cod = $arr[1];
				}

			}
			$act->path = 'action/' . $list[$i];
			$actions[$act->cod] = $act;
		}

	}

	$_SERVER['actions'] = $actions;
	return $actions;

}