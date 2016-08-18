<?php

namespace Derby\Tests\Unit\File;

use Derby\Media\File;
use PHPUnit_Framework_TestCase;
use Mockery;
use Derby\Media\File\Html;

class HtmlTest extends PHPUnit_Framework_TestCase
{

    protected static $fileAdapterInterface = 'Derby\Adapter\FileAdapterInterface';

    public function testInterface()
    {
        $key     = 'Foo';
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new Html($key, $adapter);

        $this->assertTrue($sut instanceof File);
    }
}
