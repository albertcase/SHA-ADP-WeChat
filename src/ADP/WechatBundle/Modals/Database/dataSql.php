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

  public function addSubButton($mOrder){//added sub button
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

  public function addMButton(){//added main button
    $count = $this->getCount(array('subOrder' => '0'), 'wechat_menu');
    if($count >= 3)
      return false;
    if($id = $this->insertData(array('mOrder' => $count, 'subOrder' => '0', 'menuName' => '新菜单', 'eventtype' => 'view', 'eventUrl' => 'http://'), 'wechat_menu'))
      return $id;
    return false;
  }

  public function updateButton($id, $button = array(), $event = array()){//set old button
    $change = array(
      'eventKey' => '',
      'eventUrl' => '',
      'eventmedia_id' => '',
    );
    $this->updateData(array('id' => $id ), $change, 'wechat_menu');
    $this->updateData(array('id' => $id ), $button, 'wechat_menu');
    $this->updateEvent(array('menuId' => $id), $event);
    return true;
  }

  public function getEvent($data){//get Event
    $result = array();
    $out = $this->searchData($data, array(), 'wechat_menu_event');
    if($out && isset($out[0])){
      if(count($out) == '1'){
        $result = $out['0'];
      }else{
        $result['getMsgType'] = $out[0]['getMsgType'];
        $result['getContent'] = $out[0]['getContent'];
        $result['getEvent'] = $out[0]['getEvent'];
        $result['getEventKey'] = $out[0]['getEventKey'];
        $result['getTicket'] = $out[0]['getTicket'];
        $result['alldata'] = $out;
      }
      return $result;
    }
    return false;
  }

  public function updateEvent($data, $change = array()){
    $this->deleteData($data, 'wechat_menu_event');
    if($change)
      $this->insertsData($change, 'wechat_menu_event');
    return true;
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
//admin start
  public function createwechatAdmin($data){
    $data['password'] = md5($data['password'].'185');
    return $this->insertData($data, 'wechat_admin');
  }

  public function changepassword($data, $change){
    $data['password'] = md5($data['password'].'185');
    if($this->getCount($data, 'wechat_admin')){
      $change['password'] = md5($change['password'].'185');
      return $this->updateData($data, $change, 'wechat_admin');
    }
    return false;
  }

  public function comfirmAdmin($data){
    $data['password'] = md5($data['password'].'185');
    if($this->getCount($data, 'wechat_admin')){
      $this->updateData($data, array('latestTime' => date('Y-m-d H:i:s' ,strtotime("now"))), 'wechat_admin');
      return true;
    }
    return false;
  }
//admin end
// adp_article
  public function createArticle($data){
    $data['pageid'] = uniqid();
    if($this->insertData($data, 'adp_article'))
      return $data['pageid'];
    return false;
  }

  public function updateArticle($data, $change){
    $change['latestTime'] = date('Y-m-d H:i:s' ,strtotime("now"));
    return $this->updateData($data, $change, 'adp_article');
  }

  public function getArticle($data){
    return $this->searchData($data , array(), 'adp_article');
  }

  public function delArticle($data){
    return $this->deleteData($data, 'adp_article');
  }

  public function getArticlelist($data){
    return $this->searchData($data , array('pageid', 'pagename', 'pagetitle', 'submiter', 'edittime'), 'adp_article');
  }

// adp_article
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
