<?php


namespace Derby\Tests\Unit\Media;

use Derby\Media\MediaInterface;
use Derby\Media\File;
use Derby\Media\Media;
use Mockery;
use PHPUnit_Framework_TestCase;

class MediaTest extends PHPUnit_Framework_TestCase
{

    protected static $media = 'Derby\Media\Media';
    protected static $collectionClass = 'Derby\Media\Collection';
    protected static $adapterClass = 'Derby\Interfaces\MediaAdapterInterface';
    protected static $metaDataClass = 'Derby\Media\MetaData';

    public function testInterface()
    {
        $metaData   = Mockery::mock(self::$metaDataClass);

        $sut = new Media($metaData);

        $this->assertTrue($sut instanceof Media);
        $this->assertTrue($sut instanceof MediaInterface);
    }

    public function testConstructor()
    {
        $metaData   = Mockery::mock(self::$metaDataClass);

        $sut = new Media($metaData);

        $this->assertEquals($metaData, $sut->getMetaData());
    }
}
