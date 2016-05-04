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
    return $this->searchData(array('getMsgType' => 'text','getContent' => $Content) ,array(), 'wechat_menu_event');
  }

  public function subscribeField(){
    return $this->searchData(array('getEvent' => 'subscribe','getMsgType' => 'event') ,array(), 'wechat_menu_event');
  }

  public function clickField($EventKey){
    return $this->searchData(array('getEvent' => 'click', 'getMsgType' => 'event', 'getEventKey' => $EventKey) ,array(), 'wechat_menu_event');
  }

  public function getmenus(){
    return $this->searchData(array() ,array('mOrder', 'subOrder', 'menuName', 'eventtype', 'eventKey', 'eventUrl'), 'wechat_menu');
  }

  public function getmenusDb(){
    return $this->searchData(array() ,array('id', 'mOrder', 'subOrder', 'menuName', 'eventtype', 'eventKey', 'eventUrl'), 'wechat_menu');
  }

  public function addSubButton($mOrder){
    $count = $this->getCount(array('mOrder' => $mOrder), 'wechat_menu');
    $count = intval($count);
    if($count == '0')
      return false;
    if($count > '5')
      return false;
    if($id = $this->insertData(array('mOrder' => $mOrder, 'subOrder' => $count+1, 'menuName' => '新菜单', 'eventtype' => 'view', 'eventUrl' => 'http://'), 'wechat_menu'))
      return $id;
    return false;
  }

  public function addMButton(){
    $count = $this->getCount(array('subOrder' => '0'), 'wechat_menu');
    if($count >= 3)
      return false;
    if($id = $this->insertData(array('mOrder' => $count, 'subOrder' => '0', 'menuName' => '新菜单', 'eventtype' => 'view', 'eventUrl' => 'http://'), 'wechat_menu'))
      return $id;
    return false;
  }

  public function updateButton($id, $data = array()){
    $change = array(
      'eventKey' => '',
      'eventUrl' => '',
      'eventmedia_id' => '',
    );
    $this->updateData(array('id' => $id ), $change, 'wechat_menu');
  }

//deleteButton main start
  public function deleteButton($id){
    $info = $this->searchData(array('id' => $id), array('mOrder','subOrder'), 'wechat_menu');
    if(!isset($info[0]))
      return false;
    $info = $info[0];
    $this->deleteData(array('id' => $id), 'wechat_menu');
    $this->deleteData(array('menuId' => $id), 'wechat_menu_event');
    if($info['subOrder'] == '0'){
      $this->deleteButtonEvent($info['mOrder']);
      $this->deleteData(array('mOrder' => $info['mOrder']), 'wechat_menu');
      $this->decmOrder($info['mOrder']);
    }else{
      $this->decsubOrder($info['mOrder'], $info['subOrder']);
    }
    return true;
  }

  public function deleteButtonEvent($mOrder){
    $menuid = array();
    $ids = $this->searchData(array('mOrder' => $mOrder), array('id'), 'wechat_menu');
    foreach($ids as $x)
      $menuid[] = $x['id'];
    $db = $this->rebuilddb();
    $db->where('menuId', $menuid, 'IN');
    if($db->delete('wechat_menu_event'))
      return true;
    return false;
  }

  public function decsubOrder($mOrder, $subOrder){
    $db = $this->rebuilddb();
    $data = array(
      'subOrder' => $db->dec(),
    );
    $db->where('mOrder', $mOrder);
    $db->where('subOrder', $subOrder, ">");
    if($db->update('wechat_menu', $data))
      return true;
    return false;
  }

  public function decmOrder($mOrder){
    $db = $this->rebuilddb();
    $data = array(
      'mOrder' => $db->dec(),
    );
    $db->where('mOrder', $mOrder, ">");
    if($db->update('wechat_menu', $data))
      return true;
    return false;
  }

//deleteButton main end

  public function insertData($data, $table){
    $db = $this->rebuilddb();
    return $db->insert($table, $data);
  }

  public function insertsData($datas, $table){
    foreach($datas as $x){
      $this->insertData($x, $table);
    }
  }

  public function searchData(array $data=array() ,array $dataout=array(), $table, $limit = null){
    $db = $this->rebuilddb();
    foreach($data as $x => $x_val){
      $db->where($x,$x_val);
    }
    return $db->get($table, $limit ,$dataout);
  }

  public function updateData($data, $change, $table){
    $db = $this->rebuilddb();
    foreach($data as $x => $x_val){
      $db->where($x,$x_val);
    }
    if($db->update($table, $change))
      return true;
    return false;
  }

  public function deleteData($data, $table){
    $db = $this->rebuilddb();
    foreach($data as $x => $x_val){
      $db->where($x,$x_val);
    }
    if($db->delete($table))
      return true;
    return false;
  }

  public function getCount($data, $table){
    $db = $this->rebuilddb();
    foreach($data as $x => $x_val){
      $db->where($x,$x_val);
    }
    $stats = $db->getOne ($table, "count(*) as cnt");
    return $stats['cnt'];
  }

}
