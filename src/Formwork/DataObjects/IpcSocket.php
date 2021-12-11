<?php

namespace Spool\Formwork\DataObjects;

use Spool\Exceptions\SocketException;

class IpcSocket
{
    const ROLE = [
        'parent' => 1,
        'child' => 0
    ];
    protected array $fds = [];
    protected int $role = -1;
    /**
     * 构造函数
     */
    public function __construct()
    {
        if (socket_create_pair(AF_UNIX, SOCK_STREAM, 0, $this->fds) === false) {
            throw new SocketException("socket_create_pair failed. Reason: " . socket_strerror(socket_last_error()));
        }
    }
    public function isParent(): void
    {
        \socket_close($this->fds[0]);
        $this->role = self::ROLE['parent'];
    }
    public function isChild(): void
    {
        \socket_close($this->fds[1]);
        $this->role = self::ROLE['child'];
    }
    public function getSocketFd()
    {
        return $this->fds[$this->role];
    }
}
