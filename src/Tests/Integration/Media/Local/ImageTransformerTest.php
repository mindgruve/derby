<?php

namespace Derby\Tests\Integration\Media\Local;

use Derby\Adapter\LocalFileAdapter;
use Derby\Media\LocalFile\ImageTransformer;

class ImageTransformerTest extends \PHPUnit_Framework_TestCase
{
    public function testIdentityTransformeGD()
    {

        if (!extension_loaded('gd')) {
            return;
        }

        $imagine = new \Imagine\Gd\Imagine;

        $key = 'test-236x315.jpg';

        $sourceAdapter = new LocalFileAdapter(__DIR__ . '/../../Data/');
        $targetAdapter = new LocalFileAdapter(__DIR__ . '/../../Temp/');

        $image = new \Derby\Media\LocalFile\Image($key, $sourceAdapter, $imagine);


        $sut = new ImageTransformer();
        $sut->apply($image, 'test-transformer-1.jpg', $targetAdapter);

    }

    public function testGreyScaleGD()
    {
        if (!extension_loaded('gd')) {
            return;
        }

        $imagine = new \Imagine\Gd\Imagine;

        $key = 'test-236x315.jpg';

        $sourceAdapter = new LocalFileAdapter(__DIR__ . '/../../Data/');
        $targetAdapter = new LocalFileAdapter(__DIR__ . '/../../Temp/');
        $image = new \Derby\Media\LocalFile\Image($key, $sourceAdapter, $imagine);
        $sut = new ImageTransformer();

        $sut->addFilter(array(
            'greyscale' => true,
        ));

        $sut->apply($image, 'test-transformer-2.jpg', $targetAdapter);
    }

    public function testFlipHorizontallyGD()
    {
        if (!extension_loaded('gd')) {
            return;
        }

        $imagine = new \Imagine\Gd\Imagine;

        $key = 'test-236x315.jpg';

        $sourceAdapter = new LocalFileAdapter(__DIR__ . '/../../Data/');
        $targetAdapter = new LocalFileAdapter(__DIR__ . '/../../Temp/');
        $image = new \Derby\Media\LocalFile\Image($key, $sourceAdapter, $imagine);
        $sut = new ImageTransformer();

        $sut->addFilter(array(
            'flipHorizontally' => true,
        ));

        $sut->apply($image, 'test-transformer-3.jpg', $targetAdapter);
    }

    public function testFlipVerticallyGD()
    {
        if (!extension_loaded('gd')) {
            return;
        }

        $imagine = new \Imagine\Gd\Imagine;

        $key = 'test-236x315.jpg';

        $sourceAdapter = new LocalFileAdapter(__DIR__ . '/../../Data/');
        $targetAdapter = new LocalFileAdapter(__DIR__ . '/../../Temp/');
        $image = new \Derby\Media\LocalFile\Image($key, $sourceAdapter, $imagine);
        $sut = new ImageTransformer();

        $sut->addFilter(array(
            'flipVertically' => true,
        ));

        $sut->apply($image, 'test-transformer-4.jpg', $targetAdapter);
    }

    public function testResizeGD()
    {
        if (!extension_loaded('gd')) {
            return;
        }

        $imagine = new \Imagine\Gd\Imagine;

        $key = 'test-236x315.jpg';

        $sourceAdapter = new LocalFileAdapter(__DIR__ . '/../../Data/');
        $targetAdapter = new LocalFileAdapter(__DIR__ . '/../../Temp/');
        $image = new \Derby\Media\LocalFile\Image($key, $sourceAdapter, $imagine);
        $sut = new ImageTransformer();

        $sut->addFilter(array(
            'resize' => array(
                'height' => 100,
                'width' => 50
            )
        ));

        $sut->apply($image, 'test-transformer-5.jpg', $targetAdapter);
    }

    public function testCropGD()
    {
        if (!extension_loaded('gd')) {
            return;
        }

        $imagine = new \Imagine\Gd\Imagine;

        $key = 'test-236x315.jpg';

        $sourceAdapter = new LocalFileAdapter(__DIR__ . '/../../Data/');
        $targetAdapter = new LocalFileAdapter(__DIR__ . '/../../Temp/');
        $image = new \Derby\Media\LocalFile\Image($key, $sourceAdapter, $imagine);
        $sut = new ImageTransformer();

        $sut->addFilter(array(
            'crop' => array(
                'x' => 50,
                'y' => 50,
                'height' => 100,
                'width' => 50
            )
        ));

        $sut->apply($image, 'test-transformer-6.jpg', $targetAdapter);
    }

    public function testRotateGD()
    {
        if (!extension_loaded('gd')) {
            return;
        }

        $imagine = new \Imagine\Gd\Imagine;

        $key = 'test-236x315.jpg';

        $sourceAdapter = new LocalFileAdapter(__DIR__ . '/../../Data/');
        $targetAdapter = new LocalFileAdapter(__DIR__ . '/../../Temp/');
        $image = new \Derby\Media\LocalFile\Image($key, $sourceAdapter, $imagine);
        $sut = new ImageTransformer();

        $sut->addFilter(array(
            'rotate' => array(
                'degrees' => 20
            )
        ));

        $sut->apply($image, 'test-transformer-7.jpg', $targetAdapter);
    }

    public function testMultipleFiltersGD()
    {
        if (!extension_loaded('gd')) {
            return;
        }

        $imagine = new \Imagine\Gd\Imagine;

        $key = 'test-236x315.jpg';

        $sourceAdapter = new LocalFileAdapter(__DIR__ . '/../../Data/');
        $targetAdapter = new LocalFileAdapter(__DIR__ . '/../../Temp/');
        $image = new \Derby\Media\LocalFile\Image($key, $sourceAdapter, $imagine);
        $sut = new ImageTransformer();

        $sut->addFilter(array(
            'greyscale' => true,
            'flipVertically' => true,
            'crop' => array(
                'x' => 100,
                'y' => 100,
                'height' => 100,
                'width' => 100
            )
        ));

        $sut->apply($image, 'test-transformer-8.jpg', $targetAdapter);
    }
}