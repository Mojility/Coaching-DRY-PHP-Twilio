<?php
require_once("inc/globals.php");
require_once("inc/Group.php");
require_once("inc/ResponseBuilder.php");
require_once("inc/Dispatcher.php");

//$From = $_POST['From'];
//$From = ADMIN_PHONE;
$From = MEMBER_PHONE;

//$Digits = $_POST['Digits'];
//$Digits = "6135551212";
//$Digits = "48424";
$Digits = null;

$group = new Group();
$responseBuilder = new ResponseBuilder();
$dispatcher = new Dispatcher($responseBuilder);
echo $dispatcher->invoke($group, $From, $Digits);
