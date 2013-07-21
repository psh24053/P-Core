<?php
/**
 * 调用JS方法体，让传入的字符串运行在script标签中
 * @param String $msg
 */
function JS_func($msg = ''){

	echo '<script type="text/javascript">'.$msg.'</script>';
}
/**
 * 调用JS的alert方法
 * @param String $msg
 */
function JS_alert($msg = ''){

	echo JS_func('alert("'.$msg.'");');

}
/**
 * 调用JS的confirm方法，返回结果，结果为Boolean值
 * @param String $msg
 */
function JS_confirm($msg = ''){
	
}