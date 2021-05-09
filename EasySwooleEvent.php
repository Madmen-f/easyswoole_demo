<?php


namespace EasySwoole\EasySwoole;


use EasySwoole\EasySwoole\AbstractInterface\Event;
use EasySwoole\EasySwoole\Swoole\EventRegister;
use EasySwoole\Socket\Dispatcher;
use App\WebSocket\WebSocketParser;
use App\WebSocket\WebSocketEvent;

class EasySwooleEvent implements Event
{
    public static function initialize()
    {
        date_default_timezone_set('Asia/Shanghai');
    }

    public static function mainServerCreate(EventRegister $register)
    {
        $conf = new \EasySwoole\Socket\Config();

        //设置Dispatcher为WebSocket 模式
        $conf->setType(\EasySwoole\Socket\Config::WEB_SOCKET);

        $config = new \EasySwoole\Pool\Config();
        $redisConfig1 = new \EasySwoole\Redis\Config\RedisConfig(\EasySwoole\EasySwoole\Config::getInstance()->getConf('REDIS'));
        \EasySwoole\Pool\Manager::getInstance()->register(new \App\Pool\RedisPool($config,$redisConfig1),'redis');

        try {
            $parser = new WebSocketParser();
            $conf->setParser($parser);//设置解析器对象
            $dispatch = new Dispatcher($conf);//创建Dispatcher对象并注入config对象
        } catch (Exception $e) {
        }

        //给server注册相关事件在WebSocket模式下onMessage事件必须注册 并且交给Dispatcher对象处理
        $register->set(EventRegister::onMessage, function (\swoole_websocket_server $server, \swoole_websocket_frame $frame) use ($dispatch) {
            $dispatch->dispatch($server, $frame->data, $frame);

        });

       
        $websocketEvent = new WebSocketEvent();
        //自定义握手事件
        $register->set(EventRegister::onHandShake,function (\swoole_http_request $request, \swoole_http_response $response)use($websocketEvent){
            $websocketEvent->onHandShake($request,$response);
        });

        //自定义关闭事件
        $register->set(EventRegister::onClose, function (\swoole_server $server, int $fd, int $reactorId) use ($websocketEvent) {
            $websocketEvent->onClose($server, $fd, $reactorId);
        });
    }
}