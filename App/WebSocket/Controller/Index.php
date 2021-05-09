<?php
namespace App\WebSocket\Controller;

class Index extends Base
{

    /**
     * 心跳执行的方法
     * 该方法建议 迁移到 基类控制器 Base 中
     * 推荐使用 easyswoole 自带的websocket客户端调试
     * http://www.easyswoole.com/wstool.html
     */
    public function heartbeat(){
        $fd = $this->caller()->getClient()->getFd();
        $this->caller()->getClient()->getFd(); // 请求用户的fd
        $data = $this->caller()->getArgs(); // 获取请求参数
        var_dump($data);
        var_dump(\EasySwoole\EasySwoole\ServerManager::getInstance()->getSwooleServer()->worker_id);
        echo "心跳 heartbeat {$fd} \n";

    }

    public function index(){
        $this->caller()->getClient()->getFd(); // 请求用户的fd
        $data = $this->caller()->getArgs(); // 获取请求参数
        var_dump($data);
        $this->response()->setMessage('your fd is '. $this->caller()->getClient()->getFd()); // 推送消息
        var_dump(intval($this->response()->isFinish()));
        echo "接收到客户端连接 \n";
        \EasySwoole\EasySwoole\Logger::getInstance()->error('打印日志');

        $redis=\EasySwoole\Pool\Manager::getInstance()->get('redis')->getObj();
        if(!$res=$redis->get("name")){
            $redis->set("name","zq");
        }

        $res = $redis->get("name");
        var_dump($res);
    }
    public function index1(){
        $this->caller()->getClient()->getFd(); // 请求用户的fd
        $data = $this->caller()->getArgs(); // 获取请求参数
        var_dump($data);
        $this->response()->setMessage('your fd is '. $this->caller()->getClient()->getFd()); // 推送消息
        echo "接收到客户端连接 \n";
        \EasySwoole\EasySwoole\Logger::getInstance()->error('牛逼');
    }
}