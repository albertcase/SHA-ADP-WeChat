<?php

namespace ADP\WechatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use ADP\WechatBundle\Modals\FlightSoap\FlightSoap;

class OutapiController extends Controller
{
  public function logoutAction(){
    $Session = new Session();
    $Session->clear();
    return $this->redirectToRoute('adp_manage_index');
  }

  public function loginAction(){
    $adminadd = $this->container->get('form.adminlogin');
    $data = $adminadd->DoData();
    return new Response(json_encode($data, JSON_UNESCAPED_UNICODE));
  }

  public function ckeditoruploadimageAction(Request $request){ //upload Ckeditor image
    $fs = new \Symfony\Component\Filesystem\Filesystem();
    $CKEditorFuncNum = $request->get('CKEditorFuncNum');
    $dir = date('Ym' ,strtotime("now"));
    if(!$fs->exists('upload/image/'.$dir)){
      $fs->mkdir('upload/image/'.$dir);
    }
    $e0 = '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction('.$CKEditorFuncNum.',"","error params");</script>';
    if(!$request->files->has('upload'))
      return new Response($e0);
    $photo = $request->files->get('upload');
    $e1 = '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction('.$CKEditorFuncNum.',"","it is not a image file");</script>';
    $Ext = strtolower($photo->getClientOriginalExtension());
    if(!in_array($Ext, array('png', 'gif', 'bmp', 'jpg', 'jpeg')))
      return new Response($e1);
    $image = 'upload/image/'.$dir.'/'.uniqid().'.'.$photo->getClientOriginalExtension();
    $fs->rename($photo, $image, true);
    $e2 = '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction('.$CKEditorFuncNum.',"/'.$image.'","upload image success");window.close();</script>';
    return new Response($e2);
  }

  public function articlelistAction(){
    $adminadd = $this->container->get('form.articlelist');
    $data = $adminadd->DoData();
    return new Response(json_encode($data, JSON_UNESCAPED_UNICODE));
  }

  public function getarticleAction(){
    $adminadd = $this->container->get('form.articleinfo');
    $data = $adminadd->DoData();
    return new Response(json_encode($data, JSON_UNESCAPED_UNICODE));
  }

  public function soapAction(){
    $FlightSoap = new FlightSoap();
    // print_r($FlightSoap->getallfunctions());
    $data = array(
      'soapfunction' => 'AirlineFlightInfo',
      'AirlineFlightInfo' => array(
        'faFlightID' => 'CUA5978-1463890800-schedule-0000',
      ),
    );
    print_r($FlightSoap->SoapApi($data));
    return new Response(json_encode('success', JSON_UNESCAPED_UNICODE));
  }

  public function pushdataAction(){
    $customsResponse = $this->container->get('my.customsResponse');
    $msg = array(
      'msgtype' => 'text',
      'touser' => 'o8v3vssqk_UkjAsBYrd4Teb-m54A',
      'content' => 'test@o8v3vssqk_UkjAsBYrd4Teb-m54A',
    );
    $customsResponse->addCustomMsg($msg);
    $customsResponse->sendCustomMsg();
    return new Response(json_encode('success', JSON_UNESCAPED_UNICODE));
  }

  public function popdataAction(){
    // $customsResponse = $this->container->get('my.customsResponse');
    // $customsResponse->testsendMsg();
    print_r(mb_strlen('戴高乐机场'));
    return new Response(json_encode('success', JSON_UNESCAPED_UNICODE));
  }

  public function testbuttonAction(Request $request){
    // $wehcat = $this->container->get('my.Wechat');
    // $q = new \ADP\WechatBundle\Modals\FlightSoap\FlightSoapResponse();
    // $data = array(
    //   'soapevent' => 'getlatest',
    //   'OpenID' => 'o8v3vssqk_UkjAsBYrd4Teb-m54A',
    //   'ident' => 'CUA5978',
    // );
    // $q->addSoapJob($data);
    // // $q->teststartFlight();
    // $q->startFlightSoap();
    // $FlightSoapResponse = $this->container->get('my.FlightSoapResponse');
    // $data = array(
    //   'soapevent' => 'getlatest',
    //   'OpenID' => 'o8v3vssqk_UkjAsBYrd4Teb-m54A',
    //   'ident' => 'CUA5978',
    // );
    // $FlightSoapResponse->addSoapJob($data);
    // $FlightSoapResponse->startFlightSoap();
    $wehcat = $this->container->get('my.Wechat');
    print_r($wehcat->create_menu_array());
    return new Response(json_encode('success', JSON_UNESCAPED_UNICODE));
  }


  public function myjobAction(Request $request){
    $FlightSoap = new \ADP\WechatBundle\Modals\FlightSoap\FlightSoap();
    $data = array();
    $data['ident'] = $request->get('ident');
    preg_match_all("/^([A-Za-z]{1,4})([0-9]{1,8})$/", $data['ident'],$pident, PREG_SET_ORDER);
    $Soap = array(
      'soapfunction' => 'FlightInfo',
      'FlightInfo' => array(
        'ident' => $pident['0']['1'].ltrim($pident['0']['2'], "0"),
        'howMany' => '1',
      ),
    );
    $result = $FlightSoap->SoapApi($Soap);
    print_r($result);
    // $tgap = explode(":",'00:55:00');
    // $a = intval(strtotime('1970/1/1 00:55:00'))+8*3600;
    // $a = intval($tgap[0])*3600+intval($tgap[1])*60+intval($tgap[2]);
    // print_r($a);
    return new Response(json_encode($data, JSON_UNESCAPED_UNICODE));
  }
}
