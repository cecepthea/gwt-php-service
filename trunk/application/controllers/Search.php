<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of Search
 *
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
}




?>
