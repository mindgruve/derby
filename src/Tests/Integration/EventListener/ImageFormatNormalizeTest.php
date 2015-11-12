<?php

namespace Derby\Tests\Integration\EventListener;

use Derby\Adapter\FileAdapter;
use Derby\EventListener\ImageFormatNormalize;
use Gaufrette\Adapter\Local;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Derby\Media\File\Image;

class ImageFormatNormalizeTest extends \PHPUnit_Framework_TestCase
{

    protected $formats = array(
        'bmp' => 'jpg',
        'ico' => 'png',
        'tiff' => 'jpg',
    );

    public function testImageFormatNormalizeGD()
    {
        $dispatcher = new EventDispatcher();
        $sut = new ImageFormatNormalize('/tmp', 'convert', $this->formats);
        $dispatcher->addSubscriber($sut);

        /**
         * TESTING BMP
         */
        $sourceKey = 'test.bmp';

        $imagine = new \Imagine\Gd\Imagine();
        $sourceAdapter = new FileAdapter(new Local(__DIR__ . '/../Data/'));
        $sourceImage = new Image($sourceKey, $sourceAdapter, $imagine, $dispatcher);
        $sourceImage->load();

        $this->assertEquals('jpg', $sourceImage->getFileExtension());

        /**
         * TESTING TIFF
         */
        $sourceKey = 'test.tiff';

        $imagine = new \Imagine\Gd\Imagine();
        $sourceAdapter = new FileAdapter(new Local(__DIR__ . '/../Data/'));
        $sourceImage = new Image($sourceKey, $sourceAdapter, $imagine, $dispatcher);
        $sourceImage->load();

        $this->assertEquals('jpg', $sourceImage->getFileExtension());
    }
}