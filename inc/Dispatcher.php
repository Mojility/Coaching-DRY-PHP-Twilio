<?php

class Dispatcher {

    protected $responseBuilder = null;

    function __construct(ResponseBuilder $responseBuilder) {
        $this->responseBuilder = $responseBuilder;
    }

    /**
     * @param $group
     * @param $From
     * @param $Digits
     */
    function invoke($group, $From, $Digits) {
        if (FORWARD_MODE == $group->getMode()) {
            if (!$group->isAdministrator($From)) {
                return $this->responseBuilder->buildForwardToAdministratorsResponse($group);
            } else {
                if ($Digits) {
                    if (10 == strlen($Digits)) {
                        return $this->responseBuilder->buildDialOutgoingCallResponse($group, $Digits);
                    } else {
                        return $this->responseBuilder->buildInvalidDigitsResponse();
                    }
                } else {
                    return $this->responseBuilder->buildGatherDigitsResponse();
                }
            }
        } else {
            return $this->responseBuilder->buildRejectCallResponse();
        }
    }

}
