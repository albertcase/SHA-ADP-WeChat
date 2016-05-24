<?php
namespace ADP\WechatBundle\Modals\FlightSoap;

class FlightSoapResponse{

  private $_redis;
  private $prostr = 'adp:fsoap:';
  private $list = 'list';
  private $changT = 'changT';
  private $outtime = '100';

  public function __construct(){
    $this->_redis = new \Redis();
    $this->_redis->connect('127.0.0.1', '6379');
    $this->closeFlightSoap();
  }

  public function closeFlightSoap(){
    if($time = $this->_redis->get($this->prostr.$this->changT)){
      if((time() - $time) > $this->outtime){
        exec("nohup ".dirname(__FILE__)."/closeFlightSoap.sh >>".dirname(__FILE__)."/closeFlightSoap.log 2>&1 &");
        $this->_redis->delete($this->prostr.$this->changT);
      }
    }
  }

  public function runSoap($data){
    if(!isset($data['soapevent']))
      return false;
    if(isset($data['soapevent']) && method_exists($this, $data['soapevent'].'Request')){
      call_user_func_array(array($this, $data['soapevent'].'Request'), array($data));
    }
  }

  public function getlatestRequest($data){
    $FlightSoap = new FlightSoap();
    $Soap = array(
      'soapfunction' => 'FlightInfo',
      'FlightInfo' => array(
        'ident' => $data['ident'],
        'howMany' => '1',
      ),
    );
    return $FlightSoap->SoapApi($Soap);
  }




}
