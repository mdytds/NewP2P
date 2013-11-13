<?php
if (!defined('APP_NAME')) exit('ggg');
error_reporting(E_ERROR);
date_default_timezone_set('Asia/Shanghai');//'Asia/Shanghai' 亚洲/上海

/*调试、找错时请去掉//*/
//ini_set('display_errors',true);
//error_reporting(E_ALL); 
error_reporting(0);
set_time_limit(30);
/**/
    /*网站根目录URL*/
	define('ROOT_URL', '/');
	/*网站根目录*/
	define('ROOT_PATH', './');
	/*网站项目目录*/
	define('APPS_PATH', ROOT_PATH.'Apps/');
	/*网站数据目录 全站唯一可写目录,但没有执行权限*/
	define('WEB_DATA_PATH', ROOT_PATH.'Data/');
	/*网站缓存目录*/
	define('WEB_CACHE_PATH', WEB_DATA_PATH.'Cache/');
	/*模版目录*/
	define('WEB_THEMES_PATH',ROOT_PATH.'Themes/');
	
	
	/*网站运行目录*/
	define('WEB_RUNTIME_PATH', WEB_CACHE_PATH.'Runtime/');
	/*ThinkPHP路径*/
	define('THINK_PATH',ROOT_PATH.'core/');
	/*项目公共目录*/
	define('COMMON_PATH', ROOT_PATH.'Common/');
	/*站点公共目录,存放公用的JS,CSS,图片等文件*/
	define('PUBLIC_PATH', ROOT_PATH.'Public/');
	/*MySQL备份目录*/
	define('MYSQLBACKUP_PATH',WEB_DATA_PATH.'mysql_bak/'); //
	
	/*公共Model目录*/
	define('PUBLIC_MODEL',COMMON_PATH.'Model/');
	define('EXTEND_PATH',COMMON_PATH.'Extend/');
	
	
	
	/*网站数据URL*/
	define('WEB_DATA_URL', ROOT_URL.'Data/');
	/*上传相关定义*/
	define('WEB_UPLOAD_PATH', WEB_DATA_PATH.'Upload/');
	define('WEB_HEADPIC_PATH', WEB_UPLOAD_PATH.'HeadPic/'); //头像目录
	define('WEB_IMAGES_PATH', WEB_UPLOAD_PATH.'Images/'); //图片目录,包括广告图片,文章内容图片,友情链接LOGO图片等,实际写入的时候请按日期创建文件夹格式Ymd
	
    require_once(COMMON_PATH.'Base.php');


	
	//参数处理 控制不合规格的参数 处理 $_GET 和 $_POST 的键值
	check_gpc($_GET);
	check_gpc($_POST);
	//check_gpc($_COOKIE);

	/*非法参数检查*/
	if(file_exists(COMMON_PATH.'CHECKERROR.php')){
		require_once(COMMON_PATH.'CHECKERROR.php');
	}else{
		exit('wrong parameter: Missing parameter checks the file');
	}
	
	
	
	/***************/
		//定义项目路径    
		define('APP_PATH', APPS_PATH.APP_NAME.'/');
		//定义Runtime目录
		define('RUNTIME_PATH', WEB_RUNTIME_PATH.APP_NAME.'/');
		//定义项目模版目录
		define('TMPL_PATH', WEB_THEMES_PATH.APP_NAME.'/');
		//定义项目配置目录
		define('CONF_PATH', APP_PATH.'Conf/');
		
		build_dir();
		// 加载框架入口文件
		require( THINK_PATH.'ThinkPHP.php');
	/**************/
	
	