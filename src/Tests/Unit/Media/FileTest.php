<?php

namespace Derby\Tests\Unit\Media;

use Derby\Media\File;
use Mockery;
use Derby\Media\FileInterface;
use PHPUnit_Framework_TestCase;
use Derby\Media;

class FileTest extends PHPUnit_Framework_TestCase
{

    protected static $fileAdapterInterface = 'Derby\Adapter\FileAdapterInterface';


    public function testInterface()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new File($key, $adapter);

        $this->assertTrue($sut instanceof \Derby\Media);
        $this->assertTrue($sut instanceof FileInterface);
    }

    public function testConstructor()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new File($key, $adapter);

        $this->assertEquals($key, $sut->getKey());
        $this->assertEquals($adapter, $sut->getAdapter());
    }


    public function testType()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new File($key, $adapter);

        $this->assertEquals(FileInterface::TYPE_MEDIA_FILE, $sut->getMediaType());
    }

    public function testRemoveSuccessful()
    {

        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new File($key, $adapter);
        $adapter->shouldReceive('delete')->andReturn(true);

        $this->assertTrue($sut->remove());
    }

    public function testRemoveUnsuccessful()
    {

        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new File($key, $adapter);
        $adapter->shouldReceive('delete')->andReturn(false);

        $this->assertFalse($sut->remove());
    }

    public function testReadSuccessful()
    {

        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new File($key, $adapter);
        $adapter->shouldReceive('read')->andReturn('lorem ipsum');

        $this->assertEquals('lorem ipsum', $sut->read());
    }

    public function testReadUnsuccessful()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new File($key, $adapter);
        $adapter->shouldReceive('read')->andReturn(false);

        $this->assertEquals(false, $sut->read());
    }

    public function testWriteSuccessful()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);
        $data    = 'lorem ipsum';

        $sut = new File($key, $adapter);

        $adapter->shouldReceive('write')->with($key, $data)->andReturn(11);

        $this->assertEquals(11, $sut->write($data));
    }

    public function testWriteUnsuccessful()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);
        $data    = 'lorem ipsum';

        $sut = new File($key, $adapter);

        $adapter->shouldReceive('write')->with($key, $data)->andReturn(false);

        $this->assertFalse($sut->write($data));
    }

    public function testRenameSuccessful()
    {
        $key     = 'foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new File($key, $adapter);
        $adapter->shouldReceive('rename')->with('foo', 'bar')->andReturn(true);

        $this->assertEquals(true, $sut->rename('bar'));
    }

    public function testRenameUnsuccessful()
    {
        $key     = 'foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new File($key, $adapter);
        $adapter->shouldReceive('rename')->with('foo', 'bar')->andReturn(false);

        $this->assertEquals(false, $sut->rename('bar'));
    }
}
