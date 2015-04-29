<?php

namespace Derby\Tests\Unit\Media;

use Derby\Media\LocalFile;
use Derby\Media\LocalFileInterface;
use Derby\Media\RemoteFileInterface;
use Mockery;
use PHPUnit_Framework_TestCase;
use Derby\Media;

class LocalFileTest extends PHPUnit_Framework_TestCase
{

    protected static $fileAdapterInterface = 'Derby\Adapter\LocalFileAdapterInterface';
    protected static $remoteFileAdapterInterface = 'Derby\Adapter\RemoteFileAdapterInterface';


    public function testInterface()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new LocalFile($key, $adapter);

        $this->assertTrue($sut instanceof \Derby\Media);
        $this->assertTrue($sut instanceof LocalFileInterface);
    }

    public function testConstructor()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new LocalFile($key, $adapter);

        $this->assertEquals($key, $sut->getKey());
        $this->assertEquals($adapter, $sut->getAdapter());
    }


    public function testType()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new LocalFile($key, $adapter);

        $this->assertEquals(LocalFileInterface::TYPE_MEDIA_LOCAL_FILE, $sut->getMediaType());
    }

    public function testDeleteSuccessful()
    {

        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new LocalFile($key, $adapter);
        $adapter->shouldReceive('delete')->andReturn(true);

        $this->assertTrue($sut->delete());
    }

    public function testDeleteUnsuccessful()
    {

        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new LocalFile($key, $adapter);
        $adapter->shouldReceive('delete')->andReturn(false);

        $this->assertFalse($sut->delete());
    }

    public function testReadSuccessful()
    {

        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new LocalFile($key, $adapter);
        $adapter->shouldReceive('read')->andReturn('lorem ipsum');

        $this->assertEquals('lorem ipsum', $sut->read());
    }

    public function testReadUnsuccessful()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new LocalFile($key, $adapter);
        $adapter->shouldReceive('read')->andReturn(false);

        $this->assertEquals(false, $sut->read());
    }

    public function testWriteSuccessful()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);
        $data    = 'lorem ipsum';

        $sut = new LocalFile($key, $adapter);

        $adapter->shouldReceive('write')->with($key, $data)->andReturn(11);

        $this->assertEquals(11, $sut->write($data));
    }

    public function testWriteUnsuccessful()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);
        $data    = 'lorem ipsum';

        $sut = new LocalFile($key, $adapter);

        $adapter->shouldReceive('write')->with($key, $data)->andReturn(false);

        $this->assertFalse($sut->write($data));
    }

    public function testRenameSuccessful()
    {
        $key     = 'foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new LocalFile($key, $adapter);
        $adapter->shouldReceive('rename')->with('foo', 'bar')->andReturn(true);

        $this->assertEquals(true, $sut->rename('bar'));
    }

    public function testRenameUnsuccessful()
    {
        $key     = 'foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new LocalFile($key, $adapter);
        $adapter->shouldReceive('rename')->with('foo', 'bar')->andReturn(false);

        $this->assertEquals(false, $sut->rename('bar'));
    }

//    public function testUploadSuccessful()
//    {
//        $key     = 'foo';
//        $adapter = Mockery::mock(self::$fileAdapterInterface);
//        $remoteAdapter = Mockery::mock(self::$remoteFileAdapterInterface);
//
//        $sut = new LocalFile($key, $adapter);
//
//        // local adapter will receive a read to get contents of file.
//        // remote adapter will receive a write and return amt of bytes written
//        $adapter->shouldReceive('read')->andReturn('foo bar');
//        $remoteAdapter->shouldReceive('write');
//
//        // upload call on local file should return remote file interface
//        $this->assertTrue($sut->upload($remoteAdapter) instanceof RemoteFileInterface);
//    }
}
