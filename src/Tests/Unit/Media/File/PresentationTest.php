<?php

namespace Derby\Tests\Unit\File;

use Derby\Media\LocalFile;
use Derby\Media\LocalFile\Presentation;
use PHPUnit_Framework_TestCase;
use Mockery;

class PresentationTest extends PHPUnit_Framework_TestCase
{
    protected static $fileAdapterInterface = 'Derby\Adapter\LocalFileAdapterInterface';

    public function testInterface()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new Presentation($key, $adapter);

        $this->assertTrue($sut instanceof LocalFile);
    }

    public function testType()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new Presentation($key, $adapter);

        $this->assertEquals(Presentation::TYPE_MEDIA_FILE_PRESENTATION, $sut->getMediaType());
    }
}
