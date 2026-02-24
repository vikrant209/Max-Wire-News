<?php session_start();
define('ENV', 'development');
if (ENV == 'development') {
    ini_set('display_errors', 1);
    error_reporting(E_ALL & ~E_NOTICE);
    define('CATCHE_CLEAR', 'TRUE');
} else {
    define('CATCHE_CLEAR', 'FALSE');
}

$dView = array();
include_once 'app/index.php';

$notneedtologin = 0;
$controllerNotL = '';
if (isset($_REQUEST['q']) && $_REQUEST['q'] != null) {
   $controllerNotL = explode('/', $_REQUEST['q']);
   if ($controllerNotL['0'] == 'Entrance' || $controllerNotL['0'] == 'Payment') {
        $notneedtologin = 1;       
   }
}

if((isset($_REQUEST['q']) && $_REQUEST['q'] == 'Entrance/application')|| (isset($notLogin) && $notLogin ==1)) {
    $notneedtologin = 1;
}

$gView = new \app\index($_SESSION, $_REQUEST, 'app/config/', $notneedtologin);
if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) ||
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $dView = $gView->returnToView();
    if (isset($_REQUEST['q']) && $_REQUEST['q']!=null) {
       $res = explode('/', $_REQUEST['q']);
       $print = include 'app/view/' . $res['0'] . '/' . $res['1'].'.php';
    }
}
