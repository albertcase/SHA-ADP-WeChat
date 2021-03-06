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
      $respose = new Response($wechatObj->responseMsg($postStr));
      return $respose->send();
    }

    public function wechattestAction(){
      $wechatObj = $this->container->get('my.Wechat');
      $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
      return new Response($wechatObj->responseMsg($postStr));
    }

    public function articleAction($pageid = ''){
      $sql = $this->container->get('my.dataSql');
      if($w = $sql->getArticle(array('pageid' => $pageid))){
        $w = $w['0'];
        return $this->render('ADPWechatBundle:Default:article.html.twig', $w);
      }
      return $this->render('ADPWechatBundle:Default:index.html.twig', array('name' => '404'));
    }

    public function debentureAction(){
      return $this->render('ADPWechatBundle:Default:debenture.html.twig');
    }

    public function aaaaaAction(){
      return $this->render('ADPWechatBundle:Default:aaaaa.html.twig');
    }

    public function testAction(){
      $wehcat = $this->container->get('my.Wechat');
      $data = $wehcat->checkmenuarray();
      print_r($data);
      $response = new Response(json_encode($data, JSON_UNESCAPED_UNICODE));
      return $response;
    }

    public function apiAction(){
      $sql = $this->container->get('my.dataSql');
      $datas = array(
        array(
          'mOrder' => '0',
          'subOrder' => '0',
          'menuName' => '菜单A',
        ),
        array(
          'mOrder' => '1',
          'subOrder' => '0',
          'menuName' => '菜单B',
        ),
        array(
          'mOrder' => '2',
          'subOrder' => '0',
          'menuName' => '菜单C',
          'eventtype' => 'view',
          'eventUrl' => 'http://www.soso.com/',
        ),
        array(
          'mOrder' => '1',
          'subOrder' => '1',
          'menuName' => '菜单Bsub1',
          'eventtype' => 'view',
          'eventUrl' => 'http://www.soso.com/',
        ),
        array(
          'mOrder' => '1',
          'subOrder' => '2',
          'menuName' => '菜单Bsub2',
          'eventtype' => 'view',
          'eventUrl' => 'http://www.soso.com/',
        ),
        array(
          'mOrder' => '0',
          'subOrder' => '1',
          'menuName' => '菜单Asub1',
          'eventtype' => 'click',
          'eventKey' => 'A1',
        ),
        array(
          'mOrder' => '0',
          'subOrder' => '2',
          'menuName' => '菜单Asub2',
          'eventtype' => 'click',
          'eventKey' => 'A2',
        ),
        array(
          'mOrder' => '0',
          'subOrder' => '3',
          'menuName' => '菜单Asub3',
          'eventtype' => 'pic_weixin',
          'eventKey' => 'A3',
        ),
        array(
          'mOrder' => '0',
          'subOrder' => '4',
          'menuName' => '菜单Asub4',
          'eventtype' => 'pic_photo_or_album',
          'eventKey' => 'A4',
        ),
      );
      $sql->insertsData($datas, 'wechat_menu');
      return new Response(json_encode('111111111', JSON_UNESCAPED_UNICODE));
    }

    public function myjobAction(){
      return new Response(json_encode('111111111', JSON_UNESCAPED_UNICODE));
    }

    public function myjob2Action(){
      return new Response(json_encode('22222222', JSON_UNESCAPED_UNICODE));
    }
}
