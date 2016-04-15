<?php

class ResponseBuilder {

    /**
     * @param $group Group
     * @return string
     */
    public function buildForwardToAdministratorsResponse(Group $group) {
        $response = "<Response>\n";
        $response .= "<Dial>\n";
        foreach ($group->getAdministrators() as $phone) {
            $response .= "<Number>$phone</Number>\n";
        }
        $response .= "</Dial>\n";
        $response .= "<Say>Sorry, nobody could be reached at this time. Please try again later.</Say>\n";
        $response .= "</Response>\n";
        return $response;
    }

    /**
     * @param $group Group
     * @param $Digits
     * @return string
     */
    public function buildDialOutgoingCallResponse(Group $group, $Digits) {
        $response = "<Response>\n";
        $response .= "<Dial";
        $response .= ' timeout="30"';
        $response .= ' callerId="' . $group->getPhone() . '"';
        $response .= ">$Digits</Dial>\n";
        $response .= "</Response>\n";
        return $response;
    }

    /**
     * @return string
     */
    public function buildInvalidDigitsResponse() {
        $response = "<Response>\n";
        $response .= "<Say>You must provide a valid 10-digit phone number to dial</Say>\n";
        $response .= "<Redirect>" . SCRIPT_URL . "</Redirect>\n";
        $response .= "</Response>\n";
        return $response;
    }

    /**
     * @return string
     */
    public function buildGatherDigitsResponse() {
        $response = "<Response>\n";
        $response .= "<Gather";
        $response .= ' action="' . SCRIPT_URL . '"';
        $response .= ' timeout="2"';
        $response .= ">\n";
        $response .= "<Say>Enter outgoing number.</Say>\n";
        $response .= "<Pause length=\"8\"/>\n";
        $response .= "</Gather>\n";
        $response .= "<Say>Sorry, I didn't get your input.</Say>\n";
        $response .= "<Redirect>" . SCRIPT_URL . "</Redirect>\n";
        $response .= "</Response>\n";
        return $response;
    }

    /**
     * @return string
     */
    public function buildRejectCallResponse() {
        $response = new SimpleXMLElement("<Response/>");
        $response->addChild('Reject')->addAttribute("reason", "busy");
        return $response->asXML();
    }

}
