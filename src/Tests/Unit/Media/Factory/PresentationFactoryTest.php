<?php

namespace Derby\Tests\Unit\Media\Factory;

use Derby\Media\Factory\FileFactory;
use Derby\Media\Factory\PresentationFactory;
use Derby\Media\File\Presentation;
Use Mockery;

class PresentationFactoryTest extends \PHPUnit_Framework_TestCase
{
    protected static $factoryInterface = 'Derby\Media\FactoryInterface';
    protected static $fileAdapterInterface = 'Derby\Adapter\FileAdapterInterface';

    public function testInterface()
    {
        $sut = new PresentationFactory(array());
        $this->assertTrue($sut instanceof FileFactory);
    }

    public function testBuild()
    {
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new PresentationFactory(array());
        $html = $sut->build('foo', $adapter);
        $this->assertTrue($html instanceof Presentation);
    }

}