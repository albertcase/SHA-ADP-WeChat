<?php
namespace ADP\WechatBundle\EventListener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;

class listenerRequest{

    private $request;
    private $container;
    private $router;

    public function __construct(Request $request ,$container){
	      $this->request = $request;
        $this->container = $container;
    }

    public function onKernelRequest(GetResponseEvent $event){
    	$this->router = $event->getRequest()->get('_route');
    	if($this->router == 'adp_manage_index' || $this->router == 'adp_index'){
        $Session = new Session();
        if($Session->has($this->container->getParameter('session_login'))){
          return $event->setResponse(new RedirectResponse($this->container->get('router')->generate('adp_manage_menu' ,array())));
        }
    	}
    }

}
