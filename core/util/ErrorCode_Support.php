<?php

/**
 * 错误代码支持
 * @author panshihao
 *
 */
class ErrorCode {
	
	public final static $ERROR_CODE_SERVER_ERROR = 8500; 
	public final static $ERROR_MSG_SERVER_ERROR = '服务器内部错误';
	
	public final static $ERROR_CODE_NOT_JSON_STRING = 8501;
	public final static $ERROR_MSG_NOT_JSON_STRING = '请求内容不是一个JSON字符串';
	
	public final static $ERROR_CODE_ACTION_FORMAT_ERROR = 8502;
	public final static $ERROR_MSG_ACTION_FORMAT_ERROR = 'JSON格式验证错误';
	
	public final static $ERROR_CODE_ACTION_NOT_FOUND = 8503;
	public final static $ERROR_MSG_ACTION_NOT_FOUND = '对应action不存在';
	
	public final static $ERROR_CODE_MISSING_PARAMETER = 8504;
	public final static $ERROR_MSG_MISSING_PARAMETER = '缺少所需参数';
}

?>