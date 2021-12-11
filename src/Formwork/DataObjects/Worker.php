<?php

namespace Spool\Formwork\DataObjects;

use Psr\Log\LoggerInterface;
use Spool\Formwork\DataObjects\Heartbeat;
use Spool\Formwork\DataObjects\Timer;
use Spool\Formwork\Interfaces\WorksInterface;

abstract class Worker implements WorksInterface
{
    public string $name;
    public int $pid;
    public Timer $runTime;
    public Heartbeat $heartbeat;
    public IpcSocket $ipc;
    public LoggerInterface $logger;
    abstract public function run(): void;
    abstract public function stop(): void;
    /**
     * 获取当前工作进程的状态
     * 
     * @return WorkStatus
     */
    public function getStatus(): WorkStatus
    {
        $workStatus = new WorkStatus();
        $workStatus->startTime = intval($this->runTime->getStart());
        $this->memoryUsage = \memory_get_usage();
        $workStatus->clients = 0;
        $workStatus->maxClient = 0;

        return $workStatus;
    }
}
