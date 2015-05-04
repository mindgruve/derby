<?php

namespace Derby\Tests\Unit\File;

use Derby\Media\LocalFile\Document;
use Derby\Media\LocalFile;
use PHPUnit_Framework_TestCase;
use Mockery;

class DocumentTest extends PHPUnit_Framework_TestCase
{
    protected static $fileAdapterInterface = 'Derby\Adapter\LocalFileAdapterInterface';

    public function testInterface()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new Document($key, $adapter);

        $this->assertTrue($sut instanceof LocalFile);
    }

    public function testType()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new Document($key, $adapter);

        $this->assertEquals(Document::TYPE_MEDIA_FILE_DOCUMENT, $sut->getMediaType());
    }
}
