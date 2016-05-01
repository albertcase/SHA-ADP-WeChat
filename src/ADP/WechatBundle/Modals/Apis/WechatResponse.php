<?php

namespace ADP\WechatBundle\Modals\Apis;

class WechatResponse{

  private $postStr = null;
  private $postObj = null;
  private $fromUsername = null;
  private $toUsername = null;
  private $msgType = null;

  public function __construct($postStr){
    $this->postStr = $postStr;
    $this->postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
    $this->msgType = strtolower($this->postObj->MsgType);
    $this->fromUsername = trim($this->postObj->FromUserName);
    $this->toUsername = $this->postObj->ToUserName;
  }

  public function msgResponse(){
    if(method_exists($this, $this->msgType.'Request')){
      return call_user_func_array(array($this, $msgType.'Request'), array());
    }
    return "";
  }

//request functions start
  public function textRequest(){
    $this->systemLog($this->postStr, $this->fromUsername,'text');
    $rs = $this->comfirmkeycode('text');
    if(!$rs){
      $rsLike = $this->comfirmkeycode2();
      if($rsLike){
        $rs = $rsLike;
      }
    }
    if(isset($rs[0]['msgtype']) && method_exists($this, strtolower($rs[0]['msgtype']).'Response')){
      return call_user_func_array(array($this, strtolower($rs[0]['msgtype']).'Response'), array($rs));
    }
  }

  public function imageRequest(){
    return "";
  }

  public function voiceRequest(){
    return "";
  }

  public function videoRequest(){
    return "";
  }

  public function shortvideoRequest(){
    return "";
  }

  public function locationRequest(){
    $this->systemLog($this->postStr, $this->fromUsername, 'location');
    //LBS
    $x = $this->postObj->Location_X;
    $y = $this->postObj->Location_Y;

    $baidu = file_get_contents("http://api.map.baidu.com/geoconv/v1/?coords={$y},{$x}&from=3&to=5&ak=Z5FOXZbjH3AEIukiiRTtD7Xy");
    $baidu = json_decode($baidu, true);

    $lat = $baidu['result'][0]['x'];
    $lng = $baidu['result'][0]['y'];

    $squares = $this->returnSquarePoint($lng,$lat,300000);
    $latbig = $squares['right-bottom']['lat'] > $squares['left-top']['lat'] ? $squares['right-bottom']['lat'] : $squares['left-top']['lat'];
    $latsmall = $squares['right-bottom']['lat'] > $squares['left-top']['lat'] ? $squares['left-top']['lat'] : $squares['right-bottom']['lat'];
    $lngbig = $squares['left-top']['lng'] > $squares['right-bottom']['lng'] ? $squares['left-top']['lng'] : $squares['right-bottom']['lng'];
    $lngsmall = $squares['left-top']['lng'] > $squares['right-bottom']['lng'] ? $squares['right-bottom']['lng'] : $squares['left-top']['lng'];

    $info_sql = "select * from `same_store` where lat<>0 and (lat between {$latsmall} and {$latbig}) and (lng between {$lngsmall} and {$lngbig})";
    $rs = Yii::app()->db->createCommand($info_sql)->queryAll();
    if(!$rs){
      return $this->sendMsgForText($this->fromUsername, $this->toUsername, time(), "text", '很抱歉，您的附近没有门店');
    }
    $datas = array();
    $data = array();
          for($i=0;$i<count($rs);$i++){
            $meter = $this->getDistance($lat,$lng,$rs[$i]['lat'],$rs[$i]['lng']);
            $meters = "(距离约" . $meter ."米)";
            $datas[$meter] = array('title'=>$rs[$i]['name'].$meters,'description'=>$rs[$i]['name'],'picUrl'=>Yii::app()->request->hostInfo.'/'.Yii::app()->request->baseUrl.'/'.$rs[$i]['picUrl'],'url'=>Yii::app()->request->hostInfo.'/site/store?id='.$rs[$i]['id']);
          }
    ksort($datas);
    $i=0;
    foreach($datas as $value){
      $data[$i] = $value;
      $i++;
    }
    return $this->sendMsgForNews($this->fromUsername, $this->toUsername, time(), $data);
  }

  public function linkRequest(){
    $this->systemLog($postStr,$fromUsername,$msgType);
    return "";
  }

  public function eventRequest(){
    $event = strtolower($this->postObj->Event);
    if(method_exists($this, $event.'Event')){
      return call_user_func_array(array($this, $event.'Event'), array());
    }
    return "";
  }
//request function end



}
