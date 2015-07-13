<?php
/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 */

namespace Derby\Tests\Unit\Media;

use Derby\Adapter\LocalFileAdapter;
use Derby\Media\RemoteFile;
use Derby\Media\RemoteFileInterface;
use Mockery;
use PHPUnit_Framework_TestCase;
use Derby\Media;

/**
 * Derby\Tests\Unit\Media\RemoteFileTest
 *
 * @author Kevin Simpson <simpkevin@gmail.com>
 * @author John Pancoast <shideon@gmail.com>
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class RemoteFileTest extends PHPUnit_Framework_TestCase
{

    protected static $test = 'Derby\Test';
    protected static $config = 'Derby\Config';
    protected static $localFile = 'Derby\Media\LocalFileInterface';
    protected static $localTextFile = '\Derby\Media\Local\Text';
    protected static $fileAdapterInterface = 'Derby\Adapter\RemoteFileAdapterInterface';
    protected static $localFileAdapter = 'Derby\Adapter\LocalFileAdapter';
    protected static $localFileAdapterInterface = 'Derby\Adapter\LocalFileAdapterInterface';

    public function testInterface()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new RemoteFile($key, $adapter);

        $this->assertTrue($sut instanceof \Derby\Media);
        $this->assertTrue($sut instanceof RemoteFileInterface);
    }

    public function testConstructor()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new RemoteFile($key, $adapter);

        $this->assertEquals($key, $sut->getKey());
        $this->assertEquals($adapter, $sut->getAdapter());
    }


    public function testType()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new RemoteFile($key, $adapter);

        $this->assertEquals(RemoteFile::TYPE_MEDIA_REMOTE_FILE, $sut->getMediaType());
    }

    public function testDeleteSuccessful()
    {

        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new RemoteFile($key, $adapter);
        $adapter->shouldReceive('delete')->andReturn(true);

        $this->assertTrue($sut->delete());
    }

    public function testDeleteUnsuccessful()
    {

        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new RemoteFile($key, $adapter);
        $adapter->shouldReceive('delete')->andReturn(false);

        $this->assertFalse($sut->delete());
    }

    public function testReadSuccessful()
    {

        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new RemoteFile($key, $adapter);
        $adapter->shouldReceive('read')->andReturn('lorem ipsum');

        $this->assertEquals('lorem ipsum', $sut->read());
    }

    public function testReadUnsuccessful()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new RemoteFile($key, $adapter);
        $adapter->shouldReceive('read')->andReturn(false);

        $this->assertEquals(false, $sut->read());
    }

    public function testWriteSuccessful()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);
        $data    = 'lorem ipsum';

        $sut = new RemoteFile($key, $adapter);

        $adapter->shouldReceive('write')->with($key, $data)->andReturn(11);

        $this->assertEquals(11, $sut->write($data));
    }

    public function testWriteUnsuccessful()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);
        $data    = 'lorem ipsum';

        $sut = new RemoteFile($key, $adapter);

        $adapter->shouldReceive('write')->with($key, $data)->andReturn(false);

        $this->assertFalse($sut->write($data));
    }

    public function testRenameSuccessful()
    {
        $key     = 'foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new RemoteFile($key, $adapter);
        $adapter->shouldReceive('rename')->with('foo', 'bar')->andReturn(true);

        $this->assertEquals(true, $sut->rename('bar'));
    }

    public function testRenameUnsuccessful()
    {
        $key     = 'foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new RemoteFile($key, $adapter);
        $adapter->shouldReceive('rename')->with('foo', 'bar')->andReturn(false);

        $this->assertEquals(false, $sut->rename('bar'));
    }
}
