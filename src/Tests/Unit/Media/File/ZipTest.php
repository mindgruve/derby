<?php

namespace Derby\Tests\Unit\File;

use Derby\Media\File;
use Derby\Media\File\Zip;
use PHPUnit_Framework_TestCase;
use Mockery;

class ZipTest extends PHPUnit_Framework_TestCase
{

    protected static $fileAdapterInterface = 'Derby\Adapter\FileAdapterInterface';

    public function testInterface()
    {
        $key = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new Zip($key, $adapter);

        $this->assertTrue($sut instanceof File);
    }

    public function testType()
    {
        $key = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new Zip($key, $adapter);

        $this->assertEquals(Zip::TYPE_MEDIA_FILE_ZIP, $sut->getMediaType());
    }
}
