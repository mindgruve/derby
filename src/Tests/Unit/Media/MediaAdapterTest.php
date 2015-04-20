<?php

namespace Derby\Tests\Unit\Media;

use Derby\Exception\UnsupportedMethodException;
use Derby\Media\MediaAdapter;
use Mockery;

class MediaAdapterTest extends \PHPUnit_Framework_TestCase
{

    protected static $fileSystemClass = 'Derby\Media\FileSystem';
    protected static $adapterInterface = 'Derby\AdapterInterface';
    protected static $embedAdapterInterface = 'Derby\Adapter\EmbedAdapterInterface';
    protected static $cdnAdapterInterface = 'Derby\Adapter\CdnAdapterInterface';
    protected static $imageAdapterInterface = 'Derby\Adapter\ImageAdapterInterface';
    protected static $fileAdapterInterface = 'Derby\Adapter\FileAdapterInterface';
    protected static $collectionAdapterInterface = 'Derby\Adapter\CollectionAdapterInterface';


    public function testGetAdapterType()
    {
        $capabilities = array();
        $adapterType  = 'Adapter/Generic';
        $adapter      = Mockery::mock(self::$adapterInterface);

        $sut = new MediaAdapter($adapter);

        $adapter->shouldReceive('getCapabilities')->andReturn($capabilities);
        $adapter->shouldReceive('getAdapterType')->andReturn($adapterType);
        $this->assertEquals($adapterType, $sut->getAdapterType());
    }

    public function testRenderSuccess()
    {
        $renderOutput = '';
        $key          = 'foo';
        $adapter      = Mockery::mock(self::$embedAdapterInterface);

        $sut = new MediaAdapter($adapter);

        $adapter->shouldReceive('render')->with($key)->andReturn($renderOutput);
        $this->assertEquals($renderOutput, $sut->render($key));
    }

    public function testRenderException()
    {
        $key     = 'foo';
        $adapter = Mockery::mock(self::$adapterInterface);

        $sut = new MediaAdapter($adapter);

        $adapter->shouldReceive('render')->never();

        try {
            $sut->render($key);
        } catch (\Exception $e) {
            $this->assertTrue($e instanceof UnsupportedMethodException);
        }
    }

    public function testGetUrlSuccess()
    {
        $url     = '/image/foo.jpg';
        $adapter = Mockery::mock(self::$cdnAdapterInterface);
        $key     = 'foo.jpg';

        $sut = new MediaAdapter($adapter);

        $adapter->shouldReceive('getUrl')->with($key)->andReturn($url);
        $this->assertEquals($url, $sut->getUrl($key));
    }

    public function testGetUrlException()
    {
        $capabilities = array();
        $adapter      = Mockery::mock(self::$adapterInterface);
        $key          = 'foo.jpg';

        $sut = new MediaAdapter($adapter);

        $adapter->shouldReceive('getCapabilities')->andReturn($capabilities);
        $adapter->shouldReceive('getUrl')->never();


        try {
            $sut->getUrl($key);
        } catch (\Exception $e) {
            $this->assertTrue($e instanceof UnsupportedMethodException);
        }
    }

    public function testResizeSuccess()
    {
        $adapter   = Mockery::mock(self::$imageAdapterInterface);
        $height    = 200;
        $width     = 200;
        $quality   = 100;
        $mode      = null;
        $resizeUrl = '/thumbnails/foo-200x200.jpg';

        $sut = new MediaAdapter($adapter);

        $adapter->shouldReceive('resize')->with($height, $width, $quality, $mode)->andReturn($resizeUrl);
        $this->assertEquals($resizeUrl, $sut->resize($height, $width, $quality, $mode));
    }

    public function testResizeException()
    {
        $capabilities = array();

        $adapter = Mockery::mock(self::$adapterInterface);
        $height  = 200;
        $width   = 200;
        $quality = 100;
        $mode    = null;

        $sut = new MediaAdapter($adapter);

        $adapter->shouldReceive('getCapabilities')->andReturn($capabilities);
        $adapter->shouldReceive('resize')->never();

        try {
            $sut->resize($height, $width, $quality, $mode);
        } catch (\Exception $e) {
            $this->assertTrue($e instanceof UnsupportedMethodException);
        }
    }

    public function testRead()
    {
        $data    = 'lorem ipsum';
        $adapter = Mockery::mock(self::$fileAdapterInterface);
        $key     = 'foo.jpg';

        $sut = new MediaAdapter($adapter);

        $adapter->shouldReceive('read')->with($key)->andReturn($data);
        $adapter->shouldReceive('exists')->andReturn(true);
        $this->assertEquals($data, $sut->read($key));
    }

    public function testReadException()
    {
        $adapter = Mockery::mock(self::$fileAdapterInterface);
        $key     = 'foo.jpg';

        $sut = new MediaAdapter($adapter);

        $adapter->shouldReceive('read')->never();

        try {
            $sut->read($key);
        } catch (\Exception $e) {
            $this->assertTrue($e instanceof UnsupportedMethodException);
        }
    }

    public function testWrite()
    {
        $data    = 'lorem ipsum';
        $adapter = Mockery::mock(self::$fileAdapterInterface);
        $key     = 'foo.jpg';

        $sut = new MediaAdapter($adapter);

        $adapter->shouldReceive('write')->with($key, $data)->andReturn(11);
        $adapter->shouldReceive('exists')->andReturn(false);
        $this->assertEquals(11, $sut->write($key, $data));
    }

    public function testWriteException()
    {
        $data    = 'lorem ipsum';
        $adapter = Mockery::mock(self::$adapterInterface);
        $key     = 'foo.jpg';

        $sut = new MediaAdapter($adapter);

        $adapter->shouldReceive('write')->never();

        try {
            $sut->write($key, $data);
        } catch (\Exception $e) {
            $this->assertTrue($e instanceof UnsupportedMethodException);
        }
    }

    public function testDelete()
    {
        $adapter = Mockery::mock(self::$fileAdapterInterface);
        $key     = 'foo.jpg';

        $sut = new MediaAdapter($adapter);

        $adapter->shouldReceive('delete')->with($key)->andReturn(true);
        $adapter->shouldReceive('exists')->andReturn(true);
        $this->assertEquals(true, $sut->delete($key));
    }

    public function testDeleteException()
    {
        $capabilities = array();
        $adapter      = Mockery::mock(self::$fileAdapterInterface);
        $key          = 'foo.jpg';

        $sut = new MediaAdapter($adapter);

        $adapter->shouldReceive('getCapabilities')->andReturn($capabilities);
        $adapter->shouldReceive('delete')->never();

        try {
            $sut->delete($key);
        } catch (\Exception $e) {
            $this->assertTrue($e instanceof UnsupportedMethodException);
        }
    }

    public function testRename()
    {
        $adapter = Mockery::mock(self::$fileAdapterInterface);
        $key     = 'foo.jpg';
        $newKey  = 'bar.jpg';

        $sut = new MediaAdapter($adapter);

        $adapter->shouldReceive('rename')->with($key, $newKey)->andReturn(true);
        $adapter->shouldReceive('exists')->with($key)->andReturn(true);
        $adapter->shouldReceive('exists')->with($newKey)->andReturn(false);
        $this->assertEquals(true, $sut->rename($key, $newKey));
    }

    public function testRenameException()
    {
        $capabilities = array();
        $adapter      = Mockery::mock(self::$adapterInterface);
        $key          = 'foo.jpg';
        $newKey       = 'bar.jpg';

        $sut = new MediaAdapter($adapter);

        $adapter->shouldReceive('getCapabilities')->andReturn($capabilities);
        $adapter->shouldReceive('rename')->never();

        try {
            $sut->rename($key, $newKey);
        } catch (\Exception $e) {
            $this->assertTrue($e instanceof UnsupportedMethodException);
        }
    }

    public function testListItemsSuccessful()
    {
        $adapter = Mockery::mock(self::$collectionAdapterInterface);
        $items   = array('/foo.jpg', '/bar.jpg');
        $key     = 'foo';

        $sut = new MediaAdapter($adapter);

        $adapter->shouldReceive('listItems')->andReturn($items);

        $this->assertEquals($items, $sut->listItems($key));
    }

    public function testListItemsException()
    {
        $capabilities = array();
        $adapter      = Mockery::mock(self::$adapterInterface);
        $key          = 'foo';

        $sut = new MediaAdapter($adapter);

        $adapter->shouldReceive('getCapabilities')->andReturn($capabilities);
        $adapter->shouldReceive('listItems')->never();

        try {
            $sut->listItems($key);
        } catch (\Exception $e) {
            $this->assertTrue($e instanceof UnsupportedMethodException);
        }
    }
}
