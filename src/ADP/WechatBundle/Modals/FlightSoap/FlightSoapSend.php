<?php
namespace ADP\WechatBundle\Modals\FlightSoap;

require_once dirname(__FILE__).'/FlightSoapResponse.php';

$FlightSoapResponse = new FlightSoapResponse();
while($FlightSoapResponse->ststus())
{
  $FlightSoapResponse->pushMsg();
}

?>
