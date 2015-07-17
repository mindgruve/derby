<?php

namespace Derby\Tests\Unit\Media;

use Derby\Media\File;
use Derby\Media\FileInterface;
use Derby\Media\RemoteFileInterface;
use Mockery;
use PHPUnit_Framework_TestCase;
use Derby\Media;

class FileTest extends PHPUnit_Framework_TestCase
{

    protected static $fileAdapterInterface = 'Derby\Adapter\FileAdapterInterface';
    protected static $remoteFileAdapterInterface = 'Derby\Adapter\RemoteFileAdapterInterface';


    public function testInterface()
    {
        $key = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new File($key, $adapter);

        $this->assertTrue($sut instanceof Media);
        $this->assertTrue($sut instanceof FileInterface);
    }

    public function testConstructor()
    {
        $key = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new File($key, $adapter);

        $this->assertEquals($key, $sut->getKey());
        $this->assertEquals($adapter, $sut->getAdapter());
    }


    public function testType()
    {
        $key = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new File($key, $adapter);

        $this->assertEquals(File::TYPE_MEDIA_FILE, $sut->getMediaType());
    }

    public function testDeleteSuccessful()
    {

        $key = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new File($key, $adapter);
        $adapter->shouldReceive('delete')->andReturn(true);

        $this->assertTrue($sut->delete());
    }

    public function testDeleteUnsuccessful()
    {

        $key = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new File($key, $adapter);
        $adapter->shouldReceive('delete')->andReturn(false);

        $this->assertFalse($sut->delete());
    }

    public function testReadSuccessful()
    {

        $key = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);
        $adapter->shouldReceive('exists')->with($key)->andReturn(true);

        $sut = new File($key, $adapter);
        $adapter->shouldReceive('read')->andReturn('lorem ipsum');

        $this->assertEquals('lorem ipsum', $sut->read());
    }

    public function testReadUnsuccessful()
    {
        $key = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);
        $adapter->shouldReceive('exists')->with($key)->andReturn(true);

        $sut = new File($key, $adapter);
        $adapter->shouldReceive('read')->andReturn(false);

        $this->assertEquals(false, $sut->read());
    }

    /**
     * @expectedException Exception
     */
    public function testReadFromNonExistentFile()
    {
        $key = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);
        $adapter->shouldReceive('exists')->with($key)->andReturn(false);

        $sut = new File($key, $adapter);
        $sut->read();
    }

    public function testWriteSuccessful()
    {
        $key = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);
        $data = 'lorem ipsum';

        $sut = new File($key, $adapter);

        $adapter->shouldReceive('write')->with($key, $data)->andReturn(11);

        $this->assertEquals(11, $sut->write($data));
    }

    public function testWriteUnsuccessful()
    {
        $key = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);
        $data = 'lorem ipsum';

        $sut = new File($key, $adapter);

        $adapter->shouldReceive('write')->with($key, $data)->andReturn(false);

        $this->assertFalse($sut->write($data));
    }

    public function testRenameSuccessful()
    {
        $key = 'foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new File($key, $adapter);
        $adapter->shouldReceive('rename')->with('foo', 'bar')->andReturn(true);

        $this->assertEquals(true, $sut->rename('bar'));
    }

    public function testRenameUnsuccessful()
    {
        $key = 'foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new File($key, $adapter);
        $adapter->shouldReceive('rename')->with('foo', 'bar')->andReturn(false);

        $this->assertEquals(false, $sut->rename('bar'));
    }
}
