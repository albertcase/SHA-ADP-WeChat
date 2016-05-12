<?php
namespace ADP\WechatBundle\Forms;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Session\Session;

class buttonaddm extends FormRequest{

  public function rule(){
    return array(
      'menuName' => new Assert\NotBlank(),
      'eventtype' => '',
      'eventKey' => '',
      'eventUrl' => '',
      'MsgType' =>  '',
      'Content' => '',
      'newslist' => '',
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
      return return array('code' => '8', 'msg' => 'the total menus less than 3');
    $button = $this->getbutton();
    $event = $this->getevents();
    insertData(array('mOrder' => $count, 'subOrder' => '0', 'menuName' => '新菜单', 'eventtype' => 'view', 'eventUrl' => 'http://'), 'wechat_menu'));
  }

  public function getevents(){
    $events = array();
    if($this->getdata['MsgType'] == 'text'){
      $events[0] = array(
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
