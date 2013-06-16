<?php
/*
 * @Name:AddProcess,
 * @Code:103
 */

if(!isset($prm)){
	toResponseError($actionInfo, 5001, 'prm not found');
}
if(!isset($prm->content)){
	toResponseError($actionInfo, 5001, 'field "content" not found');
}
if(!isset($prm->desc)){
	toResponseError($actionInfo, 5001, 'field "desc" not found');
}
if(!isset($prm->workid)){
	toResponseError($actionInfo, 5001, 'field "workid" not found');
}

include 'service/processservice.php';

$processservice = new processservice();
		
$result = $processservice->Insert($prm);

if($result){
	toResponseSuccess($actionInfo);
}else{
	toResponseError($actionInfo, 5000, '插入process错误');
}


