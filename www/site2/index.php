<?php
    $redis = new Redis();
    $redis->connect('192.168.1.11',6379);//修改成自己的ip
    $redis->set('name','青波');
    echo $redis->get('name');
        //检测是否连接成功
phpinfo();
