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
	$file_name = md5(time());
	move_uploaded_file($_FILES["file"]["tmp_name"], 'files/'.$file_name);
	
	/*
	 * 创建数据库对象，执行插入到数据库的语句
	 */
	$db = new ixg_mysql();
	$db->Connect(null);
	$sql = "insert into my_files(file_id, file_name, file_mime, file_size, createtime) values('".$file_name."','".$_FILES["file"]['name']."','".$_FILES["file"]['type']."','".$_FILES["file"]['size']."',".time().")";
	$db->query($sql);
	
	if($db->isGo() && $db->getUpdateNum() > 0){
		
	}else{
		echo JS_alert('sql excption: '.$db->getError());
	}
	
	$db->Close();
	
	
	/*
	 * 开始执行回调事件
	 */
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		
		/*
		 * 先触发回调事件，然后调用JQuery删除上传组件
		 */
		echo JS_func('parent.uploadComplate("'.$id.'","'.$file_name.'")');
// 		echo JS_func('parent.$("#'.$id.'").remove()');
	}
	
}else{
	JS_alert('上传时出现错误！');
}




// echo '<script>parent.uploadComplate("干干尴尬");</script>';