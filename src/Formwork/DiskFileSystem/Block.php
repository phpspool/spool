<?php

namespace Spool\Formwork\DiskFileSystem;

use Spool\Exceptions\FileException\FileReadException;
use Spool\Exceptions\FileException\FileWriteException;
use Spool\Formwork\Interfaces\DiskFileSystemInterface;

class Block implements DiskFileSystemInterface
{
    const SECTOR_NUMBER = 8;
    /**
     * Block size = 4096Bytes
     */
    const SIZE = Sector::SIZE * self::SECTOR_NUMBER;
    /**
     * 头部数据大小
     */
    const HEADER_SIZE = 0;

    protected int $valid;

    protected string $string = '';

    protected array $sectors = [];
    /**
     * 构造函数
     */
    public function __construct()
    {
        $sector = new Sector;
        $this->valid = $sector->getValid() * self::SECTOR_NUMBER - self::HEADER_SIZE;
    }
    public function load(string $string): int
    {
        if (!$string) {
            throw new FileReadException('Block::load - string is empty');
        }
        $loadLength = 0;
        $strlen = strlen($string);
        while ($strlen) {
            $loadString = substr($string, $loadLength, Sector::SIZE);
            $sector = new Sector;
            $loadLength += $sector->load($loadString);
            $this->sectors[] = $sector;
            $strlen -= Sector::SIZE;
        }
        return $loadLength;
    }
    public function read(int $length = 0): string
    {
        $length = $length ?: strlen($this->string);
        if ($this->string) {
            return substr($this->string, 0, $length);
        }
        $string = '';
        foreach ($this->sectors as $value) {
            $string .= $value->read();
        }
        $this->string = $string;
        if (!$length) {
            return $string;
        }
        return substr($string, 0, $length);
    }
    public function write(string $string, int $length = 0): int
    {
        $strlen = $length ?: strlen($string);
        if (!$strlen) {
            throw new FileWriteException('Block::write - string is empty');
        }
        $writeStr = substr($string, 0, $strlen);
        $writeLength = 0;
        $count = 0;
        while ($count < self::SECTOR_NUMBER) {
            $sector = $this->sectors[$count] ?? new Sector;
            $toWrite = $sector->getValid();
            if ($strlen < $sector->getValid()) {
                $toWrite = $strlen;
            }
            $toWriteStr = substr($writeStr, $writeLength, $toWrite);
            $len = $sector->write($toWriteStr);
            $this->sectors[$count] = $sector;
            $strlen -= $sector->getValid();
            $count++;
            $writeLength += $toWrite;
            if ($strlen <= 0) {
                break;
            }
        }
        $this->string = substr($string, 0, $writeLength);
        return $writeLength;
    }
    public function save(int $mode): string
    {
        $string = "";
        $count = 0;
        while ($count < self::SECTOR_NUMBER) {
            $sector = $this->sectors[$count] ?? new Sector;
            $string .= $sector->save($mode);
            $count++;
        }
        return $string;
    }
    public function getValid(): int
    {
        return $this->valid;
    }
}
