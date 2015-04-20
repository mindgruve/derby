<?php

namespace Derby\Tests\Unit\Media;

use Derby\Media\File;
use Mockery;
use Derby\Media\FileInterface;
use PHPUnit_Framework_TestCase;
use Derby\Media;

class FileTest extends PHPUnit_Framework_TestCase
{

    protected static $fileClass = 'Derby\Media\File';
    protected static $media = 'Derby\Media';
    protected static $collectionClass = 'Derby\Media\Collection';
    protected static $fileSystem = 'Derby\Media\FileSystem';
    protected static $metaDataClass = 'Derby\Media\MetaData';


    public function testInterface()
    {
        $key        = '/foo';
        $metaData   = Mockery::mock(self::$metaDataClass);
        $filesystem = Mockery::mock(self::$fileSystem);

        $sut = new File($key, $filesystem, $metaData);

        $this->assertTrue($sut instanceof \Derby\Media);
        $this->assertTrue($sut instanceof FileInterface);
    }

    public function testConstructor()
    {
        $key        = '/foo';
        $metaData   = Mockery::mock(self::$metaDataClass);
        $filesystem = Mockery::mock(self::$fileSystem);

        $sut = new File($key, $filesystem, $metaData);

        $this->assertEquals($key, $sut->getKey());
        $this->assertEquals($metaData, $sut->getMetaData());
    }


    public function testType()
    {
        $key        = '/foo';
        $metaData   = Mockery::mock(self::$metaDataClass);
        $filesystem = Mockery::mock(self::$fileSystem);

        $sut = new File($key, $filesystem, $metaData);

        $this->assertEquals(FileInterface::TYPE_MEDIA_FILE, $sut->getMediaType());
    }

    public function testRemoveSuccessful()
    {
        /**
         * If file is successfully removed, then the modified date should be updated
         */

        $key        = '/foo';
        $metaData   = Mockery::mock(self::$metaDataClass)->makePartial();
        $filesystem = Mockery::mock(self::$fileSystem);
        $now        = new \DateTime();

        $sut = new File($key, $filesystem, $metaData);
        $filesystem->shouldReceive('delete')->andReturn(true);

        $this->assertTrue($sut->remove());
        $this->assertEquals($now->format('m/d/Y'), $sut->getMetaData()->getDateModified()->format('m/d/Y'));
    }

    public function testRemoveUnsuccessful()
    {
        /**
         * If file is not successfully removed, then the modified date should not be updated
         */

        $key          = '/foo';
        $metaData     = Mockery::mock(self::$metaDataClass)->makePartial();
        $filesystem   = Mockery::mock(self::$fileSystem);
        $dateModified = new \DateTime('1/1/2001');
        $metaData->setDateModified($dateModified);

        $sut = new File($key, $filesystem, $metaData);
        $filesystem->shouldReceive('delete')->andReturn(false);

        $this->assertFalse($sut->remove());
        $this->assertEquals($dateModified, $sut->getMetaData()->getDateModified());
    }

    public function testReadSuccessful()
    {
        /**
         * If file is able to be read, then an string should be returned
         */

        $key          = '/foo';
        $metaData     = Mockery::mock(self::$metaDataClass);
        $filesystem   = Mockery::mock(self::$fileSystem);

        $sut = new File($key, $filesystem, $metaData);
        $filesystem->shouldReceive('read')->andReturn('lorem ipsum');

        $this->assertEquals('lorem ipsum', $sut->read());
    }

    public function testReadUnsuccessful()
    {
        /**
         * If file is unable to be read then false should be returned
         */

        $key          = '/foo';
        $metaData     = Mockery::mock(self::$metaDataClass);
        $filesystem   = Mockery::mock(self::$fileSystem);

        $sut = new File($key, $filesystem, $metaData);
        $filesystem->shouldReceive('read')->andReturn(false);

        $this->assertEquals(false, $sut->read());
    }

    public function testWriteSuccessful()
    {
        /**
         * If file is able to be written, then the modified date is updated, and an integer should be returned
         */

        $key          = '/foo';
        $metaData     = Mockery::mock(self::$metaDataClass)->makePartial();
        $filesystem   = Mockery::mock(self::$fileSystem);
        $data         = 'lorem ipsum';

        $sut = new File($key, $filesystem, $metaData);
        
        $filesystem->shouldReceive('write')->with($key, $data)->andReturn(11);
        $now = new \DateTime();

        $this->assertEquals(11, $sut->write($data));
        $this->assertEquals($now->format('m/d/Y'), $sut->getMetaData()->getDateModified()->format('m/d/Y'));
    }

    public function testWriteUnsuccessful()
    {
        /**
         * If file is unable to be written, then the modified date is not updated, and false should be returned
         */

        $key          = '/foo';
        $metaData     = Mockery::mock(self::$metaDataClass)->makePartial();
        $filesystem   = Mockery::mock(self::$fileSystem);
        $data         = 'lorem ipsum';
        $dateModified = new \DateTime('1/1/2001');
        $metaData->setDateModified($dateModified);

        $sut = new File($key, $filesystem, $metaData);
        $filesystem->shouldReceive('write')->with($key, $data)->andReturn(false);

        $this->assertFalse($sut->write($data));
        $this->assertEquals($dateModified, $sut->getMetaData()->getDateModified());
    }

    public function testRenameSuccessful()
    {
        /**
         * If file is able to be oved, then the modified date is updated, and true should be returned
         */

        $key          = '/foo';
        $metaData     = Mockery::mock(self::$metaDataClass)->makePartial();
        $filesystem   = Mockery::mock(self::$fileSystem);

        $sut = new File($key, $filesystem, $metaData);
        $filesystem->shouldReceive('rename')->with('/foo', 'bar')->andReturn(true);
        $now = new \DateTime();

        $this->assertEquals(true, $sut->rename('bar'));
        $this->assertEquals($now->format('m/d/Y'), $sut->getMetaData()->getDateModified()->format('m/d/Y'));
    }

    public function testRenameUnsuccessful()
    {
        /**
         * If file is unable to be renamed, then the modified date is not updated, and false should be returned
         */

        $key          = '/foo';
        $metaData     = Mockery::mock(self::$metaDataClass)->makePartial();
        $filesystem   = Mockery::mock(self::$fileSystem);
        $dateModified = new \DateTime('1/1/2001');
        $metaData->setDateModified($dateModified);

        $sut = new File($key, $filesystem, $metaData);
        $filesystem->shouldReceive('rename')->with('/foo', 'bar')->andReturn(false);


        $this->assertEquals(false, $sut->rename('bar'));
        $this->assertEquals($dateModified, $sut->getMetaData()->getDateModified());
    }
}
