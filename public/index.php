<?php 

define('APP_PATH', 
		dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR."protected".DIRECTORY_SEPARATOR);
define('UPL_PATH', 
		dirname(__FILE__).DIRECTORY_SEPARATOR."upload".DIRECTORY_SEPARATOR);

class MainApp{
	
	public static function config(){ 
	
		return require APP_PATH."config.php";
	
	}
	
}

require_once APP_PATH."controller/actions.php";
require_once APP_PATH."model/task.php";

session_start();

$act = new Actions();

$url = $_SERVER['REQUEST_URI'];
$urlPartsTmp = explode('?',$url);
if(count($urlPartsTmp)>2)
	$getParams = array_pop($urlPartsTmp);
$urlParts = explode('/',$urlPartsTmp[0]);
$urlMain = explode('-',$urlParts[1]);

foreach($urlMain as $key => $val){
	$urlMain[$key] = ucfirst($urlMain[$key]);
}
$action = 'action'.(implode('',$urlMain));

if($urlMain[0]==''){
	$act->actionIndex();
}elseif(method_exists(Actions, $action)){
	$act->{$action}($urlParams);
}else{
	$act->actionPage404();
}

require_once APP_PATH."/view/layout.php";
