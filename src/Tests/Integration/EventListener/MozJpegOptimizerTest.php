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
        $sut = new MozJpegOptimize();
        $dispatcher->addSubscriber($sut);

        $sourceKey = 'test-236x315.jpg';
        $targetKey = 'testMozJpegOptimizerGD.jpg';

        $imagine = new \Imagine\Gd\Imagine();


        $sourceAdapter = new FileAdapter(new Local(__DIR__ . '/../Data/'));
        $targetAdapter = new FileAdapter(new Local(__DIR__ . '/../Temp/'));

        $sourceFile = new \Derby\Media\File\Image($sourceKey, $sourceAdapter, $imagine, $dispatcher);
        $targetFile = new \Derby\Media\File\Image($targetKey, $targetAdapter, $imagine, $dispatcher);

        $sourceFile->save($targetFile);
    }
}