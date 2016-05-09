<?php
namespace ADP\WechatBundle\Forms;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Session\Session;

class buttonaddm extends FormRequest{

  public function rule(){
    return array();
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
    if($id = $dataSql->addMButton()){
      return array('code' => '10', 'id' => $id,'msg' => 'add button success');
    }
    return array('code' => '9', 'msg' => 'add button error');
  }

}
