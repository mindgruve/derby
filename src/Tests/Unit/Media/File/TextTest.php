<?php

namespace Derby\Tests\Unit\File;

use Derby\Media\File;
use PHPUnit_Framework_TestCase;
use Mockery;
use Derby\Media\File\Html;
use Derby\Media\File\Text;

class TextTest extends PHPUnit_Framework_TestCase
{

    protected static $fileAdapterInterface = 'Derby\Adapter\FileAdapterInterface';

    public function testInterface()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new Text($key, $adapter);

        $this->assertTrue($sut instanceof File);
    }

    public function testType()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new Text($key, $adapter);

        $this->assertEquals(Text::TYPE_MEDIA_FILE_TEXT, $sut->getMediaType());
    }
}
