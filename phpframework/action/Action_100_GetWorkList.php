<?php
/*
 * @Name:GetWorkList,
 * @Code:100
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

include 'service/workservice.php';

$workService = new workservice();

$resultArray = $workService->SelectAll($prm->start, $prm->count);

$pld->total = count($resultArray);
$pld->list = $resultArray;
toResponseSuccess($actionInfo, $pld);

// toResponseError($actionInfo);