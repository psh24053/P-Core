<?php
/*
 * @Name:AddTarget,
 * @Code:109
 */

if(!isset($prm)){
	toResponseError($actionInfo, 5001, 'prm not found');
}
if(!isset($prm->content)){
	toResponseError($actionInfo, 5001, 'field "content" not found');
}
if(!isset($prm->workid)){
	toResponseError($actionInfo, 5001, 'field "workid" not found');
}

include 'service/targetservice.php';

$targetservice = new targetservice();

$result = $targetservice->Insert($prm);

if($result){
	toResponseSuccess($actionInfo);
}else{
	toResponseError($actionInfo, 5000, '插入target失败');
}


// toResponseError($actionInfo);