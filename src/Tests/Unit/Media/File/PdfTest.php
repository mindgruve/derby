<?php

namespace Derby\Tests\Unit\File;

use Derby\Media\LocalFile;
use Derby\Media\Local\Pdf;
use PHPUnit_Framework_TestCase;
use Mockery;

class PdfTest extends PHPUnit_Framework_TestCase
{

    protected static $fileAdapterInterface = 'Derby\Adapter\LocalFileAdapterInterface';

    public function testInterface()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new Pdf($key, $adapter);

        $this->assertTrue($sut instanceof LocalFile);
    }

    public function testType()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new Pdf($key, $adapter);

        $this->assertEquals(Pdf::TYPE_MEDIA_FILE_PDF, $sut->getMediaType());
    }
}
