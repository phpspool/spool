<?php

namespace Spool\Formwork\DataObjects;

use Spool\Exceptions\TimerException;
/**
 * Warning! The microsecond time counter may not be very accurate, and it is 
 * not recommended to be used where accurate time is required!
 * 
 * 警告! 微秒级别的时间计数器可能不是太准确, 不建议用于需要精准时间的场合!
 */
class Timer
{
    protected int $sec = 0;
    protected float $usec = 0.0;
    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->start();
    }
    /**
     * Warning! If the given time is greater than the current time, it will 
     * return the current time and may have unknown consequences.
     * 
     * 警告! 如果给出的时间大于当前时间, 这会返回当前时间, 并可能因此产生未知的后果
     * 
     * @param integer $sec
     * @param float $usec
     * 
     * @return self
     */
    public function make(int $sec, float $usec = 0.0): self
    {
        [$testUsec, $testSec] = \explode(" ", \microtime());
        $testUsec = $testUsec;
        $floatUsec = $usec;
        if ($testSec + $testUsec < $sec + $floatUsec) {
            throw new TimerException("Make time is wrong!");
        }
        $this->sec = $sec;
        $this->usec = $floatUsec;
        return $this;
    }
    public function start(): void
    {
        if (!$this->usec & !$this->sec) {
            [$this->usec, $this->sec] = \explode(" ", \microtime());
        }
    }
    public function reset(): void
    {
        [$this->usec, $this->sec] = \explode(" ", \microtime());
    }
    public function getStart(): string
    {
        return "{$this->usec} {$this->sec}";
    }
    public function getLost(): float
    {
        [$usec, $sec] = \explode(" ", \microtime());
        return $sec + $usec - $this->sec - $this->usec;
    }
    public function stop(): float
    {
        [$usec, $sec] = \explode(" ", \microtime());
        $lost = $sec
            + $usec
            - $this->sec
            - $this->usec;
        [$this->usec, $this->sec] = [$usec, $sec];
        return $lost;
    }
}
