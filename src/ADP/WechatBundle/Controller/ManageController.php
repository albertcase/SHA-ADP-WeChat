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
    $functions = $this->container->get('my.functions');
    $menus = $functions->getmenus();
    return $this->render('ADPWechatBundle:Manage:menu.html.twig', array('menus' => $menus));
  }

  public function keywordAction(){
    $sql = $this->container->get('my.dataSql');
    $wordlist = $sql->getkeywordlist();
    return $this->render('ADPWechatBundle:Manage:keyword.html.twig', array('wordlist' => $wordlist));
  }

  public function pageAction(){
    $sql = $this->container->get('my.dataSql');
    if(!$w = $sql->getArticlelist(array())){
      $w = array();
    }
    $host = $this->getRequest()->getSchemeAndHttpHost();
    return $this->render('ADPWechatBundle:Manage:pag.html.twig', array('list' => $w, 'host' => $host));
  }

  public function replyAction(){
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
