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

  public function systemAction(){

  }


}
