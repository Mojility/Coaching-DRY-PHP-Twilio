<?php

require_once("./inc/globals.php");
require_once("./inc/ResponseBuilder.php");
require_once("./inc/Dispatcher.php");

class DispatcherTest extends PHPUnit_Framework_TestCase {

    protected $dispatcher = null;
    protected $responseBuilder = null;

    function setUp() {
        $this->responseBuilder = new ResponseBuilder();
        $this->dispatcher = new Dispatcher($this->responseBuilder);
    }

    function testResponseBuilderExists() {
        $this->assertNotNull($this->dispatcher);
    }

    function testEmptyRequestRejectingGroup() {
        $group = new Group(REJECT_MODE);
        $response = $this->dispatcher->invoke($group, null, null);
        $this->assertXmlStringEqualsXmlString(
            "<Response>
                <Reject reason='busy'/>
             </Response>",
            $response
        );
    }

    function testEmptyRequestForwardingGroup() {
        $group = new Group(FORWARD_MODE);
        $response = $this->dispatcher->invoke($group, null, null);
        $this->assertXmlStringEqualsXmlString(
            "<Response>
                <Dial>
                    <Number>+19055551212</Number>
                    <Number>+14165551212</Number>
                </Dial>
                <Say>Sorry, nobody could be reached at this time. Please try again later.</Say>
             </Response>",
            $response
        );
    }

    function testFromAdminPhoneNoDigits() {
        $group = new Group(FORWARD_MODE);
        $response = $this->dispatcher->invoke($group, ADMIN_PHONE, null);
        $this->assertXmlStringEqualsXmlString(
            "<Response>
                <Gather action='".SCRIPT_URL."' timeout='2'>
                    <Say>Enter outgoing number.</Say>
                    <Pause length='8'/>
                </Gather>
                <Say>Sorry, I didn't get your input.</Say>
                <Redirect>".SCRIPT_URL."</Redirect>
             </Response>",
            $response
        );
    }

    function testFromAdminPhoneInvalidDigits() {
        $group = new Group(FORWARD_MODE);
        $response = $this->dispatcher->invoke($group, ADMIN_PHONE, "1234");
        $this->assertXmlStringEqualsXmlString(
            "<Response>
                <Say>You must provide a valid 10-digit phone number to dial</Say>
                <Redirect>".SCRIPT_URL."</Redirect>
             </Response>",
            $response
        );
    }

    function testFromAdminPhoneValidDigits() {
        $group = new Group(FORWARD_MODE);
        $response = $this->dispatcher->invoke($group, ADMIN_PHONE, "7055551212");
        $this->assertXmlStringEqualsXmlString(
            "<Response>
                <Dial timeout='30' callerId='+14085551212'>7055551212</Dial>
             </Response>",
            $response
        );
    }

}
