<?php

namespace ADP\WechatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use ADP\WechatBundle\Modals\Apis\Wechat;

class AdminapiController extends Controller
{
  public function createmenuAction(){
    $wehcat = $this->container->get('my.Wechat');
    $data = array('code' => '9');
    if($wehcat->buildmenu())
      $data = array('code' => '10');
    return  new Response(json_encode($data, JSON_UNESCAPED_UNICODE));
  }

  public function deletebuttonAction(){
    $wehcat = $this->container->get('my.Wechat');
    $dataSql = $this->container->get('my.dataSql');
    $data = array('code' => '9');
    if($dataSql->deleteButton('1'))
      $data = array('code' => '10');
    return  new Response(json_encode($data, JSON_UNESCAPED_UNICODE));
  }

  public function addsubbuttonAction(){
    $dataSql = $this->container->get('my.dataSql');
    $data = array('code' => '9');
    if($id = $dataSql->addSubButton('1'))
      $data = array('code' => '10', 'id' => $id);
    return  new Response(json_encode($data, JSON_UNESCAPED_UNICODE));
  }

  public function addmbuttonAction(){
    $dataSql = $this->container->get('my.dataSql');
    $data = array('code' => '9');
    if($id = $dataSql->addMButton())
      $data = array('code' => '10', 'id' => $id);
    return  new Response(json_encode($data, JSON_UNESCAPED_UNICODE));
  }

  public function updatebuttonAction(){
    $dataSql = $this->container->get('my.dataSql');
    $data = array('code' => '9');
    if($id = $dataSql->updateButton('23'))
      $data = array('code' => '10', 'id' => $id);
    return  new Response(json_encode($data, JSON_UNESCAPED_UNICODE));
  }

  public function updateeventAction(){
    $dataSql = $this->container->get('my.dataSql');
    $data = array('code' => '9');
    if($dataSql->updateEvent($data, array()))
      $data = array('code' => '10');
    return  new Response(json_encode($data, JSON_UNESCAPED_UNICODE));
  }

  public function geteventAction(){
    $dataSql = $this->container->get('my.dataSql');
    $data = array('code' => '9');
    if($out = $dataSql->getEvent($data))
      $data = array('code' => '10', 'event' => $out);
    return  new Response(json_encode($data, JSON_UNESCAPED_UNICODE));
  }

}
