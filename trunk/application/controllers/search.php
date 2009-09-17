<?php

/**
 * Description of Search
 * @property CI_Loader $load
 * @author Trieu Nguyen
 */


class search extends Controller {
    public function __construct() {
        parent::Controller();
    }


    /** @Secured(role = "admin", level = 2) */
    public function listDRDStaff() {
        if($this->redux_auth->logged_in() == TRUE) {
            echo "loged";
        }
        else {
            echo "Not loged";
        }
    }

    /** @Secured */
    public function test() {
        echo "test";
    }


    /** @Decorated */
    public function test_form() {
        $this->load->view("form/simple_form",null);
    }

    /** @Decorated */
    public function test_decorator() {
        $this->page_decorator->setPageMetaTag("description", "Home page");
        $this->page_decorator->setPageMetaTag("keywords", "Home page");
        $this->page_decorator->setPageMetaTag("author", "Trieu Nguyen");
        $this->page_decorator->setPageTitle("test_decorator");

        $data = array("test2" => false);

        $this->load->view("decorator/body",$data);
    }

    /** @Decorated */
    public function test_decorator2() {
        $this->page_decorator->setPageMetaTag("description", "Home page");
        $this->page_decorator->setPageMetaTag("keywords", "Home page");
        $this->page_decorator->setPageMetaTag("author", "Trieu Nguyen");
        $this->page_decorator->setPageTitle("test_decorator2");

        $data = array("test2" => true);




        $this->load->view("decorator/body",$data);
    }
}




?>
