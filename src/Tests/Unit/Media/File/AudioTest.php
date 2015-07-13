<?php

namespace Derby\Tests\Unit\File;

use Derby\Media\File;
use Derby\Media\file\Audio;
use PHPUnit_Framework_TestCase;
use Mockery;

class AudioTest extends PHPUnit_Framework_TestCase
{

    protected static $fileAdapterInterface = 'Derby\Adapter\FileAdapterInterface';

    public function testInterface()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new Audio($key, $adapter);

        $this->assertTrue($sut instanceof File);
    }

    public function testType()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new Audio($key, $adapter);

        $this->assertEquals(Audio::TYPE_MEDIA_FILE_AUDIO, $sut->getMediaType());
    }
}
