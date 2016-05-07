<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appProdUrlMatcher.
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appProdUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        // adp_wechat_homepage
        if (0 === strpos($pathinfo, '/hello') && preg_match('#^/hello/(?P<name>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'adp_wechat_homepage')), array (  '_controller' => 'ADP\\WechatBundle\\Controller\\DefaultController::indexAction',));
        }

        // adp_wechat_wechat
        if (rtrim($pathinfo, '/') === '/wechat') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'adp_wechat_wechat');
            }

            return array (  '_controller' => 'ADP\\WechatBundle\\Controller\\DefaultController::wechatAction',  '_route' => 'adp_wechat_wechat',);
        }

        // adp_wechat_api
        if (rtrim($pathinfo, '/') === '/api') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'adp_wechat_api');
            }

            return array (  '_controller' => 'ADP\\WechatBundle\\Controller\\DefaultController::apiAction',  '_route' => 'adp_wechat_api',);
        }

        // adp_wechat_myjob
        if (rtrim($pathinfo, '/') === '/myjob') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'adp_wechat_myjob');
            }

            return array (  '_controller' => 'ADP\\WechatBundle\\Controller\\DefaultController::myjobAction',  '_route' => 'adp_wechat_myjob',);
        }

        if (0 === strpos($pathinfo, '/adminapi')) {
            // adp_admin_createmenu
            if (rtrim($pathinfo, '/') === '/adminapi/createmenu') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'adp_admin_createmenu');
                }

                return array (  '_controller' => 'ADP\\WechatBundle\\Controller\\AdminapiController::createmenuAction',  '_route' => 'adp_admin_createmenu',);
            }

            // adp_admin_deletebutton
            if (rtrim($pathinfo, '/') === '/adminapi/deletebutton') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'adp_admin_deletebutton');
                }

                return array (  '_controller' => 'ADP\\WechatBundle\\Controller\\AdminapiController::deletebuttonAction',  '_route' => 'adp_admin_deletebutton',);
            }

            if (0 === strpos($pathinfo, '/adminapi/add')) {
                // adp_admin_addsubbutton
                if (rtrim($pathinfo, '/') === '/adminapi/addsubbutton') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'adp_admin_addsubbutton');
                    }

                    return array (  '_controller' => 'ADP\\WechatBundle\\Controller\\AdminapiController::addsubbuttonAction',  '_route' => 'adp_admin_addsubbutton',);
                }

                // adp_admin_addmbutton
                if (rtrim($pathinfo, '/') === '/adminapi/addmbutton') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'adp_admin_addmbutton');
                    }

                    return array (  '_controller' => 'ADP\\WechatBundle\\Controller\\AdminapiController::addmbuttonAction',  '_route' => 'adp_admin_addmbutton',);
                }

            }

            if (0 === strpos($pathinfo, '/adminapi/update')) {
                // adp_admin_updatebutton
                if (rtrim($pathinfo, '/') === '/adminapi/updatebutton') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'adp_admin_updatebutton');
                    }

                    return array (  '_controller' => 'ADP\\WechatBundle\\Controller\\AdminapiController::updatebuttonAction',  '_route' => 'adp_admin_updatebutton',);
                }

                // adp_admin_updateevent
                if (rtrim($pathinfo, '/') === '/adminapi/updateevent') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'adp_admin_updateevent');
                    }

                    return array (  '_controller' => 'ADP\\WechatBundle\\Controller\\AdminapiController::updateeventAction',  '_route' => 'adp_admin_updateevent',);
                }

            }

            // adp_admin_getevent
            if (rtrim($pathinfo, '/') === '/adminapi/getevent') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'adp_admin_getevent');
                }

                return array (  '_controller' => 'ADP\\WechatBundle\\Controller\\AdminapiController::geteventAction',  '_route' => 'adp_admin_getevent',);
            }

            // adp_admin_test
            if (rtrim($pathinfo, '/') === '/adminapi/test') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'adp_admin_test');
                }

                return array (  '_controller' => 'ADP\\WechatBundle\\Controller\\AdminapiController::testAction',  '_route' => 'adp_admin_test',);
            }

            if (0 === strpos($pathinfo, '/adminapi/c')) {
                // adp_admin_creatadmin
                if (rtrim($pathinfo, '/') === '/adminapi/creatadmin') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'adp_admin_creatadmin');
                    }

                    return array (  '_controller' => 'ADP\\WechatBundle\\Controller\\AdminapiController::creatadminAction',  '_route' => 'adp_admin_creatadmin',);
                }

                // adp_admin_changepwd
                if (rtrim($pathinfo, '/') === '/adminapi/changepwd') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'adp_admin_changepwd');
                    }

                    return array (  '_controller' => 'ADP\\WechatBundle\\Controller\\AdminapiController::changepwdAction',  '_route' => 'adp_admin_changepwd',);
                }

            }

        }

        if (0 === strpos($pathinfo, '/outapi')) {
            // adp_out_myjob
            if (rtrim($pathinfo, '/') === '/outapi/myjob') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'adp_out_myjob');
                }

                return array (  '_controller' => 'ADP\\WechatBundle\\Controller\\OutapiController::myjobAction',  '_route' => 'adp_out_myjob',);
            }

            if (0 === strpos($pathinfo, '/outapi/log')) {
                // adp_out_logout
                if (rtrim($pathinfo, '/') === '/outapi/logout') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'adp_out_logout');
                    }

                    return array (  '_controller' => 'ADP\\WechatBundle\\Controller\\OutapiController::logoutAction',  '_route' => 'adp_out_logout',);
                }

                // adp_out_login
                if (rtrim($pathinfo, '/') === '/outapi/login') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'adp_out_login');
                    }

                    return array (  '_controller' => 'ADP\\WechatBundle\\Controller\\OutapiController::loginAction',  '_route' => 'adp_out_login',);
                }

            }

        }

        // homepage
        if (rtrim($pathinfo, '/') === '') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'homepage');
            }

            return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::indexAction',  '_route' => 'homepage',);
        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
