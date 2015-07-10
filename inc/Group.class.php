<?php

define("FORWARD_MODE", "forward");
define("REJECT_MODE", "reject_busy");
define("ADMIN_PHONE", "+19055551212");
define("ADMIN2_PHONE", "+14165551212");
define("MEMBER_PHONE", "+17055551212");

class Group {

    protected $mode = null;

    public function __construct($mode = REJECT_MODE) {
        $this->mode = $mode;
    }

    public function getName() { return "Test Group"; }
    public function getMode() { return $this->mode; }
    public function getPhone() { return "+14085551212"; }

    public function isAdministrator($phone) {
        return in_array($phone, $this->getAdministrators());
    }

    public function getAdministrators() {
        return array(ADMIN_PHONE, ADMIN2_PHONE);
    }

}