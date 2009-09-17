<?php

require_once 'annotations/annotations.php';
require_once 'annotations/Secured.php';
require_once 'annotations/Decorated.php';



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
            $this->beginRequest();
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

        $tokens = split("/index.php/", current_url());
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
        else if(strrpos(current_url(), "/index.php")>0) {
                $this->controllerName = "home";
                $this->controllerMethod = "index";
                $this->controllerRequest = "";
                return  TRUE;
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
                ApplicationHook::logError($this->controllerName.".".$this->controllerMethod." is NOT reflected!");
                return NULL;
            }
        }
        return $this->reflectedController;
    }

    public function checkRole() {
        if($this->isValidControllerRequest() ) {
            $reflection = $this->getReflectedController();
            if($reflection !=NULL ) {
                if($reflection->hasAnnotation('Secured') && $this->CI->redux_auth->logged_in() == FALSE) {

                    ApplicationHook::logInfo("-> CheckRole for ".$this->controllerName.".".$this->controllerMethod);

                    $annotation = $reflection->getAnnotation('Secured');
                    //TODO
                    redirect($this->LOGIN_URI .$this->controllerRequest);
                }
            }
        }
    }

    public function decoratePage() {
        if($this->isValidControllerRequest()) {
            $reflection =  $this->getReflectedController();
            if($reflection !=NULL ) {
                if($reflection->hasAnnotation('Decorated')) {

                    ApplicationHook::logInfo("-> Decorate page for ".$this->controllerName.".".$this->controllerMethod);

                    $this->CI->lang->load('fields','vietnamese');
                    ApplicationHook::logInfo(lang('news_events'));

                    $data = array(
                        'page_title' => $this->CI->page_decorator->getPageTitle(),
                        'meta_tags' => $this->CI->page_decorator->getPageMetaTags(),
                        'page_header' => $this->decorateHeader(),
                        'left_navigation' => $this->decorateLeftNavigation(),
                        'page_content' => $this->decoratePageContent(),
                        'page_footer' => $this->decorateFooter()
                    );
                    $data['controller'] = $this->controllerName."/".$this->controllerMethod;
                    //test response time for benchmarking
                    $data['page_respone_time'] =  $this->endAndGetResponseTime();
                    echo trim( $this->CI->load->view("decorator/page_template",$data,TRUE) );
                    return;
                }
            }
        }
        echo $this->CI->output->get_output();
        $this->CI->benchmark->mark('code_end');
        echo "<br><b>Rendering time: ".$this->CI->benchmark->elapsed_time('code_start', 'code_end')."</b><br>";
    }

    protected function decorateHeader() {
        return trim( $this->CI->load->view("decorator/header", '', TRUE) );
    }

    protected function decorateLeftNavigation() {
        $data = array(
            'is_login' => $this->CI->redux_auth->logged_in()
        );
        return trim( $this->CI->load->view("decorator/left_navigation", $data, TRUE) );
    }

    protected function decoratePageContent() {
        $pagintor_view = "";
        if($this->controllerName == "job_seeker" || $this->controllerName == "employer") {
            $tem_data = array('controllerName'=>$this->controllerName);
            $pagintor_view =  $this->CI->load->view("global_view/question_url",$tem_data,TRUE);
        }
        return trim( $this->CI->output->get_output() ).$pagintor_view;
    }

    protected function decorateFooter() {
        return trim( $this->CI->load->view("decorator/footer", '', TRUE) );
    }

    protected function beginRequest() {
        $this->CI->benchmark->mark('code_start');
    }

    protected function endAndGetResponseTime() {
        $this->CI->benchmark->mark('code_end');
        return "<br><b>Rendering time: ".$this->CI->benchmark->elapsed_time('code_start', 'code_end')."</b><br>";
    }

    public static function logInfo($text) {
        $ci = &get_instance();
        $ci->load->library('firephp');
        $ci->firephp->info("  ".$text);
    }

    public static function logError($text) {
        $ci = &get_instance();
        $ci->load->library('firephp');
        $ci->firephp->error("  ".$text);
    }

    public static function log($text) {
        $ci = &get_instance();
        $ci->load->library('firephp');
        $ci->firephp->log("".$text);
    }
}
?>
