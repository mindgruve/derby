<?php

namespace Derby\Tests\Integration\Media\File;

use Derby\Adapter\FileAdapter;
use Derby\Adapter\LocalFileAdapter;
use Derby\Media\File\Image;
use Derby\Media\File\ImageTransformer;
use Gaufrette\Adapter\Local;

class ImageGDTransformerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Derby\Media\LocalFile\Image
     */
    protected $originalFile;

    /**
     * @var \Derby\Media\LocalFile\Image
     */
    protected $newFile;

    /**
     * @param $index
     */
    protected function setUpImages($index)
    {
        $imagine = new \Imagine\Gd\Imagine;
        $sourceKey = 'test-236x315.jpg';
        $targetKey = 'transform' . $index . '.jpg';
        $sourceAdapter = new FileAdapter(new Local(__DIR__ . '/../../Data/'));
        $targetAdapter = new FileAdapter(new Local(__DIR__ . '/../../Temp/'));
        $this->originalFile = new Image($sourceKey, $sourceAdapter, $imagine);
        $this->newFile = new Image('transform' . $index . '.jpg', $targetAdapter, $imagine);
        if($targetAdapter->exists($targetKey)){
            $targetAdapter->delete($targetKey);
        }
    }


    public function testGreyScaleGD()
    {
        if (!extension_loaded('gd')) {
            return;
        }

        $this->setUpImages(1);
        $sut = new ImageTransformer();
        $sut->addFilter(
            'greyscale',
            array(
                'greyscale' => true,
            ));

        $sut->apply('greyscale', $this->originalFile)->save($this->newFile);
    }

    public function testFlipHorizontallyGD()
    {
        if (!extension_loaded('gd')) {
            return;
        }

        $this->setUpImages(2);
        $sut = new ImageTransformer();

        $sut->addFilter(
            'fliphorizontally',
            array(
                'flipHorizontally' => true,
            ));

        $sut->apply('fliphorizontally', $this->originalFile)->save($this->newFile);
    }

    public function testFlipVerticallyGD()
    {
        if (!extension_loaded('gd')) {
            return;
        }

        $this->setUpImages(3);
        $sut = new ImageTransformer();

        $sut->addFilter(
            'flipvertically',
            array(
                'flipVertically' => true,
            ));

        $sut->apply('flipvertically', $this->originalFile)->save($this->newFile);
    }

    public function testResizeGD()
    {
        if (!extension_loaded('gd')) {
            return;
        }

        $this->setUpImages(4);
        $sut = new ImageTransformer();

        $sut->addFilter(
            'resize',
            array(
                'resize' => array(
                    'height' => 100,
                    'width' => 50
                )
            ));

        $sut->apply('resize', $this->originalFile)->save($this->newFile);
    }

    public function testCropGD()
    {
        if (!extension_loaded('gd')) {
            return;
        }

        $this->setUpImages(5);
        $sut = new ImageTransformer();

        $sut->addFilter('crop',
            array(
                'crop' => array(
                    'x' => 50,
                    'y' => 50,
                    'height' => 100,
                    'width' => 50
                )
            ));

        $sut->apply('crop', $this->originalFile)->save($this->newFile);
    }

    public function testRotateGD()
    {
        if (!extension_loaded('gd')) {
            return;
        }

        $this->setUpImages(6);
        $sut = new ImageTransformer();

        $sut->addFilter(
            'rotate',
            array(
                'rotate' => array(
                    'degrees' => 20
                )
            ));

        $sut->apply('rotate', $this->originalFile)->save($this->newFile);
    }

    public function testMultipleFiltersGD()
    {
        if (!extension_loaded('gd')) {
            return;
        }

        $this->setUpImages(7);
        $sut = new ImageTransformer();

        $sut->addFilter(
            'multiple',
            array(
                'greyscale' => true,
                'flipVertically' => true,
                'crop' => array(
                    'x' => 100,
                    'y' => 100,
                    'height' => 100,
                    'width' => 100
                )
            ));

        $sut->apply('multiple', $this->originalFile)->save($this->newFile);
    }
}