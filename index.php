<?php
namespace app;
include_once 'app/lib/config.php';
include "app/lib/DeepakPDO/DeepakPDO.php";
include "app/lib/CommonController.php";
include "app/lib/CommonModel.php";
include "app/lib/ViewHelper.php";
include 'autoload.php';


/**
 * Description of index
 *
 * @author SDI
 */
class index {
    private $arView = array();
    
    function __construct($session, $request, $configpath, $notneedtologin) {
        try {
            $config = \config\config::getSettings(null, $configpath);
            
            //DB Setup
            
            $objDatabase = new \DeepakPDO($config['db']);
            if ($config['debug'] == 1) {
                $objDatabase->debug = function($BaseQuery) {
                    echo "query: " . $BaseQuery->getQuery(true) . "<br/>";
                    echo "parameters: " . implode(', ', $BaseQuery->getParameters()) . "<br/>";
                    echo "rowCount: " . $BaseQuery->getResult()->rowCount() . "<br/>";
                };
            }
            
            //Controller and Action check
            $res = explode('/', 'Index/Index');
            if (isset($_REQUEST['q']) && $_REQUEST['q'] != null) {
                $res = explode('/', $_REQUEST['q']);
            }
            
            //ACL Check
            if (isset($session['role_id']) && $session['role_id'] != null) {
                //$acl = new \AclModel($objDatabase, $res['0'], $res['1'], $session['role_id']);
            } else {
                $_SESSION['role_id'] = 3;
            }
            
            $classModel = $res['0'].'Model';
            $view = $res['0'];
            $classController = $res['0'].'Controller';
            
            $action = $res['1'].'Action';
            
            $ajax = false;
            
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
                    && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) 
                    && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
                $ajax = true;
            } elseif(!$notneedtologin) {
                if (!isset($_SESSION['loginYN']) || $_SESSION['loginYN'] == null) { 
                    header('location:login.php');
                }
            }
            
            $whiteList = array('LoginController-index');
            if (!in_array($classController . '-' . $res['1'], $whiteList) && !$notneedtologin) {
              if (!isset($_SESSION['loginYN']) || $_SESSION['loginYN'] == null) {                 
                 if (!$ajax) {
                     header('location:login.php');
                     exit();
                 }
                header('HTTP/1.0 403 Forbidden');
                die('You have not permission.');
              }
            } 
            
            $objModel = new $classModel($objDatabase, $config);
            $objController = new $classController($objModel, $config);            
            $arView = $objController->$action($_REQUEST);
            
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
                    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
               include 'view/' . $view . '/' . $res['1'].'.php';
               die();
            } else {
               $this->arView = $arView;
            }
        } catch (\Exception $e) {
            error_log("\n\n[".date('H:i:s')."]\n".$e->getMessage()."\n\n", 3, "app/logs/".date('Y-m-d')."-errors.log");
        }
    }
    
    function returnToView()
    {
        return $this->arView;
    }
}