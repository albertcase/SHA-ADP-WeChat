<?php

namespace ADP\WechatBundle\Modals\Apis;
use ADP\WechatBundle\Modals\Database\dataSql;
use ADP\WechatBundle\Modals\Apis\WechatMsg;

class WechatResponse{

  private $postStr = null;
  private $postObj = null;
  private $fromUsername = null;
  private $toUsername = null;
  private $msgType = null;
  private $dataSql;

  public function __construct($postStr){
    $this->postStr = $postStr;
    $this->postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
    $this->msgType = strtolower($this->postObj->MsgType);
    $this->fromUsername = trim($this->postObj->FromUserName);
    $this->toUsername = $this->postObj->ToUserName;
    $this->dataSql = new dataSql();
  }

  public function msgResponse($rs){
    if(!isset($rs[0]['MsgType']))
      return false;
    $WechatMsg = new WechatMsg($this->fromUsername, $this->toUsername);
    return $WechatMsg->sendMsgxml($data);
  }

//request functions start
  public function textRequest(){
    $rs = $this->dataSql->textField($this->postObj->Content);
    if(is_array($rs) && count($rs)> 0 ){
      return $this->msgResponse($rs);
    }
    return "";
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
    return "";
  }

  public function linkRequest(){
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

//event function start
public function subscribeEvent(){
  $rs = $this->dataSql->subscribeField();
  if(is_array($rs) && count($rs)> 0 ){
    return $this->msgResponse($rs);
  }
  return "";
}

public function scanEvent(){
  return "";
}

public function locationEvent(){
  return "";
}

public function clickEvent(){
  $eventKey = $this->postObj->EventKey;
  $rs = $this->dataSql->clickField($EventKey);
  if(is_array($rs) && count($rs)> 0 ){
    return $this->msgResponse($rs);
  }
  return "";
}

public function viewEvent(){
  return "";
}

//event function end
  public function systemLog(){
    $this->dataSql->systemLog($this->postStr, $this->fromUsername, $this->msgType);
  }

  public function comfirmkeycode($msgType){

  }



}
