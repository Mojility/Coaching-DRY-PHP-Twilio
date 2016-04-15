<?php

class ResponseBuilder {

    private $response;

    public function __construct() {
        $this->response = new SimpleXMLElement('<Response/>');
    }

    /**
     * @param $group Group
     * @return string
     */
    public function buildForwardToAdministratorsResponse(Group $group) {
        $dialElement = $this->response->addChild('Dial');
        foreach ($group->getAdministrators() as $phone) {
            $dialElement->addChild('Number', $phone);
        }
        $this->response->addChild('Say', 'Sorry, nobody could be reached at this time. Please try again later.');
        return $this->responseAsXmlString();
    }

    /**
     * @param $group Group
     * @param $digits
     * @return string
     */
    public function buildDialOutgoingCallResponse(Group $group, $digits) {
        $dialElement = $this->response->addChild('Dial', $digits);
        $dialElement->addAttribute('timeout', 30);
        $dialElement->addAttribute('callerId', $group->getPhone());
        return $this->responseAsXmlString();
    }

    /**
     * @return string
     */
    public function buildInvalidDigitsResponse() {
        $this->response->addChild('Say', 'You must provide a valid 10-digit phone number to dial');
        $this->response->addChild('Redirect', SCRIPT_URL);
        return $this->responseAsXmlString();
    }

    /**
     * @return string
     */
    public function buildGatherDigitsResponse() {
        $gatherElement = $this->response->addChild('Gather');
        $gatherElement->addAttribute('action', SCRIPT_URL);
        $gatherElement->addAttribute('timeout', 2);

        $gatherElement->addChild('Say', 'Enter outgoing number.');

        $pauseElement = $gatherElement->addChild('Pause');
        $pauseElement->addAttribute('length', 8);

        $this->response->addChild('Say', 'Sorry, I didn\'t get your input.');
        $this->response->addChild('Redirect', SCRIPT_URL);

        return $this->responseAsXmlString();
    }

    /**
     * @return string
     */
    public function buildRejectCallResponse() {
        $this->response->addChild('Reject')->addAttribute("reason", "busy");
        return $this->responseAsXmlString();
    }

    /**
     * @return string
     */
    public function responseAsXmlString() {
        $responseXml = $this->response->asXML();
        return $responseXml;
    }

}
