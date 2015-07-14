<?php

namespace Derby\Tests\Unit\File;

use Derby\Media\File\Factory\FileFactory;
use Derby\Media\File\Factory\TextFactory;
use Derby\Media\File\Text;
Use Mockery;

class TextFactoryTest extends \PHPUnit_Framework_TestCase
{
    protected static $factoryInterface = 'Derby\Media\File\FactoryInterface';
    protected static $fileAdapterInterface = 'Derby\Adapter\FileAdapterInterface';

    public function testInterface()
    {
        $sut = new TextFactory(array());
        $this->assertTrue($sut instanceof FileFactory);
    }

    public function testBuild()
    {
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new TextFactory(array());
        $html = $sut->build('foo', $adapter);
        $this->assertTrue($html instanceof Text);
    }

}