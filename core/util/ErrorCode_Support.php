<?php

/**
 * 错误代码支持
 * @author panshihao
 *
 */
class ErrorCode {
	
	/**
	 * code 8500 服务器内部错误
	 * @var int
	 */
    const ERROR_CODE_SERVER_ERROR = 8500; 
	const ERROR_MSG_SERVER_ERROR = '服务器内部错误';
	
	/**
	 * code 8501 请求内容不是一个JSON字符串
	 * @var int
	 */
	const ERROR_CODE_NOT_JSON_STRING = 8501;
	const ERROR_MSG_NOT_JSON_STRING = '请求内容不是一个JSON字符串';
	/**
	 * code 8502 JSON格式验证错误
	 * @var int
	 */
	const ERROR_CODE_ACTION_FORMAT_ERROR = 8502;
	const ERROR_MSG_ACTION_FORMAT_ERROR = 'JSON格式验证错误';
	/**
	 * code 8503 对应action不存在
	 * @var int
	 */
	const ERROR_CODE_ACTION_NOT_FOUND = 8503;
	const ERROR_MSG_ACTION_NOT_FOUND = '对应action不存在';
	/**
	 * code 8504 缺少所需参数
	 * @var int
	 */
	const ERROR_CODE_MISSING_PARAMETER = 8504;
	const ERROR_MSG_MISSING_PARAMETER = '缺少所需参数';
	
	public static $ERROR_CODE = array(
			8500 => ErrorCode::ERROR_MSG_SERVER_ERROR,
			8501 => ErrorCode::ERROR_MSG_NOT_JSON_STRING,
			8502 => ErrorCode::ERROR_MSG_ACTION_FORMAT_ERROR,
			8503 => ErrorCode::ERROR_MSG_ACTION_NOT_FOUND,
			8504 => ErrorCode::ERROR_MSG_MISSING_PARAMETER
			);
}

?>