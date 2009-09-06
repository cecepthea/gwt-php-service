<?php

require_once 'annotations/annotations.php';
require_once 'annotations/Secured.php';
require_once 'annotations/Decorated.php';

require_once 'application/controllers/Search.php';

/**
 * My hook for application, do check role and decorate page using Annotations
 *
 * @author Trieu Nguyen
 */
class ApplicationHook {

/**
 * CodeIgniter global
 *
 * @var string
 **/
    protected $CI;
    protected $LOGIN_URI = "";

    protected $controllerRequest;
    protected $controllerName = NULL;
    protected $controllerMethod = NULL;
    protected $reflectedController = NULL;
    public static $countMethodCall = 0;


    private function initHook() {
        try {
            $this->CI =& get_instance();
            if($this->LOGIN_URI == "") {
                $this->LOGIN_URI = base_url().'index.php?c=welcome&m=login&url_redirect=';
            }
        } catch (Exception $e) {
            echo "Page error:<br>";
            echo $e->getMessage();
        }


    }

    public function __construct() {
        $this->initHook();
        $this->CI->benchmark->mark('code_start');
    }

    function ApplicationHook() {
        $this->initHook();
    }

    /**
     *
     * @return boolean
     */
    protected  function isValidControllerRequest() {
        if($this->controllerName != NULL && $this->controllerMethod != NULL) {
            return  TRUE;
        }
        $tokens = split("/index.php/", $_SERVER["REQUEST_URI"]);
        if(sizeof($tokens)>=2 ) {
            $routeTokens =  split("/", $tokens[1]);
            if(sizeof($routeTokens)>=2) {
                $this->controllerName = $routeTokens[0];
                $this->controllerMethod = $routeTokens[1];
                $this->controllerRequest = $tokens[1];
                return  TRUE;
            }
            else if(sizeof($routeTokens)===1 && strlen($routeTokens[0])>0 ) {
                    $this->controllerName = $routeTokens[0];
                    $this->controllerMethod = "index";
                    $this->controllerRequest = $tokens[1];
                    return  TRUE;
                }
        }
        return FALSE;
    }

    /**
     *
     * @return ReflectionAnnotatedMethod
     */
    protected function getReflectedController() {
        if($this->reflectedController == NULL) {
            try {
                $this->reflectedController = new ReflectionAnnotatedMethod($this->controllerName,$this->controllerMethod);
            } catch (ReflectionException $e) {
                //echo "Request to function does not exist";
            }
        }
        return $this->reflectedController;
    }




    public function checkRole() {
        if($this->isValidControllerRequest() ) {
            $reflection = $this->getReflectedController();
            if($this->CI->redux_auth->logged_in() == FALSE && $reflection->hasAnnotation('Secured')) {
                $annotation = $reflection->getAnnotation('Secured');
                //TODO
                redirect($this->LOGIN_URI .$this->controllerRequest);
            }
        }
    }

    public function decoratePage() {
        if($this->isValidControllerRequest()) {
            $reflection =  $this->getReflectedController();
            if($reflection->hasAnnotation('Decorated')) {
                $data = array(
                    'page_title' => $this->CI->page_decorator->getPageTitle(),
                    'meta_tags' => $this->CI->page_decorator->getPageMetaTags(),
                    'page_header' =>  $this->CI->load->view("decorator/header", '', TRUE),
                    'page_body' => $this->CI->output->get_output(),
                    'page_footer' => $this->CI->load->view("decorator/footer", '', TRUE)
                );
                echo $this->CI->load->view("decorator/page_template",$data,TRUE);

                $this->CI->benchmark->mark('code_end');
                echo $this->CI->benchmark->elapsed_time('code_start', 'code_end');
                return;
            }
        }
        echo $this->CI->output->get_output();
        $this->CI->benchmark->mark('code_end');
        echo "<br><b>Rendering time: ".$this->CI->benchmark->elapsed_time('code_start', 'code_end')."</b><br>";
    }
}
?>
