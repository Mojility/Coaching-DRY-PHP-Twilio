<?php

require_once("inc/globals.php");
require_once("inc/Group.php");

class GroupTest extends PHPUnit_Framework_TestCase {

    protected $group = null;

    function setUp() {
        $this->group = new Group();
    }

    function testGroupDefaultsToRejectMode() {
        $this->assertEquals(REJECT_MODE, $this->group->getMode());
    }

    function testGroupCanBeCreatedWithDifferentMode() {
        $g = new Group(FORWARD_MODE);
        $this->assertEquals(FORWARD_MODE, $g->getMode());
    }

    function testGroupHasAdministrator() {
        $this->assertTrue($this->group->isAdministrator(ADMIN_PHONE));
    }

}
