<?php
//include_once "system/libraries/Model.php";
class Friend  {

    private $gwt_class = "test.client.Friend";
    private $name = '';
    private $phoneNumber = '';
    private $birthday = '';

    function Friend() {
    // Call the Model constructor
       // parent::Model();
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getBirthday() {
        return $this->birthday;
    }

    public function setBirthday($birthday) {
        $this->birthday = $birthday;
    }

    public function getPhoneNumber() {
        return $this->phoneNumber;
    }

    public function setPhoneNumber($phoneNumber) {
        $this->phoneNumber = $phoneNumber;
    }

    public function getGwt_class() {
        return $this->gwt_class;
    }

}
?>
