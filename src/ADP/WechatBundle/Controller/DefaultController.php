<?php

namespace ADP\WechatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use ADP\WechatBundle\Modals\Apis\Wechat;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ADPWechatBundle:Default:index.html.twig', array('name' => $name));
    }

    public function wechatAction(){
      $wechatObj = $this->container->get('my.Wechat');
      if(isset($_GET["echostr"])){
        return new Response($wechatObj->valid($_GET["echostr"]));
      }
      $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
      return new Response($wechatObj->responseMsg($postStr));
    }

    public function testAction(){
      $wehcat = $this->container->get('my.Wechat');
      $data = $wehcat->create_menu_array();
      print_r($data);
      $response = new Response(json_encode($data, JSON_UNESCAPED_UNICODE));
      return $response;
    }
}
