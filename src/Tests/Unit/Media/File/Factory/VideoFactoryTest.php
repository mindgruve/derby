<?php

namespace Derby\Tests\Unit\File;

use Derby\Media\File\Factory\FileFactory;
use Derby\Media\File\Factory\VideoFactory;
use Derby\Media\File\Video;
Use Mockery;

class VideoFactoryTest extends \PHPUnit_Framework_TestCase
{
    protected static $factoryInterface = 'Derby\Media\File\FactoryInterface';
    protected static $fileAdapterInterface = 'Derby\Adapter\FileAdapterInterface';

    public function testInterface()
    {
        $sut = new VideoFactory(array());
        $this->assertTrue($sut instanceof FileFactory);
    }

    public function testBuild()
    {
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new VideoFactory(array());
        $html = $sut->build('foo', $adapter);
        $this->assertTrue($html instanceof Video);
    }

}