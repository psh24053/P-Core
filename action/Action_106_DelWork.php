<?php
/*
 * @Name:DelWork,
 * @Code:106
 */

if(!isset($prm)){
	toResponseError($actionInfo, 5001, 'prm not found');
}
if(!isset($prm->workid)){
	toResponseError($actionInfo, 5001, 'field "workid" not found');
}

include 'service/workservice.php';

$workservice = new workservice();

$result = $workservice->Delete($prm->workid);

if($result){
	toResponseSuccess($actionInfo);
}else{
	toResponseError($actionInfo, 5000, '删除work错误');
}


