<?php

namespace Derby\Tests\Unit\File;

use Derby\Media\LocalFile;
use Derby\Media\LocalFile\Audio;
use PHPUnit_Framework_TestCase;
use Mockery;

class AudioTest extends PHPUnit_Framework_TestCase
{

    protected static $fileAdapterInterface = 'Derby\Adapter\LocalFileAdapterInterface';

    public function testInterface()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new Audio($key, $adapter);

        $this->assertTrue($sut instanceof LocalFile);
    }

    public function testType()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new Audio($key, $adapter);

        $this->assertEquals(Audio::TYPE_MEDIA_FILE_AUDIO, $sut->getMediaType());
    }
}
