<?php

namespace Derby\Tests\Integration\EventListener;

use Derby\Adapter\FileAdapter;
use Derby\EventListener\ImageMaxDimensions;
use Gaufrette\Adapter\Local;
use Symfony\Component\EventDispatcher\EventDispatcher;

class ImageMaxDimensionsTest extends \PHPUnit_Framework_TestCase
{

    public function testImageMaxDimensionsGD()
    {
        $dispatcher = new EventDispatcher();
        $sut = new ImageMaxDimensions('/tmp', 'convert', 100, 100, 2000, 2000);
        $dispatcher->addSubscriber($sut);

        $sourceKey = 'test-236x315.jpg';
        $imagine = new \Imagine\Gd\Imagine();
        $sourceAdapter = new FileAdapter('file.source',new Local(__DIR__ . '/../Data/'));
        $sourceImage = new \Derby\Media\File\Image($sourceKey, $sourceAdapter, $imagine, $dispatcher);
        $sourceImage->load();

        $this->assertEquals(100, $sourceImage->getHeight());
        $this->assertEquals(100, $sourceImage->getHeight());
    }
}