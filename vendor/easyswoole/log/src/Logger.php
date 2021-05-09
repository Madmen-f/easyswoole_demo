<?php


namespace EasySwoole\Log;
use EasySwoole\Socket\Bean\Caller;

class Logger implements LoggerInterface
{
    private $logDir;
    private $caller;

    function __construct(string $logDir = null)
    {
        if(empty($logDir)){
            $logDir = getcwd();
        }
        $this->logDir = $logDir;
    }
    public function setCaller($caller):void
    {
        $this->caller = $caller;
    }

    public function getCaller(): ?Caller
    {
        return $this->caller;
    }

    function log(?string $msg,int $logLevel = self::LOG_LEVEL_DEBUG,string $category = 'debug')
    {
        $caller = $this->getCaller();
        $className = $caller->getClassName();
        $action = $caller->getAction();
        $prefix = date('Y_m_d');
        $date = date('Y-m-d H:i:s');
        $levelStr = $this->levelMap($logLevel);
        $filePath = $this->logDir."/{$className}_{$action}_log_{$prefix}.log";
        $str = "[{$date}][{$category}][{$levelStr}]:[{$msg}]\n";
        file_put_contents($filePath,"{$str}",FILE_APPEND|LOCK_EX);
        return $str;
    }

    function console(?string $msg,int $logLevel = self::LOG_LEVEL_DEBUG,string $category = 'debug')
    {
        $date = date('Y-m-d H:i:s');
        $levelStr = $this->levelMap($logLevel);
        echo "[{$date}][{$category}][{$levelStr}]:[{$msg}]\n";
    }

    private function levelMap(int $level)
    {
        switch ($level)
        {
            case self::LOG_LEVEL_DEBUG:
                return 'debug';
            case self::LOG_LEVEL_INFO:
               return 'info';
            case self::LOG_LEVEL_NOTICE:
                return 'notice';
            case self::LOG_LEVEL_WARNING:
                return 'warning';
            case self::LOG_LEVEL_ERROR:
                return 'error';
            default:
                return 'unknown';
        }
    }
}