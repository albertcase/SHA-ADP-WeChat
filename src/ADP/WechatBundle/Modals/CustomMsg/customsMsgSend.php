<?php
namespace ADP\WechatBundle\Modals\CustomMsg;

require_once dirname(__FILE__).'/customsResponse.php';

$Custom = new customsResponse();
while($Custom->ststus())
{
  $Custom->pushMsg();
}

?>
