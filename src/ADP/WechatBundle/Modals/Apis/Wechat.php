<?php

namespace ADP\WechatBundle\Modals\Apis;

use ADP\WechatBundle\Modals\Apis\WechatResponse;

class Wechat{

  public function valid($echoStr){
   if($this->checkSignature())
      return $echoStr;
  }

  private function checkSignature()
  {
    $signature = $_GET["signature"];
    $timestamp = $_GET["timestamp"];
    $nonce = $_GET["nonce"];
    $token = $this->_TOKEN;;
    $tmpArr = array($token, $timestamp, $nonce);
    sort($tmpArr, SORT_STRING);
    $tmpStr = implode( $tmpArr );
    $tmpStr = sha1( $tmpStr );

    if( $tmpStr == $signature ){
      return true;
    }else{
      return false;
    }
  }

  // response function *******************************************************
  public function responseMsg($postStr){
    if (!empty($postStr)){
      $WechatResponse = new WechatResponse($postStr);
      return $WechatResponse->msgResponse();
    }
    return "";
  }
// response function *******************************************************




}
