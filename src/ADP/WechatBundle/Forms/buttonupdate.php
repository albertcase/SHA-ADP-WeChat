<?php
namespace ADP\WechatBundle\Forms;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Session\Session;

class buttonupdate extends FormRequest{

  public function rule(){
    return array(
      // 'id' => new Assert\NotBlank(),
      // 'menuName' => new Assert\NotBlank(),
      // 'eventtype' => new Assert\NotBlank(),
      // 'eventKey' => '',
      // 'eventUrl' => '',
      // 'MsgType' =>  new Assert\NotBlank(),
      // 'Content' => '',
      // 'newslist' => '',
    );
  }

  public function FormName(){
    return 'buttonupdate';
  }

  public function DoData(){
    if($this->Confirm()){
      return array('code' => '11' ,'msg' => 'your input error');
    }
    return $this->dealData();
  }

  public function dealData(){
    $dataSql = $this->container->get('my.dataSql');
    $button = $this->getbutton();
    $event = $this->getevents();
    if($dataSql->updateButton($this->getdata['id'], $button, $event)){
      return array('code' => '10', 'msg' => 'update button success');
    }
    return array('code' => '9', 'msg' => 'update button error');
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

  public function getevents(){
    $events = array();
    if(!isset($this->getdata['MsgType']))
      return $events;
    if($this->getdata['MsgType'] == 'text'){
      $events[0] = array(
        'menuId' => $this->getdata['id'],
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
        $newslist[$x]['menuId'] = $this->getdata['id'];
        $newslist[$x]['getMsgType'] = 'event';
        $newslist[$x]['getEvent'] = 'click';
        $newslist[$x]['getEventKey'] = $this->getdata['eventKey'];
        $newslist[$x]['MsgType'] = 'news';
      }
      return $newslist;
    }
    return $events;
  }

}
