<?php
namespace ADP\WechatBundle\Forms;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Session\Session;

class buttonaddsub extends FormRequest{

  public function rule(){
    return array(
      'mOrder' => new Assert\Range(array('min' => 0, 'max' => 2)),
    );
  }

  public function FormName(){
    return 'buttonaddsub';
  }

  public function DoData(){
    if($this->Confirm()){
      return array('code' => '11' ,'msg' => 'your input error');
    }
    return $this->dealData();
  }

  public function dealData(){
    $dataSql = $this->container->get('my.dataSql');
    if($id = $dataSql->addSubButton($this->getdata['mOrder'])){
      return array('code' => '10', 'id' => $id,'msg' => 'delete button success');
    }
    return array('code' => '9', 'msg' => 'delete button error');
  }

}
