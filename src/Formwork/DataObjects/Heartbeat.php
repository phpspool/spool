<?php
namespace Spool\Formwork\DataObjects;

use Spool\Exceptions\HeartbeatException;
/**
 * 心跳
 */
class Heartbeat extends Timer
{
    protected int $heartbeatSec = 0;
    protected float $heartbeaUsec = 0.0;
    protected int $lostNumber = 0;
    public function get(): float
    {
        return $this->sec + $this->usec;
    }
    /**
     * @param integer $sec
     * @param integer $usec
     * @return void
     */
    public function set(int $sec, float $usec): void
    {
        if ($sec < 0 || ($sec == 0 && $usec <= env('MIX_MICROTIME', 10))) {
            throw new HeartbeatException();
        }
        $this->heartbeatSec = $sec;
        $this->heartbeaUsec = $usec;
    }
    public function getLostNumber(): int
    {
        return $this->lostNumber;
    }
    public function reset(): void
    {
        parent::reset();
        $this->lostNumber = 0;
    }
    public function doHeartbeat(): bool
    {
        $heartbeat =$this->heartbeatSec + $this->heartbeaUsec;
        $lost = $this->getLost();
        if ($lost < $heartbeat) {
            return false;
        }
        $this->lostNumber++;
        return true;
    }
}