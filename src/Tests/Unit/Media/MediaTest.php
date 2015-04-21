<?php


namespace Derby\Tests\Unit\Media;

use Derby\MediaInterface;
use Derby\Media\File;
use Derby\Media;
use Mockery;
use PHPUnit_Framework_TestCase;

class MediaTest extends PHPUnit_Framework_TestCase
{

    protected static $fileAdapterInterface = 'Derby\Adapter\FileAdapterInterface';

    public function testInterface()
    {
        $key     = 'foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new Media($key, $adapter);
        
        $this->assertTrue($sut instanceof Media);
        $this->assertTrue($sut instanceof MediaInterface);
    }

    public function testConstructor()
    {
        $key     = 'foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new Media($key, $adapter);

        $this->assertEquals($key, $sut->getKey());
        $this->assertEquals($adapter, $sut->getAdapter());
    }
}
