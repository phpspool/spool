<?php

namespace Tests\Feature;

use Spool\Formwork\DiskFileSystem\Block;
use Tests\TestCase;

class DiskFileSystemTest extends TestCase
{
    public function testBlock()
    {
        $block = new Block();
        $string = "SL大法极乐世界老师看见了啥酒店发了啥剪短发了撒酒疯雷锋精神都放假了数据斐林试剂斐林试剂分类司法解释来看看副驾驶六块腹肌SD练腹肌阿斯兰地方就是老地方聚少离多副驾驶李达康福建乐山大佛聚少离多飞机上两地分居睡了多久烦死了快地方就是离开的放假了圣诞节";
        $string = str_pad($string, 3936, "非");
        // $string = str_pad($string, 492, "非");
        $len = $block->write($string);
        // \var_dump("len: {$len}\n", $block->save());
        \file_put_contents("test.pdfs", $block->save(0));
        $saved = \file_get_contents("test.pdfs");
        $newBlock = new Block();
        $newlen = $newBlock->load($saved);
        \var_dump($string, $newBlock->read(), $newBlock->read() === $string, $block->getValid());
        $this->assertEquals($string, $newBlock->read());
    }
}
