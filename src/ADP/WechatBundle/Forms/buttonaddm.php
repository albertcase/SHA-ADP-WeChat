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
      $events[0] = array(
        'menuId' => $id,
        'getMsgType' => 'event',
        'getEvent' => 'click',
        'getEventKey' => $this->getdata['eventKey'],
        'MsgType' => 'text',
        'Content' => $this->getdata['Content'],
      );
      return $events;
    }
    if($this->getdata['MsgType'] == 'news'){
      $newslist = json_decode($this->getdata['newslist'] ,true);
      foreach($newslist as $x=>$_val){
        $newslist[$x]['menuId'] = $id;
        $newslist[$x]['getMsgType'] = 'event';
        $newslist[$x]['getEvent'] = 'click';
        $newslist[$x]['getEventKey'] = $this->getdata['eventKey'];
        $newslist[$x]['MsgType'] = 'news';
      }
      return $newslist;
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
