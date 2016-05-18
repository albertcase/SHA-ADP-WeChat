<?php
namespace ADP\WechatBundle\Forms;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Session\Session;

class keywordupdate extends FormRequest{

  public function rule(){
    return array(
      'menuId' => new Assert\NotBlank(),
      // 'getMsgType' => new Assert\NotBlank(),
      // 'getContent' => new Assert\NotBlank(),
      // 'MsgType' =>  '',
      // 'Content' => '',
      // 'newslist' => '',
    );
  }

  public function FormName(){
    return 'keywordupdate';
  }

  public function DoData(){
    if($this->Confirm()){
      return array('code' => '11' ,'msg' => 'your input error');
    }
    return $this->dealData();
  }

  public function dealData(){
    $dataSql = $this->container->get('my.dataSql');
    $dataSql = $this->container->get('my.dataSql');
    if($dataSql->getCount(array('getContent' => $this->getdata['getContent']), 'wechat_menu_event'))
      return array('code' => '8', 'msg' => 'this keyword already exists');
    if($info = $dataSql->getEvents($this->getdata['menuId'])){
      return array('code' => '10', 'info' => $info,'msg' => 'delete success');
    }
    return array('code' => '9', 'msg' => 'delete errors');
  }
}
