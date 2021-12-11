<?php
namespace Spool\Formwork\Interfaces;

use Spool\Formwork\DataObjects\WorkStatus;

interface WorksInterface
{
    public function run(): void;
    public function stop(): void;
    public function getStatus(): WorkStatus;
}
