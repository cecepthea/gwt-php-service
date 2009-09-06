<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of Search
 * @property CI_Loader $load
 * @author Trieu Nguyen
 */


class Search extends Controller {
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



    public function test2() {
        echo "test2";
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
