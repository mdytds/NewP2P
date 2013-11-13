<?php

/**
 * 模拟系统D函数
 * D函数用于实例化Model 格式 项目://分组/模块
 * @param string $name Model资源地址
 * @param string $layer 业务层名称
 * @return Model
 */
function MD($name='',$layer='') {
    if(empty($name)) return new Model;
	$name = PUBLIC_MODEL.$name;
    static $_model = array();
    $layer          =   $layer?$layer:C('DEFAULT_M_LAYER');
    if(isset($_model[$name])) return $_model[$name];

	$classfile = $name.$layer. '.class.php';
	require_cache($classfile);
	
    $class          =   basename($name.$layer);
	
    if(class_exists($class)) {
        $model      =   new $class(basename($name));
    }else {
        $model      =   new Model(basename($name));
    }
    $_model[$name]  =  $model;
    return $model;
}
