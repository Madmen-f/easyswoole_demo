<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/8/10
 * Time: 上午10:57
 */

namespace EasySwoole\Socket\Bean;
use EasySwoole\Component\Singleton;


class Caller
{
    use Singleton;

    private $args = [];
    private $controllerClass = null;
    private $action = null;
    private $client;
    private $className;

    /**
     * @return array
     */
    public function getArgs(): array
    {
        return $this->args;
    }

    /**
     * @param array $args
     */
    public function setArgs(array $args): void
    {
        $this->args = $args;
    }


    public function getControllerClass():?string
    {
        return $this->controllerClass;
    }

    public function setControllerClass(?string $controllerClass): void
    {
        $this->controllerClass = $controllerClass;
    }

    public function getAction():?string
    {
        return $this->action;
    }

    public function setAction(?string $action): void
    {
        $this->action = $action;
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     */
    public function setClient($client): void
    {
        $this->client = $client;
    }

    /**
     * @return mixed
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @param mixed $client
     */
    public function setClassName($className): void
    {
        $this->className = $className;
    }
}