<?php
namespace ADP\WechatBundle\Modals\FlightSoap;

require_once dirname(__FILE__).'/FlightSoapResponse.php';

$FlightSoapResponse = new \ADP\WechatBundle\Modals\FlightSoap\FlightSoapResponse();
while($FlightSoapResponse->ststus())
{
  $FlightSoapResponse->pushSoap();
}

?>
