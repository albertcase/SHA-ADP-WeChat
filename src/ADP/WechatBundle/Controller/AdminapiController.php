<?php

namespace ADP\WechatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use ADP\WechatBundle\Modals\Apis\Wechat;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;

class AdminapiController extends Controller
{
  public function getmenusAction(){
    $fun = $this->container->get('my.functions');
    $data = array(
      'code' => '10',
      'menus' => $fun->getmenus(),
    );
    return new Response(json_encode($data, JSON_UNESCAPED_UNICODE));
  }

  public function getmmenuAction(){
    $fun = $this->container->get('my.functions');
    $data = array(
      'code' => '10',
      'menus' => $fun->getmmenu(),
    );
    return new Response(json_encode($data, JSON_UNESCAPED_UNICODE));
  }

  public function createmenuAction(){
    $wehcat = $this->container->get('my.Wechat');
    $data = array('code' => '9', 'msg' => 'update wechat menus error');
    if($wehcat->buildmenu())
      $data = array('code' => '10', 'msg' => 'update wechat menus success');
    return  new Response(json_encode($data, JSON_UNESCAPED_UNICODE));
  }

  public function getbuttoninfoAction(){
    $adminadd = $this->container->get('form.buttoninfo');
    $data = $adminadd->DoData();
    return new Response(json_encode($data, JSON_UNESCAPED_UNICODE));
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
    $adminadd = $this->container->get('form.buttonaddm');
    $data = $adminadd->DoData();
    return  new Response(json_encode($data, JSON_UNESCAPED_UNICODE));
  }

  public function updatebuttonAction(){
    $adminadd = $this->container->get('form.buttonupdate');
    $data = $adminadd->DoData();
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
  public function articleaddAction(){
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
// keyword
  public function keywordaddAction(){
    $adminadd = $this->container->get('form.keywordadd');
    $data = $adminadd->DoData();
    return new Response(json_encode($data, JSON_UNESCAPED_UNICODE));
  }

  public function getkeywordlistAction(){
    $sql = $this->container->get('my.dataSql');
    if(!$list = $sql->getkeywordlist())
      return new Response(json_encode(array('code' => '9', 'msg' => 'there not any event'), JSON_UNESCAPED_UNICODE));
    $data = array(
      'code' => '10',
      'list' => $list,
    );
    return new Response(json_encode($data, JSON_UNESCAPED_UNICODE));
  }

  public function keyworddelAction(){
    $sql = $this->container->get('form.keyworddel');
    $data = $sql->DoData();
    return new Response(json_encode($data, JSON_UNESCAPED_UNICODE));
  }

  public function getkeywordinfoAction(){
    $sql = $this->container->get('form.keywordinfo');
    $data = $sql->DoData();
    return new Response(json_encode($data, JSON_UNESCAPED_UNICODE));
  }

  public function keywordupdateAction(){
    $sql = $this->container->get('form.keywordupdate');
    $data = $sql->DoData();
    return new Response(json_encode($data, JSON_UNESCAPED_UNICODE));
  }
// keyword end
  public function uploadimageAction(Request $request){ //upload image
    $fs = new \Symfony\Component\Filesystem\Filesystem();
    $dir = date('Ym' ,strtotime("now"));
    if(!$fs->exists('upload/image/'.$dir)){
      $fs->mkdir('upload/image/'.$dir);
    }
    if(!$request->files->has('uploadfile'))
      return new Response(json_encode(array('code' => '8', 'msg'=> 'error params'), JSON_UNESCAPED_UNICODE));
    $photo = $request->files->get('uploadfile');
    $Ext = strtolower($photo->getClientOriginalExtension());
    if(!in_array($Ext, array('png', 'gif', 'bmp', 'jpg', 'jpeg')))
      return new Response(json_encode(array('code' => '9', 'msg' => 'this is not a image file'), JSON_UNESCAPED_UNICODE));
    $image = 'upload/image/'.$dir.'/'.uniqid().'.'.$photo->getClientOriginalExtension();
    $fs->rename($photo, $image, true);
    return new Response(json_encode(array('code' => '10', 'path'=> '/'.$image)));
  }

}
