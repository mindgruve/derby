<?php

namespace Derby\Tests\Unit\File;

use Derby\Media\File;
use Derby\Media\File\Presentation;
use PHPUnit_Framework_TestCase;
use Mockery;

class PresentationTest extends PHPUnit_Framework_TestCase
{
    protected static $fileAdapterInterface = 'Derby\Adapter\FileAdapterInterface';

    public function testInterface()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new Presentation($key, $adapter);

        $this->assertTrue($sut instanceof File);
    }
}
