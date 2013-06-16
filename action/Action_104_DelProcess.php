<?php
/*
 * @Name:DelProcess,
 * @Code:104
 */

if(!isset($prm)){
	toResponseError($actionInfo, 5001, 'prm not found');
}
if(!isset($prm->processid)){
	toResponseError($actionInfo, 5001, 'field "processid" not found');
}

include 'service/processservice.php';

$processservice = new processservice();
		
$result = $processservice->Delete($prm->processid);

if($result){
	toResponseSuccess($actionInfo);
}else{
	toResponseError($actionInfo, 5000, '删除process错误');
}


