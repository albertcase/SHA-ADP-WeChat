<?php

namespace ADP\WechatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class OutapiController extends Controller
{
  public function logoutAction(){
    $Session = new Session();
    $Session->clear();
    return new Response(json_encode(array('code' => '10', 'msg' => 'logout success'), JSON_UNESCAPED_UNICODE));
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

  public function myjobAction(Request $request){
    $data = $request->request->get('dologin');
    // $Validation = new Validation();
    // $validator = Validation::createValidator();
    // $data = $validator->validateValue('Bernhardsssssssss', new Length(array('min' => 10)));
    // print_r($data);
    $validator = Validation::createValidator();

    $constraint = new Assert\Collection(array(
        'email' => new Assert\Email(),
        // 'simple' => new Assert\Length(array('min' => 102)),
        // 'gender' => new Assert\Choice(array(3, 4)),
        // 'password' => new Assert\Length(array('min' => 60)),
    ));
    $input = array(
      'email' => 'aaa',
      // 'simple' => 'bbbb',
      // 'gender' => '3',
      // 'password' => 'asdasdasda',
    );
    $violations = $validator->validateValue($input, $constraint);
    if($violations->count())
      echo "success";
    else
      echo "error";
    print_r($violations->count());
    return new Response(json_encode($data, JSON_UNESCAPED_UNICODE));
  }
}
