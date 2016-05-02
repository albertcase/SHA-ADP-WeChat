<?php

namespace ADP\WechatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ADPWechatBundle:Default:index.html.twig', array('name' => $name));
    }

    public function wechatAction(){
      $sql = $this->container->get('vendor.MysqliDb');
      $data = array(
        'mOrder' => '1',
        'subOrder' => '1',
        'menuName' => '菜单1',
        'event' => 'click',
        // 'eventKey' => '',
        'eventUrl' => 'asdasdasdasdasd',
      );
      $id = $sql->insert ('wechat_menu', $data);
      $response = new Response('llllllllllll@'.$id);
      return $response;
    }
}
