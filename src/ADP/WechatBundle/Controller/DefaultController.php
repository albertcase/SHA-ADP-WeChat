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
      $a = $this->container->getParameter('database_name');
      $response = new Response('llllllllllll'.$a);
      return $response;
    }
}
