<?php

namespace Derby\Tests\Unit\File;

use Derby\Media\File\Audio;
use Derby\Media\File\Factory\AudioFactory;
use Derby\Media\File\Factory\FileFactory;
Use Mockery;

class AudioFactoryTest extends \PHPUnit_Framework_TestCase
{
    protected static $factoryInterface = 'Derby\Media\File\FactoryInterface';
    protected static $fileAdapterInterface = 'Derby\Adapter\FileAdapterInterface';

    public function testInterface()
    {
        $sut = new AudioFactory(array());

        $this->assertTrue($sut instanceof FileFactory);
    }

    public function testBuild()
    {
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new AudioFactory(array());
        $audioFile = $sut->build('foo', $adapter);

        $this->assertTrue($audioFile instanceof Audio);
    }

}