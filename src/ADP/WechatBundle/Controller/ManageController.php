<?php

namespace ADP\WechatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use ADP\WechatBundle\Modals\Apis\Wechat;
use Symfony\Component\HttpFoundation\Session\Session;

class ManageController extends Controller
{
  public function indexAction(){
      return $this->render('ADPWechatBundle:Manage:index.html.twig');
  }

  public function menuAction(){
    return $this->render('ADPWechatBundle:Manage:menu.html.twig');
  }

  public function keywordAction(){
    return $this->render('ADPWechatBundle:Manage:keyword.html.twig');
  }

  public function pagAction(){
    return $this->render('ADPWechatBundle:Manage:pag.html.twig');
  }

  public function replayAction(){
    return $this->render('ADPWechatBundle:Manage:replay.html.twig');
  }

  public function preferenceAction(){
    $Session = new Session();
    // $admin = false;
    // if($Session->get($this->container->getParameter('session_login')) == 'admin')
      $admin = true;
    return $this->render('ADPWechatBundle:Manage:preference.html.twig', array('admin' => $admin));
  }

}
