<?php

/**
 * Description of admin_panel
 *
 * @property page_decorator $page_decorator
 *
 * @author Trieu Nguyen. Email: tantrieuf31@gmail.com
 */
class admin_panel extends Controller {
    public function __construct() {
        parent::Controller();
    }


    /**
     * @Decorated
     */
    public function index() {
        $data = array();
        $this->load->view("decorator/body",$data);
    }

    /**
     * EndsWith
     * Tests whether a text ends with the given
     * string or not.
     *
     * @param     string
     * @param     string
     * @return    bool
     */
    private function EndsWith($Haystack, $Needle) {
        return strrpos($Haystack, $Needle) === strlen($Haystack)-strlen($Needle);
    }
}
?>
