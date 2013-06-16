<?php
/*
 * @Name:UpdateTargetStatus,
 * @Code:108
 */

if(!isset($prm)){
	toResponseError($actionInfo, 5001, 'prm not found');
}
if(!isset($prm->targetid)){
	toResponseError($actionInfo, 5001, 'field "targetid" not found');
}

include 'service/targetservice.php';

$targetservice = new targetservice();

$result = $targetservice->UpdateStatus($prm->targetid, 2);

if($result){
	toResponseSuccess($actionInfo);
}else{
	toResponseError($actionInfo, 5000, '更新target状态失败');
}


// toResponseError($actionInfo);