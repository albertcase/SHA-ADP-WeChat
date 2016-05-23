#!/bin/bash
result=$(ps -aux|grep customsMsgSend.php|grep -v grep)
if [[ $result ]]
then
	echo 'this service already runing';
	exit;
fi
php ~+/customsMsgSend.php &
