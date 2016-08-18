<?php

namespace Derby\Tests\Unit\File;

use PHPUnit_Framework_TestCase;
use Derby\Media\File;
use Derby\Media\File\Video;
use Mockery;

class VideoTest extends PHPUnit_Framework_TestCase
{

    protected static $fileAdapterInterface = 'Derby\Adapter\FileAdapterInterface';

    public function testInterface()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new Video($key, $adapter);

        $this->assertTrue($sut instanceof File);
    }
}
