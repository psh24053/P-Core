<?php

include 'system.php';
/**
 * 文件上传
 */

/*
 * 判断Files对象是否正常
 */
if(empty($_FILES) === false){
	
	/*
	 * 判断file子项是否有错误
	 */
	if($_FILES['file']['error'] > 0){
		JS_alert('上传错误：' . $_FILES['file']['error']);
		exit();
	}
	
	
	/*
	 * 用Md5来生成文件名，并且将上传好的文件从缓存目录中移动到指定目录
	 */
	$file_md5_name = md5(time());
	if(!file_exists("files")){
		mkdir("files");
	}
	move_uploaded_file($_FILES["file"]["tmp_name"], 'files/'.$file_md5_name);

	include 'service/class_fileService.php';
	
	$fileService = new fileService();
	
	$file->file_id = $file_md5_name;
	$file->file_name = $_FILES["file"]['name'];
	$file->file_mime = $_FILES["file"]['type'];
	$file->file_size = $_FILES["file"]['size'];
	$file->createtime = time();
	
	$fileService->Insert($file);
	
	
	/*
	 * 开始执行回调事件
	 */
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		
		/*
		 * 先触发回调事件，然后调用JQuery删除上传组件
		 */
		echo JS_func('parent.uploadComplate("'.$id.'","'.$file_md5_name.'")');
	}
	
}else{
	JS_alert('上传时出现错误！');
}




// echo '<script>parent.uploadComplate("干干尴尬");</script>';