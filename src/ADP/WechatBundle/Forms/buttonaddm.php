<?php
namespace ADP\WechatBundle\Forms;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Session\Session;

class buttonaddm extends FormRequest{

  public function rule(){
    return array(
      // 'menuName' => new Assert\NotBlank(),
      // 'eventtype' => '',
      // 'eventKey' => '',
      // 'eventUrl' => '',
      // 'MsgType' =>  '',
      // 'Content' => '',
      // 'newslist' => '',
    );
  }

  public function FormName(){
    return 'buttonaddm';
  }

  public function DoData(){
    if($this->Confirm()){
      return array('code' => '11' ,'msg' => 'your input error');
    }
    return $this->dealData();
  }

  public function dealData(){
    $dataSql = $this->container->get('my.dataSql');
    $count = $dataSql->getCount(array('subOrder' => '0'), 'wechat_menu');
    if($count >= 3)
      return array('code' => '8', 'msg' => 'the total menus less than 3');
    if(strlen($this->getdata['menuName']) > 8 )
      return array('code' => '18', 'msg' => 'the length of button name not more than 8');
    $button = $this->getbutton();
    $button['mOrder'] = $count+1;
    $button['subOrder'] = '0';
    if(!$id = $dataSql->insertData($button, 'wechat_menu'))
      return array('code' => '7', 'msg' => 'add menu error');
    $event = $this->getevents($id);
    if(count($event))
      $dataSql->addEvent($event);
    return array('code' => '10', 'msg' => 'add menu success');
  }

  public function getevents($id){
    $events = array();
    if(!isset($this->getdata['MsgType']))
      return $events;
    if($this->getdata['MsgType'] == 'text'){
      $MsgData = array(
        'Content' => $this->getdata['Content'],
      );
      $events['feedbacks'] = array(
        'menuId' => $id,
        'MsgType' => 'text',
        'MsgData' => json_encode($MsgData, JSON_UNESCAPED_UNICODE),
      );
      $events['getevent'] = array(
        'menuId' => $id,
        'getMsgType' => 'event',
        'getEvent' => 'click',
        'getEventKey' => $this->getdata['eventKey'],
        'MsgType' => 'text',
      );
      return $events;
    }
    if($this->getdata['MsgType'] == 'news'){
      $MsgData = array(
        'Articles' => json_decode($this->getdata['newslist'] ,true),
      );
      $events['feedbacks'] = array(
        'menuId' => $id,
        'MsgType' => 'news',
        'MsgData' => json_encode($MsgData, JSON_UNESCAPED_UNICODE),
      );
      $events['getevent'] = array(
        'menuId' => $id,
        'getMsgType' => 'event',
        'getEvent' => 'click',
        'getEventKey' => $this->getdata['eventKey'],
        'MsgType' => 'news',
      );
      return $events;
    }
    return $events;
  }

  public function getbutton(){
    $button = array();
    foreach($this->getdata as $x => $x_val){
      if($x_val){
        if($x == 'menuName' || $x == 'eventtype' || $x == 'eventKey' || $x == 'eventUrl')
          $button[$x] = $x_val;
      }
    }
    return $button;
  }

}
