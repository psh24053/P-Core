<?php
include 'core.php';
/**
 * 根据fid获取文件
 */

/*
 * 首先判断fid是否存在，必须是get形式的参数
 * 如果fid参数不存在则停止执行
 */
if(!isset($_GET['fid'])){
	exit();
}else{
	$FID = $_GET['fid'];
}

/*
 * 目标文件夹
 */
$file_dir = '../files/';
/*
 * 目标文件夹句柄
 */
$file_handler= opendir($file_dir);

/*
 * 遍历文件夹
 */ 
while ($file_name = readdir($file_handler)){

	/*
	 * 如果文件名称为.或者..则跳出本次循环
	 */
	if($file_name == '.' || $file_name == '..'){
		continue;
	}

	/*
	 * 如果文件名称与FID一致，执行文件输出逻辑
	 */
	if($file_name == $FID){
		
		$fileService = new fileService();
		
		
		$files = $fileService->Select($file_name, 0, 1);
		
		if(count($files) > 0){
			$row = $files[0];
			$mimeType = $row['file_mime'];
			$fileSize = $row['file_size'];
			$fileSourceName = $row['file_name'];
		}else{
			closedir($file_handler);
			echo '查找文件信息错误';
			exit ();
		}
		
		/*
		 * 打开文件流，设置为只读权限
		 */
		$file = fopen($file_dir . $file_name, 'r');

		/*
		 * 增加Http Header信息，将包含mimeType等
		 */
		Header ( "Content-type: " . $mimeType);
		Header ( "Accept-Ranges: bytes" );
		Header ( "Accept-Length: " . $fileSize );
		
		/*
		 * 如果文件时以下这些类型，则以下载处理
		 */
		if(stripos($mimeType, 'image') !== false){
			
		}else{
			Header ( "Content-Disposition: attachment; filename=" . $fileSourceName );
			
		}
		
		
		
		/*
		 * 输出文件流内容
		 */
		echo fread ( $file, $fileSize );
		
		/*
		 * 关闭IO句柄，并结束运行
		 */
		fclose ( $file );
		closedir($file_handler);
		exit ();
	}



}

/*
 * 关闭IO句柄，并结束运行
 */
closedir($file_handler);
exit();



