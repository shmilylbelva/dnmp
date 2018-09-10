<?php
//    $redis = new Redis();
//    $redis->connect('192.168.0.107',6379);//修改成自己的ip
//    $redis->set('name','青波');
//    echo $redis->get('name');
//        检测是否连接成功
//phpinfo();
//配置信息
//引用所需文件
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
//建立一个连接通道，声明一个可以发送消息的队列hello
$conn = new AMQPStreamConnection('192.168.0.107', 5672, 'user', '123456');
$channel = $connection->channel();


//发送方其实不需要设置队列， 不过对于持久化有关，建议执行该行
$channel->queue_declare('hello', false, false, false, false);

$msg = new AMQPMessage('Hello World!');
$channel->basic_publish($msg, '', 'hello');
echo " [x] Sent 'Hello World!'\n";

$channel->close();
$connection->close();
?>

