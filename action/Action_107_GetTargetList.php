<?php
/*
 * @Name:GetTargetList,
 * @Code:107
 */

if(!isset($prm)){
	toResponseError($actionInfo, 5001, 'prm not found');
}
if(!isset($prm->start)){
	toResponseError($actionInfo, 5001, 'field "start" not found');
}
if(!isset($prm->count)){
	toResponseError($actionInfo, 5001, 'field "count" not found');
}
if(!isset($prm->workid)){
	toResponseError($actionInfo, 5001, 'field "workid" not found');
}

include 'service/targetservice.php';

$targetservice = new targetservice();

$resultArray = $targetservice->Select($prm->workid, $prm->start, $prm->count);

$pld->total = count($resultArray);
$pld->list = $resultArray;

toResponseSuccess($actionInfo, $pld);

// toResponseError($actionInfo);