<?php

namespace Derby\Tests\Unit\File;

use Derby\Media\File\Document;
use Derby\Media\File;
use PHPUnit_Framework_TestCase;
use Mockery;

class DocumentTest extends PHPUnit_Framework_TestCase
{
    protected static $fileAdapterInterface = 'Derby\Adapter\FileAdapterInterface';

    public function testInterface()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new Document($key, $adapter);

        $this->assertTrue($sut instanceof File);
    }

    public function testType()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new Document($key, $adapter);

        $this->assertEquals(Document::TYPE_MEDIA_FILE_DOCUMENT, $sut->getMediaType());
    }
}
