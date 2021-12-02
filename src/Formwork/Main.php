<?php

/**
 * Spool main
 * 
 * Class main 入口
 * 
 * PHP version 7.3
 * 
 * @category Spool
 * @package  Formwork
 * @author   yydick Chen <yydick@sohu.com>
 * @license  https://spdx.org/licenses/Apache-2.0.html Apache-2.0
 * @link     http://url.com
 * @DateTime 2021-12-02
 */

namespace Spool\Formwork;

/**
 * Spool main
 * 
 * Class main 入口
 * 
 * PHP version 7.2
 * 
 * @category Spool
 * @package  Formwork
 * @author   yydick Chen <yydick@sohu.com>
 * @license  https://spdx.org/licenses/Apache-2.0.html Apache-2.0
 * @link     http://url.com
 * @DateTime 2021-12-02
 */
class Main
{
    protected static $instance = null;
    public function instance(): self
    {
        if (!$this->instance) {
            $this->instance = new static();
        }
        return $this->instance;
    }
    public function checkEnv(): bool
    {
        return true;
    }
    public function start(): void
    {
    }
    public function end(): void
    {
    }
    public function restart(): void
    {
        $this->end();
        $this->start();
    }
}
