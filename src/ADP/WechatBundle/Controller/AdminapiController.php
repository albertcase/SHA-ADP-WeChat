<?php

namespace ADP\WechatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use ADP\WechatBundle\Modals\Apis\Wechat;
use Symfony\Component\HttpFoundation\Session\Session;

class AdminapiController extends Controller
{
  public function createmenuAction(){
    $wehcat = $this->container->get('my.Wechat');
    $data = array('code' => '9', 'msg' => 'update wechat menus error');
    if($wehcat->buildmenu())
      $data = array('code' => '10', 'msg' => 'update wechat menus success');
    return  new Response(json_encode($data, JSON_UNESCAPED_UNICODE));
  }

  public function deletebuttonAction(){
    $adminadd = $this->container->get('form.buttondel');
    $data = $adminadd->DoData();
    return new Response(json_encode($data, JSON_UNESCAPED_UNICODE));
  }

  public function addsubbuttonAction(){
    $adminadd = $this->container->get('form.buttonaddsub');
    $data = $adminadd->DoData();
    return new Response(json_encode($data, JSON_UNESCAPED_UNICODE));
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

  public function testAction(){
    return new Response(json_encode(array('code' => '23' ,'msg' => 'you arelogin'), JSON_UNESCAPED_UNICODE));
  }

  public function notpassedeAction(){
    return new Response(json_encode(array('code' => '2' ,'msg' => 'you are not login'), JSON_UNESCAPED_UNICODE));
  }

// admin manage start
  public function creatadminAction(){
    $Session = new Session();
    $user = $Session->get($this->container->getParameter('session_login'));
    if($user != 'admin')//only admin can create admin user
      return new Response(json_encode(array('code' => '3', 'msg' => "your don't have permission"), JSON_UNESCAPED_UNICODE));
    $adminadd = $this->container->get('form.adminadd');
    $data = $adminadd->DoData();
    return new Response(json_encode($data, JSON_UNESCAPED_UNICODE));
  }

  public function changepwdAction(){
    $adminadd = $this->container->get('form.changepwd');
    $data = $adminadd->DoData();
    return new Response(json_encode($data, JSON_UNESCAPED_UNICODE));
  }
// admin manage end
// article start
  public function creatarticleAction(){
    $adminadd = $this->container->get('form.articleadd');
    $data = $adminadd->DoData();
    return new Response(json_encode($data, JSON_UNESCAPED_UNICODE));
  }

  public function editarticleAction(){
    $adminadd = $this->container->get('form.articleedit');
    $data = $adminadd->DoData();
    return new Response(json_encode($data, JSON_UNESCAPED_UNICODE));
  }

  public function deletearticleAction(){
    $adminadd = $this->container->get('form.articledel');
    $data = $adminadd->DoData();
    return new Response(json_encode($data, JSON_UNESCAPED_UNICODE));
  }
//article end
}
