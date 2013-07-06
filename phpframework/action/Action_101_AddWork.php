<?php
/*
 * @Name:AddWork,
 * @Code:101
 */

if(!isset($prm)){
	toResponseError($actionInfo, 5001, 'prm not found');
}
if(!isset($prm->name)){
	toResponseError($actionInfo, 5001, 'field "name" not found');
}
if(!isset($prm->status)){
	toResponseError($actionInfo, 5001, 'field "status" not found');
}
if(!isset($prm->desc)){
	toResponseError($actionInfo, 5001, 'field "desc" not found');
}
if(!isset($prm->img)){
	toResponseError($actionInfo, 5001, 'field "img" not found');
}
if(!isset($prm->everyday)){
	toResponseError($actionInfo, 5001, 'field "everyday" not found');
}

include 'service/workservice.php';

$workService = new workservice();
$result = $workService->Insert($prm);

if($result){
	toResponseSuccess($actionInfo);
}else{
	toResponseError($actionInfo, 5000, '插入work错误');
}


