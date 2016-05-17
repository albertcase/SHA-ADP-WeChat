<?php
namespace ADP\WechatBundle\Forms;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Session\Session;

class keywordadd extends FormRequest{

  public function rule(){
    return array(
      // 'getMsgType' => new Assert\NotBlank(),
      // 'getContent' => new Assert\NotBlank(),
      // 'MsgType' =>  '',
      // 'Content' => '',
      // 'newslist' => '',
    );
  }

  public function FormName(){
    return 'keywordadd';
  }

  public function DoData(){
    if($this->Confirm()){
      return array('code' => '11' ,'msg' => 'your input error');
    }
    return $this->dealData();
  }

  public function dealData(){
    $dataSql = $this->container->get('my.dataSql');
    if($dataSql->getCount(array('getContent' => $this->getdata['getContent']), 'wechat_menu_event'))
      return array('code' => '8', 'msg' => 'this keyword already exists');
    $menuId = 'key'.uniqid();
    $event = $this->getevents($menuId);
    if(count($event))
      $dataSql->addEvent($event);
    return array('code' => '10', 'msg' => 'add menu success');
  }


    public function getevents($menuId){
      $events = array();
      if(!isset($this->getdata['MsgType']))
        return $events;
      if($this->getdata['MsgType'] == 'text'){
        $events[0] = array(
          'menuId' => $menuId,
          'getMsgType' => 'text',
          'getContent' => $this->getdata['getContent'],
          'MsgType' => 'text',
          'Content' => $this->getdata['Content'],
        );
        return $events;
      }
      if($this->getdata['MsgType'] == 'news'){
        $newslist = json_decode($this->getdata['newslist'] ,true);
        foreach($newslist as $x=>$_val){
          $newslist[$x]['menuId'] = $menuId;
          $newslist[$x]['getContent'] = $this->getdata['getContent'];
          $newslist[$x]['getMsgType'] = 'text';
          $newslist[$x]['MsgType'] = 'news';
        }
        return $newslist;
      }
      return $events;
    }


}
