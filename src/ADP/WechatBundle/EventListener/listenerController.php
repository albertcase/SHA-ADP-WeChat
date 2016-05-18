<?php
namespace ADP\WechatBundle\EventListener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use ADP\WechatBundle\Controller\DefaultController;
use ADP\WechatBundle\Controller\AdminapiController;
use ADP\WechatBundle\Controller\ManageController;
use Symfony\Component\HttpFoundation\Session\Session;

class listenerController{

  private $router;
  private $container;

  public function __construct($router ,$container){
    $this->router = $router;
    $this->container = $container;
  }

  public function onKernelController(FilterControllerEvent $event){
    $controller = $event->getController();
    $Session = new Session();
    if(!$Session->has($this->container->getParameter('session_login'))){
      if($controller[0] instanceof AdminapiController){
          $controller[1] = 'notpassedeAction';//if not login print error msg
      }
      if($controller[0] instanceof ManageController){
          $controller[1] = 'indexAction';//if not login pag
      }
    }
    return $event->setController($controller);
  }

}
