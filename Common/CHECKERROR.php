<?PHP
$referer=empty($_SERVER['HTTP_REFERER']) ? array() : array($_SERVER['HTTP_REFERER']);

set_error_handler("customError",E_ERROR);

$getfilter="'|<[^>]*?>|^\\+\/v(8|9)|\\b(and|or)\\b.+?(>|<|=|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";

$postfilter="^\\+\/v(8|9)|\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";

$cookiefilter="\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";

    //循环检查$_GET
	foreach($_GET as $key=>$value){ 
		StopAttack($key,$value,$getfilter);
	}
	
	//循环检查$_POST
	foreach($_POST as $key=>$value){ 
		StopAttack($key,$value,$postfilter);
	}
	
	//循环检查$_COOKIE
	foreach($_COOKIE as $key=>$value){ 
		StopAttack($key,$value,$cookiefilter);
	}
	
	//循环检查页面来源
	foreach($referer as $key=>$value){ 
		StopAttack($key,$value,$getfilter);
	}


    
	function StopAttack($StrFiltKey,$StrFiltValue,$ArrFiltReq){
		//定义错误样式
		$errorCss = '
			<style>
			  .errorCss{
				  position:fixed;
				  top:0px;
				  width:100%;
				  height:100%;
				  background-color:white;
				  color:red;
				  font-weight:bold;
				  border-bottom:5px solid #999;
			  }
			 </style>
		';
		//定义错误提示
		$errorCont = $errorCss."<div class='errorCss'><br>您的提交带有不合法参数,谢谢合作!</div>";
		
		//定义日志内容
		$logs = "<br><br>操作IP: ".$_SERVER["REMOTE_ADDR"].
		        "<br>操作时间: ".strftime("%Y-%m-%d %H:%M:%S").
				"<br>操作页面:".$_SERVER["PHP_SELF"].
				"<br>提交方式: ".$_SERVER["REQUEST_METHOD"].
				"<br>提交参数: ".$StrFiltKey."<br>提交数据: ";
		
		$StrFiltValue=arr_foreach($StrFiltValue);
		if (preg_match("/".$ArrFiltReq."/is",$StrFiltValue)==1){   
				header("Content-type: text/html; charset=utf-8");
				slog($logs.htmlentities($StrFiltValue)); 
				exit($errorCont);
		}
		if (preg_match("/".$ArrFiltReq."/is",$StrFiltKey)==1){  
		        header("Content-type: text/html; charset=utf-8"); 
				slog($logs.htmlentities($StrFiltValue));
				exit($errorCont);
		}  
	}  


	function slog($logs){
		$toppath = $_SERVER["DOCUMENT_ROOT"]."/BDP2PERROR.htm";
		if(!file_exists($toppath)){
			WriteLog($toppath,"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\r\n");
		}
		WriteLog($toppath,$logs);
	}
	
	function WriteLog($toppath,$logs){
		$Ts=fopen($toppath,"a+");
		fputs($Ts,$logs."\r\n");
		fclose($Ts);
	}
	
	function arr_foreach($arr) {
		static $str;
		if (!is_array($arr)) {
		   return $arr;
		}
		foreach ($arr as $key => $val ) {
			if (is_array($val)) {
			   arr_foreach($val);
			} else {
			   $str[] = $val;
			}
		}
		return implode($str);
	}

	function customError($errno, $errstr, $errfile, $errline){ 
		echo "<b>Error number:</b> [$errno],error on line $errline in $errfile<br />";
		die();
	}
