<?php
namespace App\WebSocket\Controller;
use EasySwoole\Socket\AbstractInterface\Controller;
use EasySwoole\Socket\Client\WebSocket as WebSocketClient;

use Exception;

/**
 * 基础控制器
 * Class Base
 * @package App\WebSocket\Controller
 */
class Base extends Controller
{

    /**
     * 设置心跳
     */
    public function heartbeat() {

    }

    /**
     * 获取当前的用户
     * @return array|string
     * @throws Exception
     */
    protected function currentUser()
    {
        /** @var WebSocketClient $client */
    }

    protected function actionNotFound(?string $actionName)
    {
        // 关闭客户端
        \EasySwoole\EasySwoole\ServerManager::getInstance()->getSwooleServer()->disconnect($fd);
        echo "您的请求 {$actionName} 不存在 ... \n";
    }

    protected function afterAction(?string $actionName)
    {
        echo "请求之后执行 \n";
    }
}