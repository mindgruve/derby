<?php

namespace Derby\Tests\Unit\File;

use Derby\Media\File\Factory\FileFactory;
use Derby\Media\File\Factory\PdfFactory;
use Derby\Media\File\Pdf;
Use Mockery;

class PdfFactoryTest extends \PHPUnit_Framework_TestCase
{
    protected static $factoryInterface = 'Derby\Media\File\FactoryInterface';
    protected static $fileAdapterInterface = 'Derby\Adapter\FileAdapterInterface';

    public function testInterface()
    {
        $sut = new PdfFactory(array());
        $this->assertTrue($sut instanceof FileFactory);
    }

    public function testBuild()
    {
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new PdfFactory(array());
        $html = $sut->build('foo', $adapter);
        $this->assertTrue($html instanceof Pdf);
    }

}