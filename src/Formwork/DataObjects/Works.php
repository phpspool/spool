<?php

namespace Spool\Formwork\DataObjects;

use Spool\Formwork\Interfaces\WorksInterface;


abstract class Works
{
    protected array $works = [];
    public function getWork(string $name): ?WorksInterface
    {
        if (isset($this->works[$name])) {
            return $this->works[$name];
        }
        return null;
    }
    public function setWork(string $name, WorksInterface $work): void
    {
        $this->works[$name] = $work;
    }
    public function exists(string $name): bool
    {
        return isset($this->works[$name]);
    }
    public function getWorkNames(): array
    {
        return \array_keys($this->works);
    }
}
