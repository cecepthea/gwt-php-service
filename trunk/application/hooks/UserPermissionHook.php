<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'annotations/annotations.php';
require_once 'annotations/Secured.php';
require_once 'application/controllers/Search.php';

/**
 * UserPermissionHook
 *
 * @author Trieu Nguyen
 */
class UserPermissionHook {
    protected $LOGIN_URI = "";

    /**
     * CodeIgniter global
     *
     * @var string
     **/
    protected $ci;

    public function __construct() {
        $this->ci =& get_instance();
        $this->LOGIN_URI = base_url().'index.php?c=welcome&m=login&url_redirect=';
    }

    public function checkRole() {
        $tokens = split("/index.php/", $_SERVER["REQUEST_URI"]);
        if(sizeof($tokens)>=2 ) {
            $routeTokens =  split("/", $tokens[1]);
            // echo $routeTokens[0];
            //echo $routeTokens[1];

            if(sizeof($routeTokens)>=2) {
                $reflection = new ReflectionAnnotatedMethod($routeTokens[0],$routeTokens[1]);                     
                if($this->ci->redux_auth->logged_in() == FALSE && $reflection->hasAnnotation('Secured')) {
                    $annotation = $reflection->getAnnotation('Secured');
                    redirect($this->LOGIN_URI.$tokens[1]);
                }
            }
        // contains string "admin"
        // echo $annotation->role;
        // contains integer "2"
        //  echo $annotation->level;
        }
    }

    public static function curPageURL() {
        $pageURL = '';
        // if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
        //$pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }



}
?>
