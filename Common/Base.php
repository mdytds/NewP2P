<?php
//授权验证
	function Authorize(){
		$Authorize = file_get_contents(COMMON_PATH.'.key'); //
		$k = md5(md5_file('index.php').$_SERVER['HTTP_HOST'].'094112934a03');
		if($Authorize !== $k){
			return false;
		}else{
			return $_SERVER['HTTP_HOST'];
		}
	}

	/**
	 * GPC参数过滤
	 * @param array|string $value The array or string to be striped.
	 * @return array|string Stripped array (or string in the callback).
	 */
	function check_gpc($value=array()) {
		if(!is_array($value)) return;
		foreach ($value as $key=>$data) {
			//对get、post的key值做限制,只允许数字、字母、及部分符号_-[]#@~
			if(!preg_match('/^[a-zA-z0-9_]+$/i',$key)){
				die('wrong parameter: Illegal key data');
			}
		}
	}
	
/**
* 生成初始化配置文件
*
*/
function build_dir(){
	$dirs  = array(
	  WEB_DATA_PATH,
	  WEB_CACHE_PATH,
	  WEB_THEMES_PATH,
	  WEB_RUNTIME_PATH,
	  COMMON_PATH,
	  RUNTIME_PATH,
	  WEB_UPLOAD_PATH,
	  PUBLIC_PATH,
	  WEB_HEADPIC_PATH,
	  WEB_IMAGES_PATH,
	  MYSQLBACKUP_PATH,
	  CONF_PATH,
	  PUBLIC_MODEL
	);
	foreach ($dirs as $dir){
	  if(!is_dir($dir))  mkdir($dir,0755,true);
	}
	
	// 写入初始配置文件
if(!is_file(CONF_PATH.'config.php')){
  $cofigArr = 
	"\$array = array(
	/*自动生成配置.请根据项目的实际需求进行修改*/
	'APP_FILE_CASE'			=> true,	// 是否检查文件的大小写 对Windows平台有效
	'TMPL_CACHE_ON'			=> false, 	//开启模板缓存
	'URL_CASE_INSENSITIVE'  => true, 	//URL不区分大小写
	'URL_MODEL'             => 2,     //服务器开启Rewrite模块时，可去除URL中的index.php 	
	'DEFAULT_THEME'    		=> 'default',  // 默认模板主题名称
	
	//应用配置
	'TMPL_CACHE_TIME'	=> 0, 			// 模板缓存有效期 -1 永久 单位为秒
	'URL_HTML_SUFFIX'	=> '.html',		//网站伪静态
	
	//安全配置
	'TOKEN_ON'=>true,  // 是否开启令牌验证
	'TOKEN_NAME'=>'__hash__',    // 令牌验证的表单隐藏字段名称
	'TOKEN_TYPE'=>'md5',  //令牌哈希验证规则 默认为MD5
	'TOKEN_RESET'=>true,  //令牌验证出错后是否重置令牌 默认为true,	
	
	//默认错误跳转对应的模板文件
	'TMPL_ACTION_ERROR' => 'Public:error',
	//默认成功跳转对应的模板文件
	'TMPL_ACTION_SUCCESS' => 'Public:success',
	//错误重定向页面
	//'TMPL_EXCEPTION_FILE'=> ''
	
	//分页配置
	'PAGE_LISTROWS' =>10,
	'VAR_PAGE'=>'p',
	
	//COOKIES
	'COOKIE_PREFIX' => 'JN_',
	
	//缓存类型
	'DATA_CACHE_TYPE' => 'File',
  );
	\$dbconfig	=	require_once COMMON_PATH.'dbConfig.php';
	return array_merge(\$dbconfig,\$array);
	";
  file_put_contents(CONF_PATH.'config.php',"<?php\n ".$cofigArr."\n?>");
}


}