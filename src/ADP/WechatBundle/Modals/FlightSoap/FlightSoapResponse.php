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

  public function startFlightSoap(){
    exec("nohup ".dirname(__FILE__)."/startFlightSoap.sh >>".dirname(__FILE__)."/startFlightSoap.log 2>&1 &");
  }

  public function teststartFlight(){
    while($this->ststus())
    {
      $this->pushSoap();
    }
  }

  public function addSoapJob($data){
    $this->_redis->rPush($this->prostr.$this->list, json_encode($data ,JSON_UNESCAPED_UNICODE));
  }

  public function runSoap($data){
    if(!isset($data['soapevent']))
      return false;
    if(isset($data['soapevent']) && method_exists($this, $data['soapevent'].'Request')){
      call_user_func_array(array($this, $data['soapevent'].'Request'), array($data));
    }
  }

  public function pushSoap(){
    $this->_redis->set($this->prostr.$this->changT, time());
    $key = $this->_redis->lPop($this->prostr.$this->list);
    $this->runSoap(json_decode($key, true));
    $this->_redis->delete($this->prostr.$this->changT);
  }

  public function ststus(){
    if($this->_redis->lSize($this->prostr.$this->list) > 0){
      return true;
    }else{
      return false;
    }
  }

  public function getfightinfo($data){
    require_once dirname(__FILE__).'/FlightSoap.php';
    $FlightSoap = new FlightSoap();
    $Soap = array(
      'soapfunction' => 'FlightInfo',
      'FlightInfo' => array(
        'ident' => $data['ident'],
        'howMany' => '1',
      ),
    );
    $result = $FlightSoap->SoapApi($Soap);
    if($result instanceof \SoapFault)
      return false;
    $flight = array();
    if(property_exists($result, 'FlightInfoResult')){
      if(property_exists($result->FlightInfoResult, 'flights')){
        $flight = array(
          'ident' => $result->FlightInfoResult->flights->ident,
          'filed_departuretime' => $result->FlightInfoResult->flights->filed_departuretime,
          'estimatedarrivaltime' => $result->FlightInfoResult->flights->estimatedarrivaltime,
          'destinationName' => $result->FlightInfoResult->flights->destinationName,
        );
      }
    }
    if(!$flight)
      return false;
    $Soap = array(
      'soapfunction' => 'AirlineFlightInfo',
      'AirlineFlightInfo' => array(
        'faFlightID' => $flight['ident'].'@'.$flight['filed_departuretime'],
      ),
    );
    $result2 = $FlightSoap->SoapApi($Soap);
    if($result2 instanceof \SoapFault)
      return false;
    $out = array();
    if(property_exists($result2, 'AirlineFlightInfoResult')){
      $out = array(
        'ident' => $flight['ident'],
        'filed_departuretime' => $flight['filed_departuretime'],
        'estimatedarrivaltime' => $flight['estimatedarrivaltime'],
        'destinationName' => $flight['destinationName'],
        'gate_orig' => $result2->AirlineFlightInfoResult->gate_orig,
        'terminal_orig' => $result2->AirlineFlightInfoResult->terminal_orig,
      );
    }
    return $out;
  }

  public function getlatestRequest($data){
    require_once dirname(__FILE__).'/../CustomMsg/customsResponse.php';
    $customsResponse = new \ADP\WechatBundle\Modals\CustomMsg\customsResponse();
    if($info = $this->getfightinfo($data)){
      $info['filed_departuretime_date'] = date('Y-m-d', $info['filed_departuretime']);
      $info['filed_departuretime_time'] = date('H:i:s', $info['filed_departuretime']);
      $info['estimatedarrivaltime_date'] = date('Y-m-d', $info['estimatedarrivaltime']);
      $info['estimatedarrivaltime_time'] = date('H:i:s', $info['estimatedarrivaltime']);
      $content =
"航班信息
航班号：{$info['ident']}
目的地：{$info['destinationName']}
候机楼：{$info['terminal_orig']}
候机大门：{$info['gate_orig']}
计划离港日期：{$info['filed_departuretime_date']}
计划离港时间：{$info['filed_departuretime_time']}
计划到达日期：{$info['estimatedarrivaltime_date']}
计划到达时间：{$info['estimatedarrivaltime_time']}";
    }else{
      $content = "对不起您查询的航班不存在。请检查您的航班号";
    }
    $msg = array(
      'msgtype' => 'text',
      'touser' => $data['OpenID'],
      'content' => $content
    );
    $customsResponse->addCustomMsg($msg);
    $customsResponse->sendCustomMsg();
  }




}
