<?php

/**
 * Description of home
 *
 * @property page_decorator $page_decorator
 *
 * @author Trieu Nguyen. Email: tantrieuf31@gmail.com
 */
class home extends Controller {
    public function __construct() {
        parent::Controller();
    }

     /**
      * @Secured
      * @Decorated
      */
    public function index() {
        $this->page_decorator->setPageMetaTag("description", "Home page");
        $this->page_decorator->setPageMetaTag("keywords", "Home page");
        $this->page_decorator->setPageMetaTag("author", "Trieu Nguyen");
        $this->page_decorator->setPageTitle("Home page DRD");

        $data = array("test2" => true);
        $this->load->view("decorator/body",$data);
    }
}
?>
