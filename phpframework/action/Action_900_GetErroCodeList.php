<?php
/*
 * @Name:GetErrorCodeList,
 * @Code:900
 */

$pld->list = array(
	'5000'=>'服务器内部错误',
	'5001'=>'缺少参数字段 prm',
	'5002'=>'错误'
);

return toResponseSuccess($actionInfo,$pld,$local);



