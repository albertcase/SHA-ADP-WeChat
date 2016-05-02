<?php

namespace ADP\WechatBundle\Modals\Database;

class dataSql{
  private $_db;
  private $_container;

  public function __construct($container){
    $this->_db = $container->get('vendor.MysqliDb');
    $this->_container = $container;
  }

  public function rebuilddb(){
    return clone $this->_db;
  }

  public function systemLog($postStr, $fromUsername, $msgType){
    $db = $this->rebuilddb();
    $data = array(
      'msgType' => $msgType,
      'msgXml' => $postStr,
      'openid' => $fromUsername,
    );
    $db->insert('wechat_getmsglog', $data);
  }

  public function textField($Content){
    return searchData(array('getMsgType' => 'text','getContent' => $Content) ,array(), 'wechat_menu_event');
  }

  public function subscribeField(){
    return searchData(array('getEvent' => 'subscribe','getMsgType' => 'event') ,array(), 'wechat_menu_event');
  }

  public function clickField($EventKey){
    return searchData(array('getEvent' => 'click', 'getMsgType' => 'event', 'getEventKey' => $EventKey) ,array(), 'wechat_menu_event');
  }

  public function searchData(array $data=array() ,array $dataout=array(), $table, $limit = null){
    $db = $this->rebuilddb();
    foreach($data as $x => $x_val){
      $db->where($x,$x_val);
    }
    return $db->get($table, $limit ,$dataout);
  }

}
