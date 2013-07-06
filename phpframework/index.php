<?php 
session_start();
// 当session中没有pass时
if(!isset($_SESSION["pass"])){
	@$pass = $_POST['pass'];
	
	if(!isset($pass)){
		?>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="scripts/MD5.js"></script>
		<form action="index.php" onsubmit="document.getElementById('pass').value = hex_md5(document.getElementById('pass').value); return true;" method="post">
			<label>密码</label>
			<input type="password" id="pass" name="pass" />
			<input type="submit" value="登陆" />
		</form>
		<?php 
		exit();
	}else{
		if($pass == md5('caicai520')){
			@$_SESSION["pass"] = $pass;
		}else{
			?>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<script type="text/javascript" src="scripts/MD5.js"></script>
			<form action="index.php" onsubmit="document.getElementById('pass').value = hex_md5(document.getElementById('pass').value); return true;" method="post">
				<label>密码</label>
				<input type="password" id="pass" name="pass" />
				<input type="submit" value="登陆" />
			</form>
			<?php 
			exit();
		}
	}
	
}else{
	@$pass = $_SESSION["pass"];
	
	if($pass == md5('caicai520')){
		$_SESSION["pass"] = $pass;
	}else{
		$_SESSION["pass"] = null;
		?>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="scripts/MD5.js"></script>
		<form action="index.php" onsubmit="document.getElementById('pass').value = hex_md5(document.getElementById('pass').value); return true;" method="post">
			<label>密码</label>
			<input type="password" id="pass" name="pass" />
			<input type="submit" value="登陆" />
		</form>
		<?php 
		exit();
	}
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Home - MyTask</title>
		<script type="text/javascript">
		var mytask = new Object();
		if(!window.console){
			window.console = {
				debug: function(){
					
				},
				log: function(){
					
				}
			};
		}
		if(console.debug == undefined){
			console.debug = console.log;
		}
		</script>
		<link type="text/css" rel="stylesheet" href="styles/index.css" />
		<link type="text/css" rel="stylesheet" href="jqueryui/css/smoothness/jquery-ui-1.9.2.custom.min.css" />
		
		<script type="text/javascript" src="scripts/jquery-1.8.1.min.js"></script>
		<script type="text/javascript" src="jqueryui/js/jquery-ui-1.9.2.custom.min.js"></script>
		<script type="text/javascript" src="scripts/json2.js"></script>
		<script type="text/javascript" src="scripts/jquery.cookie.js"></script>
		<script type="text/javascript" src="scripts/ajax.js"></script>
		<script type="text/javascript" src="scripts/Dialog.js"></script>	
		<script type="text/javascript" src="ueditor/editor_config.js"></script>	
		<script type="text/javascript" src="ueditor/editor_all.js"></script>	
		<script type="text/javascript" src="scripts/index.js"></script>		
		
	</head>
	
	<body>
		
		<div id="header">
			<div class="header_content">
				<a href="javascript:void(0)" class="add_work_button">增加work</a>
				<a href="javascript:void(0)" class="refresh_button" style="margin-left: 20px">刷新</a>
				<a target="_blank" href="http://panshihao.cn" class="my_button" style="float: right;">panshihao.cn</a>
			</div>
			
		
		</div>
	
		<div id="work_type">
		    <input type="radio" id="today_unfinished" name="work_type" checked="checked" /><label style="color: red;text-shadow: #cccccc 1px 1px 0;font-weight: bold;" for="today_unfinished">今日待办 （今天 0）</label>
		    <input type="radio" id="today_complete" name="work_type" /><label style="color: green;text-shadow: #cccccc 1px 1px 0;font-weight: bold;" for="today_complete">等待处理 （所有 0）</label>
		    <input type="radio" id="come_to_an_end" name="work_type" /><label style="color: orange; ;text-shadow: #cccccc 1px 1px 0;font-weight: bold;" for="come_to_an_end">告一段落 0</label>
		    <input type="radio" id="history" name="work_type" /><label style="color: fuchsia ;text-shadow: #cccccc 1px 1px 0;font-weight: bold;" for="history">成为历史 0</label>
		</div>
	
		<div id="work">
			
			<button class="left_arrow item_arrow"><<</button>
			
			<div class="item_content">
				
			</div>
			
			
			<button class="right_arrow item_arrow">>></button>
		
		</div>
		
		<div id="work_content">
			
			
			
		</div>
		
		
	
		<div style="display: none;">
			<div class="addwork_dialog">
				<ul style="margin: 10px;">
					<li><label>Work名称</label><input type="text" class="mytask-textinput" name="name"/></li>
					<li><label>Work描述</label><textarea class="mytask-textarea" name="desc"></textarea> </li>
					<li><label>Work状态</label>
					<select name="status" class="mytask-select">
						<option value="1">等待处理</option>
						<option value="2">告一段落</option>
						<option value="3">成为历史</option>
					</select></li>
					<li><label>每日提醒</label><input type="checkbox" class="work_everyday" /></li>
					<li><label>Work图片</label>
						<form action="upload.php?id=addworkimg" id="addworkimg" enctype="MULTIPART/FORM-DATA" target="post_frame" method="POST">
							<iframe name="post_frame" id="post_frame" style="display:none;" mce_style="display:none;"></iframe>
							<input name="file" type="file" class="mytask-fileinput" value="选择文件"/>
							<input type="button" class="addworkimg_upload" value="上传"/>
							<script type="text/javascript">
							function uploadComplate(id, fid){
								if(id == 'addworkimg'){
									$('.addwork_img').attr('src','getfile.php?fid='+fid).attr('fid',fid);
								}
							}
							</script>
						</form>
					</li>
					<li><label>图片预览</label><img class="addwork_img" /></li>
				</ul>
			
			</div>
			<div class="addprocess_dialog">
				<ul style="margin: 10px;">
					<li><label>process内容</label>
					<script  id="addprocess_dialog_content" type="text/plain"></script>
					 </li>
					<li><label>process描述</label>
					<textarea class="mytask-textarea" name="desc"></textarea> </li>
				</ul>
			</div>
			<div class="addtarget_dialog">
				<ul style="margin: 10px;">
					<li><label>target内容</label>
					<textarea class="mytask-textarea" name="content"></textarea> </li>
				</ul>
			</div>
			<div class="editwork_dialog">
				<ul style="margin: 10px;">
					<li><label>Work名称</label><input type="text" class="mytask-textinput" name="name"/></li>
					<li><label>Work描述</label><textarea class="mytask-textarea" name="desc"></textarea> </li>
					<li><label>Work状态</label>
					<select name="status" class="mytask-select">
						<option value="1">等待处理</option>
						<option value="2">告一段落</option>
						<option value="3">成为历史</option>
					</select></li>
					<li><label>每日提醒</label><input type="checkbox" class="work_everyday" /></li>
					<li><label>Work图片</label>
						<form action="upload.php?id=addworkimg" id="addworkimg" enctype="MULTIPART/FORM-DATA" target="post_frame" method="POST">
							<iframe name="post_frame" id="post_frame" style="display:none;" mce_style="display:none;"></iframe>
							<input name="file" type="file" class="mytask-fileinput" value="选择文件"/>
							<input type="button" class="addworkimg_upload" value="上传"/>
							<script type="text/javascript">
							function uploadComplate(id, fid){
								if(id == 'addworkimg'){
									$('.addwork_img').attr('src','getfile.php?fid='+fid).attr('fid',fid);
								}
							}
							</script>
						</form>
					</li>
					<li><label>图片预览</label><img class="addwork_img" /></li>
				</ul>
			</div>
		</div>
	
	</body>
	
	
</html>
