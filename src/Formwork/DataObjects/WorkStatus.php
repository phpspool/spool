<?php
namespace Spool\Formwork\DataObjects;

abstract class WorkStatus
{
    //defined
    public static int $startTime;
    public static int $pid;
    public static int $ppid;
    public static int $tcpPort;
    public static int $memoryLimit;
    public static string $version;
    public static string $phpVersion;
    public static string $os;
    public static string $startDir;
    public string $memoryUsage = '';
    public int $clients = 0;
    public int $maxClient = 0;

    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->memoryLimit = \ini_get('memory_limit');
        $this->os = \php_uname();
        $this->phpVersion = \phpversion();
        $this->memoryLimit = \ini_get('memory_limit');
        $this->pid = \posix_getpid();
        $this->ppid = \posix_getppid();
        $this->startDir = \ROOT_PATH;
    }
    /**
     * 获取状态
     * 
     * @return array
     */
    public function toArray(): array
    {
        $this->memoryUsage = \memory_get_usage();
        return [
            'startTime' => $this->startTime,
            'memoryUsage' => $this->memoryUsage,
            'os' => $this->os,
            'phpVersion' => $this->phpVersion,
            'memoryLimit' => $this->memoryLimit,
            'pid' => $this->pid,
            'ppid' => $this->ppid,
            'startDir' => $this->startDir,
            'ppid' => $this->ppid,
            'clients' => $this->clients,
            'maxClient' => $this->maxClient,
        ];
    }
}