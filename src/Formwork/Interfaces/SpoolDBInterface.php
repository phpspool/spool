<?php

namespace Spool\Formwork\Interfaces;

/**
 * Spool DB file interface
 */
interface SpoolDBInterface
{
    /**
     * 编码
     * 
     * @param string $data
     * 
     * @return string
     */
    public function encode(string $data): string;
    /**
     * 解码
     * 
     * @param string $data
     * 
     * @return string
     */
    public function decode(string $data): string;
    /**
     * 数据加密
     * 
     * @param string $data
     * @param string $cipher
     * @param string $passphrase
     * @param string $iv
     * @param [type] $option
     * 
     * @return string
     */
    public function encrypt(string $data, string $cipher, string $passphrase, string $iv = '', $option = null): string;
    /**
     * 数据解密
     * 
     * @param string $data
     * @param string $cipher
     * @param string $passphrase
     * @param string $iv
     * @param [type] $option
     * 
     * @return string
     */
    public function decrypt(string $data, string $cipher, string $passphrase, string $iv = '', $option = null): string;
}
