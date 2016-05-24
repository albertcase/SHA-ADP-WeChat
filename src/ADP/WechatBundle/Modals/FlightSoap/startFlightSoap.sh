#!/bin/bash
result=$(ps -aux|grep FlightSoapSend.php|grep -v grep)
if [[ $result ]]
then
	echo 'this service already runing';
	exit;
fi
php /data/webown/sites/sha-adp-wechat/src/ADP/WechatBundle/Modals/FlightSoap/FlightSoapSend.php &
