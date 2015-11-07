<?php

namespace Derby\Tests\Integration\EventListener;

use Derby\Adapter\FileAdapter;
use Derby\EventListener\MozJpegOptimize;
use Gaufrette\Adapter\Local;
use Symfony\Component\EventDispatcher\EventDispatcher;

class MozJpegOptimizerTest extends \PHPUnit_Framework_TestCase
{

    public function testMozJpegOptimizerGD()
    {
        $dispatcher = new EventDispatcher();
        $sut = new MozJpegOptimize('/opt/mozjpeg/bin/cjpeg', '/tmp');
        $dispatcher->addSubscriber($sut);

        $sourceKey = 'test-236x315.jpg';
        $targetKey = 'testMozJpegOptimizerGD.jpg';

        $imagine = new \Imagine\Gd\Imagine();


        $sourceAdapter = new FileAdapter(new Local(__DIR__ . '/../Data/'));
        $targetAdapter = new FileAdapter(new Local(__DIR__ . '/../Temp/'));

        $sourceImage = new \Derby\Media\File\Image($sourceKey, $sourceAdapter, $imagine, $dispatcher);
        $targetImage = new \Derby\Media\File\Image($targetKey, $targetAdapter, $imagine, $dispatcher);

        /**
         * 100% Quality
         */
        $sourceImage->save($targetImage, 100);
        $localSource = $sourceImage->copyToLocal();
        $localTarget = $targetImage->copyToLocal();
        $this->assertGreaterThanOrEqual($localTarget->getSize(), $localSource->getSize());
        $localSource->delete();
        $localTarget->delete();

        /**
         * 85% Quality
         */
        $sourceImage->save($targetImage, 85);
        $localSource = $sourceImage->copyToLocal();
        $localTarget = $targetImage->copyToLocal();
        $this->assertGreaterThanOrEqual($localTarget->getSize(), $localSource->getSize());
        $localSource->delete();
        $localTarget->delete();

        /**
         * 65% Quality
         */
        $sourceImage->save($targetImage, 65);
        $localSource = $sourceImage->copyToLocal();
        $localTarget = $targetImage->copyToLocal();
        $this->assertGreaterThanOrEqual($localTarget->getSize(), $localSource->getSize());
        $localSource->delete();
        $localTarget->delete();
    }
}