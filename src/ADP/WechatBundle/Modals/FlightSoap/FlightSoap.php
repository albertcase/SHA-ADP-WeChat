<?php
namespace ADP\WechatBundle\Modals\FlightSoap;

class FlightSoap{

  public function FlightSoapService(){
   $part = array(
      'soap_version' => SOAP_1_1,
      'encoding' => 'utf-8',
      'cache_wsdl' => WSDL_CACHE_NONE,
      'trace' => true,
      'exceptions' => 0,
      'login' => 'dirkwang',
      'password' => '299992422c4a006a47860bd5ad81cebc4d1d0b81',
   );
   $client = new \SoapClient(dirname(__FILE__)."/FlightSoap.wsdl", $part);
   return $client;
 }

  public function SoapApi($data){
    if(!isset($data['soapfunction']))
      return false;
    $client = $this->FlightSoapService();
    if(isset($data['soapfunction']) && method_exists($this, $data['soapfunction'] . 'Request')){
      return call_user_func_array(array($this, $data['soapfunction'] . 'Request'), array($client, $data));
    }
    return false;
  }

  public function MetarRequest($client, $data){
    if(!$this->checkData(array('Metar'), $data))
      return false;
    if(!$this->checkData(array('airport'), $data['Metar']))
      return false;
    $request = array(
      'Metar' => array(
        'airport' => $data['Metar']['airport'],
      ),
    );
    return $client->__soapCall($data['soapfunction'], $request);
  }

  public function FlightInfoRequest($client, $data){
    if(!$this->checkData(array('FlightInfo'), $data))
      return false;
    if(!$this->checkData(array('ident','howMany'), $data['FlightInfo']))
      return false;
    $request = array(
      'FlightInfo' => array(
        'ident' => $data['FlightInfo']['ident'],
        'howMany' => $data['FlightInfo']['howMany'],
      ),
    );
    return $client->__soapCall($data['soapfunction'], $request);
  }

  public function AirlineFlightInfoRequest($client, $data){
    if(!$this->checkData(array('AirlineFlightInfo'), $data))
      return false;
    if(!$this->checkData(array('faFlightID'), $data['AirlineFlightInfo']))
      return false;
    $request = array(
      'AirlineFlightInfo' => array(
        'faFlightID' => $data['AirlineFlightInfo']['faFlightID'],
      ),
    );
    return $client->__soapCall($data['soapfunction'], $request);
  }

  public function AirportInfoRequest($client, $data){
    if(!$this->checkData(array('AirportInfo'), $data))
      return false;
    if(!$this->checkData(array('airportCode'), $data['AirportInfo']))
      return false;
    $request = array(
      'AirlineInfo' => array(
        'airportCode' => $data['AirportInfo']['airportCode'],
      ),
    );
    return $client->__soapCall($data['soapfunction'], $request);
  }

//subfunction
public function getallfunctions(){
  $client = $this->FlightSoapService();
  return $client->__getFunctions();
}

 public function checkData($stand, $data){
   $keys = array_keys($data);
   foreach($stand as $x){
     if(!in_array($x, $keys))
       return false;
   }
   return true;
 }

}

?>
