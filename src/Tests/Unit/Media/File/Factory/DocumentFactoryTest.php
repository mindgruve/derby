<?php

namespace Derby\Tests\Unit\File;

use Derby\Media\File\Document;
use Derby\Media\File\Factory\DocumentFactory;
use Derby\Media\File\Factory\FileFactory;
Use Mockery;

class DocumentFactoryTest extends \PHPUnit_Framework_TestCase
{
    protected static $factoryInterface = 'Derby\Media\File\FactoryInterface';
    protected static $fileAdapterInterface = 'Derby\Adapter\FileAdapterInterface';

    public function testInterface()
    {
        $sut = new DocumentFactory(array());

        $this->assertTrue($sut instanceof FileFactory);
    }

    public function testBuild()
    {
        $adapter = Mockery::mock(self::$fileAdapterInterface);

        $sut = new DocumentFactory(array());
        $document = $sut->build('foo', $adapter);

        $this->assertTrue($document instanceof Document);
    }

}