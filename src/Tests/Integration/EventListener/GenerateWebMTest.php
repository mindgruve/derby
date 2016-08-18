<?php

namespace Derby\Tests\Integration\EventListener;

use Derby\Adapter\FileAdapter;
use Derby\EventListener\GenerateWebM;
use Gaufrette\Adapter\Local;
use Symfony\Component\EventDispatcher\EventDispatcher;

class GenerateWebMTest extends \PHPUnit_Framework_TestCase
{

    public function testGenerateWebMGD()
    {
        $dispatcher = new EventDispatcher();
        $sut = new GenerateWebM('/tmp', 'cwebp');
        $dispatcher->addSubscriber($sut);

        $sourceKey = 'test-236x315.jpg';
        $targetKey = 'testWebP.jpg';
        $webPKey = 'testWebP.webp';

        $imagine = new \Imagine\Gd\Imagine();


        $sourceAdapter = new FileAdapter('file.source',new Local(__DIR__ . '/../Data/'));
        $targetAdapter = new FileAdapter('file.target',new Local(__DIR__ . '/../Temp/'));

        $sourceImage = new \Derby\Media\File\Image($sourceKey, $sourceAdapter, $imagine, $dispatcher);
        $targetImage = new \Derby\Media\File\Image($targetKey, $targetAdapter, $imagine, $dispatcher);
        $webPImage = new \Derby\Media\File\Image($webPKey, $targetAdapter, $imagine, $dispatcher);
        $sourceImage->save($targetImage);

        $this->assertTrue($targetImage->exists());
        $this->assertTrue($webPImage->exists());

    }

}