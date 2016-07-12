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
    preg_match_all("/^([A-Za-z]{1,4})([0-9]{1,8})$/", $data['ident'],$pident, PREG_SET_ORDER);
    $Soap = array(
      'soapfunction' => 'FlightInfo',
      'FlightInfo' => array(
        'ident' => $pident['0']['1'].ltrim($pident['0']['2'], "0"),
        'howMany' => '3',
      ),
    );
    $result = $FlightSoap->SoapApi($Soap);
    if($result instanceof \SoapFault)
      return false;
    $flight = array();
    if(property_exists($result, 'FlightInfoResult')){
      if(property_exists($result->FlightInfoResult, 'flights')){
        if(isset($result->FlightInfoResult->flights->ident)){
          $flight = array(
            'ident' => $result->FlightInfoResult->flights->ident,
            'filed_time' => $result->FlightInfoResult->flights->filed_time,
            'filed_ete' => $result->FlightInfoResult->flights->filed_ete,
            'filed_departuretime' => $result->FlightInfoResult->flights->filed_departuretime,
            'estimatedarrivaltime' => $result->FlightInfoResult->flights->estimatedarrivaltime,
            'originName' => $result->FlightInfoResult->flights->originName,
            'destinationName' => $result->FlightInfoResult->flights->destinationName,
            'origin' => $result->FlightInfoResult->flights->origin,
            'destination' => $result->FlightInfoResult->flights->destination,
          );
        }else{
          foreach($result->FlightInfoResult->flights as $x){
            if(time() < $x->filed_departuretime){
              $flight = array(
                'ident' => $x->ident,
                'filed_time' => $x->filed_time,
                'filed_ete' => $x->filed_ete,
                'filed_departuretime' => $x->filed_departuretime,
                'estimatedarrivaltime' => $x->estimatedarrivaltime,
                'originName' => $x->originName,
                'destinationName' => $x->destinationName,
                'origin' => $x->origin,
                'destination' => $x->destination,
              );
            }
          }
        }
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
        'originName' => $flight['originName'],
        'gate_orig' => $result2->AirlineFlightInfoResult->gate_orig,
        'origin' =>  $flight['origin'],
        'destination' =>  $flight['destination'],
        'terminal_orig' => $result2->AirlineFlightInfoResult->terminal_orig,
      );
    }
    return $out;
  }

  public function getlatestRequest($data){
    require_once dirname(__FILE__).'/../CustomMsg/customsResponse.php';
    $customsResponse = new \ADP\WechatBundle\Modals\CustomMsg\customsResponse();
    if($info = $this->getfightinfo($data)){
      $origin = $this->getLocaltime($info['origin'], $info['filed_departuretime']);
      $departuretime = $this->getLocaltime($info['destination'], $info['estimatedarrivaltime']);
      foreach($info as $x => $_val){
        if(!$_val)
          $info[$x] = "暂未提供";
      }
      $content =
"航班信息
航班号：{$info['ident']}
始发地：{$info['originName']}
目的地：{$info['destinationName']}
候机楼：{$info['terminal_orig']}
候机大门：{$info['gate_orig']}
计划离港日期：{$origin['ldate']}
计划离港时间：{$origin['ltime']}
计划到达日期：{$departuretime['ldate']}
计划到达时间：{$departuretime['ltime']}

该信息由第三方平台提供, 只提供最近航班信息, 以上时间均为机场当地时间。";
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

  public function getLocaltime($airportCode, $timestrmp){
    require_once dirname(__FILE__).'/FlightSoap.php';
    $FlightSoap = new FlightSoap();
    $data = array();
    $data['ident'] = $request->get('ident');
    $Soap = array(
      'soapfunction' => 'AirportInfo',
      'AirportInfo' => array(
        'airportCode' => $airportCode,
      ),
    );
    $result = $FlightSoap->SoapApi($Soap);
    $out = array();
    $date = new \DateTime();
    $date->setTimestamp($timestrmp);
    $date->setTimezone(new \DateTimeZone('Asia/Shanghai'));
    $out['bjdate'] = $date->format('Y-m-d');
    $out['bjtime'] = $date->format('H:i:s');
    if(property_exists($result, 'AirportInfoResult')){
      $date->setTimezone(new \DateTimeZone(ltrim($result->AirportInfoResult->timezone, ":")));
      $out['ldate'] = $date->format('Y-m-d');
      $out['ltime'] = $date->format('H:i:s');
      return $out;
    }
    $out['ldate'] = "获取不到当地时间";
    $out['ltime'] = "获取不到当地时间";
    return $out;
  }




}
