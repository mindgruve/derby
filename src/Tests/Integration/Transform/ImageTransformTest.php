<?php

namespace Imagine\Test\Integration\Media\Image;

use Derby\Transform\ImageTransform;
use Imagine\Image\Box;
use Imagine\Image\Point;
use PHPUnit_Framework_TestCase;
use Mockery;

class ImageTransformTest extends PHPUnit_Framework_TestCase
{
    public function testImageLibrary()
    {
        if (!extension_loaded('imagick') && !extension_loaded('gd') && !extension_loaded('gmagick')) {
            throw new \Exception('Image library not installed - need to install either imagick, gd, or gmagick');
        }
    }

    public function testImagickResize()
    {

        if (!extension_loaded('imagick')) {
            return;
        }

        $imagine = new \Imagine\Imagick\Imagine;

        /**
         * Based of of examples found on http://www.hundekauf.eu/thumbs.html
         */

        $images = array(
            array(
                'file'      => 'test-236x315.jpg',
                'mime_type' => 'image/jpeg',
                'outbound'  => array(100, 75),
                'inset'     => array(56, 75),
            ),
            array(
                'file'      => 'test-243x284.jpg',
                'mime_type' => 'image/jpeg',
                'outbound'  => array(100, 75),
                'inset'     => array(64, 75),
            ),
            array(
                'file'      => 'test-420x280.jpg',
                'mime_type' => 'image/jpeg',
                'outbound'  => array(100, 75),
                'inset'     => array(100, 67),
            ),
            array(
                'file'      => 'test-420x315.jpg',
                'mime_type' => 'image/jpeg',
                'outbound'  => array(100, 75),
                'inset'     => array(100, 75),
            ),
        );

        foreach ($images as $image) {
            $file     = $image['file'];
            $quality  = 75;
            $mimeType = $image['mime_type'];
            $outbound = $image['outbound'];
            $inset    = $image['inset'];

            $sourceFile = __DIR__ . '/' . $file;


            $sut = new ImageTransform($imagine);

            /**
             * RESIZE TO 100 x 75 OUTBOUND
             */

            $targetFile = __DIR__ . '/../Temp/outbound-100x75---' . $file;

            if (file_exists($targetFile)) {
                unlink($targetFile);
            }

            $sut->resize($sourceFile, $targetFile, 100, 75, ImageTransform::THUMBNAIL_OUTBOUND, $quality);
            $this->assertFileExists($targetFile);
            $imageDimensions = getimagesize($targetFile);
            $this->assertEquals($outbound[0], $imageDimensions[0]);
            $this->assertEquals($outbound[1], $imageDimensions[1]);
            $this->assertEquals($mimeType, $imageDimensions['mime']);

            /**
             * RESIZE TO 100 x 75 INSET
             */

            $targetFile = __DIR__ . '/../Temp/inset-100x75---' . $file;

            if (file_exists($targetFile)) {
                unlink($targetFile);
            }
            $sut->resize($sourceFile, $targetFile, 100, 75, ImageTransform::THUMBNAIL_INSET, $quality);
            $this->assertFileExists($targetFile);
            $imageDimensions = getimagesize($targetFile);
            $this->assertEquals($inset[0], $imageDimensions[0]);
            $this->assertEquals($inset[1], $imageDimensions[1]);
            $this->assertEquals($mimeType, $imageDimensions['mime']);
        }
    }

    public function testImagickCrop()
    {
        if (!extension_loaded('imagick')) {
            return;
        }

        $imagine = new \Imagine\Imagick\Imagine;

        $file       = 'test-236x315.jpg';
        $sourceFile = __DIR__ . '/' . $file;
        $targetFile = __DIR__ . '/../Temp/crop---' . $file;
        $sut        = new ImageTransform($imagine);

        if (file_exists($targetFile)) {
            unlink($targetFile);
        }
        
        $sut->crop($sourceFile, $targetFile, new Point(150, 150), new Box(45, 45));
    }

    public function testImagickRotate()
    {
        if (!extension_loaded('imagick')) {
            return;
        }

        $imagine = new \Imagine\Imagick\Imagine;

        $file       = 'test-236x315.jpg';
        $sourceFile = __DIR__ . '/' . $file;
        $targetFile = __DIR__ . '/../Temp/rotate---' . $file;
        $sut        = new ImageTransform($imagine);

        if (file_exists($targetFile)) {
            unlink($targetFile);
        }
        
        $sut->rotate($sourceFile, $targetFile, 90);
    }

    public function testImagickGreyscale()
    {
        if (!extension_loaded('imagick')) {
            return;
        }

        $imagine = new \Imagine\Imagick\Imagine;

        $file       = 'test-236x315.jpg';
        $sourceFile = __DIR__ . '/' . $file;
        $targetFile = __DIR__ . '/../Temp/greyscale---' . $file;
        $sut        = new ImageTransform($imagine);

        if (file_exists($targetFile)) {
            unlink($targetFile);
        }
        
        $sut->greyscale($sourceFile, $targetFile);
    }

    public function testImagickFlipHorizontally()
    {
        if (!extension_loaded('imagick')) {
            return;
        }

        $imagine = new \Imagine\Imagick\Imagine;

        $file       = 'test-236x315.jpg';
        $sourceFile = __DIR__ . '/' . $file;
        $targetFile = __DIR__ . '/../Temp/flip-horizontally---' . $file;
        $sut        = new ImageTransform($imagine);

        if (file_exists($targetFile)) {
            unlink($targetFile);
        }

        $sut->flipHorizontally($sourceFile, $targetFile);
    }

    public function testImagickFlipVerticaly()
    {
        if (!extension_loaded('imagick')) {
            return;
        }

        $imagine = new \Imagine\Imagick\Imagine;

        $file       = 'test-236x315.jpg';
        $sourceFile = __DIR__ . '/' . $file;
        $targetFile = __DIR__ . '/../Temp/flip-vertically---' . $file;
        $sut        = new ImageTransform($imagine);

        if (file_exists($targetFile)) {
            unlink($targetFile);
        }

        $sut->flipVertically($sourceFile, $targetFile);
    }

    public function testGDResize()
    {
        if (!extension_loaded('gd')) {
            return;
        }

        $imagine = new \Imagine\Gd\Imagine;

        /**
         * Based of of examples found on http://www.hundekauf.eu/thumbs.html
         */

        $images = array(
            array(
                'file'      => 'test-236x315.jpg',
                'mime_type' => 'image/jpeg',
                'outbound'  => array(100, 75),
                'inset'     => array(56, 75),
            ),
            array(
                'file'      => 'test-243x284.jpg',
                'mime_type' => 'image/jpeg',
                'outbound'  => array(100, 75),
                'inset'     => array(64, 75),
            ),
            array(
                'file'      => 'test-420x280.jpg',
                'mime_type' => 'image/jpeg',
                'outbound'  => array(100, 75),
                'inset'     => array(100, 67),
            ),
            array(
                'file'      => 'test-420x315.jpg',
                'mime_type' => 'image/jpeg',
                'outbound'  => array(100, 75),
                'inset'     => array(100, 75),
            ),
        );

        foreach ($images as $image) {
            $file     = $image['file'];
            $quality  = 75;
            $mimeType = $image['mime_type'];
            $outbound = $image['outbound'];
            $inset    = $image['inset'];

            $sourceFile = __DIR__ . '/' . $file;


            $sut = new ImageTransform($imagine);

            /**
             * RESIZE TO 100 x 75 OUTBOUND
             */

            $targetFile = __DIR__ . '/../Temp/outbound-100x75---' . $file;

            if (file_exists($targetFile)) {
                unlink($targetFile);
            }

            $sut->resize($sourceFile, $targetFile, 100, 75, ImageTransform::THUMBNAIL_OUTBOUND, $quality);
            $this->assertFileExists($targetFile);
            $imageDimensions = getimagesize($targetFile);
            $this->assertEquals($outbound[0], $imageDimensions[0]);
            $this->assertEquals($outbound[1], $imageDimensions[1]);
            $this->assertEquals($mimeType, $imageDimensions['mime']);

            /**
             * RESIZE TO 100 x 75 INSET
             */

            $targetFile = __DIR__ . '/../Temp/inset-100x75---' . $file;

            if (file_exists($targetFile)) {
                unlink($targetFile);
            }
            $sut->resize($sourceFile, $targetFile, 100, 75, ImageTransform::THUMBNAIL_INSET, $quality);
            $this->assertFileExists($targetFile);
            $imageDimensions = getimagesize($targetFile);
            $this->assertEquals($inset[0], $imageDimensions[0]);
            $this->assertEquals($inset[1], $imageDimensions[1]);
            $this->assertEquals($mimeType, $imageDimensions['mime']);
        }
    }

    public function testGdCrop()
    {
        if (!extension_loaded('gd')) {
            return;
        }

        $imagine = new \Imagine\Gd\Imagine;

        $file       = 'test-236x315.jpg';
        $sourceFile = __DIR__ . '/' . $file;
        $targetFile = __DIR__ . '/../Temp/crop---' . $file;
        $sut        = new ImageTransform($imagine);

        if (file_exists($targetFile)) {
            unlink($targetFile);
        }
        
        $sut->crop($sourceFile, $targetFile, new Point(150, 150), new Box(45, 45));
    }

    public function testGdRotate()
    {
        if (!extension_loaded('gd')) {
            return;
        }

        $imagine = new \Imagine\Gd\Imagine;

        $file       = 'test-236x315.jpg';
        $sourceFile = __DIR__ . '/' . $file;
        $targetFile = __DIR__ . '/../Temp/rotate---' . $file;
        $sut        = new ImageTransform($imagine);

        if (file_exists($targetFile)) {
            unlink($targetFile);
        }
        
        $sut->rotate($sourceFile, $targetFile, 90);
    }

    public function testGdGreyscale()
    {
        if (!extension_loaded('gd')) {
            return;
        }

        $imagine = new \Imagine\Gd\Imagine;

        $file       = 'test-236x315.jpg';
        $sourceFile = __DIR__ . '/' . $file;
        $targetFile = __DIR__ . '/../Temp/greyscale---' . $file;
        $sut        = new ImageTransform($imagine);

        if (file_exists($targetFile)) {
            unlink($targetFile);
        }

        $sut->greyscale($sourceFile, $targetFile);
    }

    public function testGdFlipHorizontally()
    {
        if (!extension_loaded('gd')) {
            return;
        }

        $imagine = new \Imagine\Gd\Imagine;

        $file       = 'test-236x315.jpg';
        $sourceFile = __DIR__ . '/' . $file;
        $targetFile = __DIR__ . '/../Temp/flip-horizontally---' . $file;
        $sut        = new ImageTransform($imagine);

        if (file_exists($targetFile)) {
            unlink($targetFile);
        }

        $sut->flipHorizontally($sourceFile, $targetFile);
    }

    public function testGdFlipVerticaly()
    {
        if (!extension_loaded('gd')) {
            return;
        }

        $imagine = new \Imagine\Gd\Imagine;

        $file       = 'test-236x315.jpg';
        $sourceFile = __DIR__ . '/' . $file;
        $targetFile = __DIR__ . '/../Temp/flip-vertically---' . $file;
        $sut        = new ImageTransform($imagine);

        if (file_exists($targetFile)) {
            unlink($targetFile);
        }

        $sut->flipVertically($sourceFile, $targetFile);
    }

    public function testGmagickResize()
    {

        if (!extension_loaded('gmagick')) {
            return;
        }

        $imagine = new \Imagine\Gd\Imagine;

        /**
         * Based of of examples found on http://www.hundekauf.eu/thumbs.html
         */

        $images = array(
            array(
                'file'      => 'test-236x315.jpg',
                'mime_type' => 'image/jpeg',
                'outbound'  => array(100, 75),
                'inset'     => array(56, 75),
            ),
            array(
                'file'      => 'test-243x284.jpg',
                'mime_type' => 'image/jpeg',
                'outbound'  => array(100, 75),
                'inset'     => array(64, 75),
            ),
            array(
                'file'      => 'test-420x280.jpg',
                'mime_type' => 'image/jpeg',
                'outbound'  => array(100, 75),
                'inset'     => array(100, 67),
            ),
            array(
                'file'      => 'test-420x315.jpg',
                'mime_type' => 'image/jpeg',
                'outbound'  => array(100, 75),
                'inset'     => array(100, 75),
            ),
        );

        foreach ($images as $image) {
            $file     = $image['file'];
            $quality  = 75;
            $mimeType = $image['mime_type'];
            $outbound = $image['outbound'];
            $inset    = $image['inset'];

            $sourceFile = __DIR__ . '/' . $file;


            $sut = new ImageTransform($imagine);

            /**
             * RESIZE TO 100 x 75 OUTBOUND
             */

            $targetFile = __DIR__ . '/../Temp/outbound-100x75---' . $file;

            if (file_exists($targetFile)) {
                unlink($targetFile);
            }

            $sut->resize($sourceFile, $targetFile, 100, 75, ImageTransform::THUMBNAIL_OUTBOUND, $quality);
            $this->assertFileExists($targetFile);
            $imageDimensions = getimagesize($targetFile);
            $this->assertEquals($outbound[0], $imageDimensions[0]);
            $this->assertEquals($outbound[1], $imageDimensions[1]);
            $this->assertEquals($mimeType, $imageDimensions['mime']);

            /**
             * RESIZE TO 100 x 75 INSET
             */

            $targetFile = __DIR__ . '/../Temp/inset-100x75---' . $file;

            if (file_exists($targetFile)) {
                unlink($targetFile);
            }
            $sut->resize($sourceFile, $targetFile, 100, 75, ImageTransform::THUMBNAIL_INSET, $quality);
            $this->assertFileExists($targetFile);
            $imageDimensions = getimagesize($targetFile);
            $this->assertEquals($inset[0], $imageDimensions[0]);
            $this->assertEquals($inset[1], $imageDimensions[1]);
            $this->assertEquals($mimeType, $imageDimensions['mime']);
        }
    }

    public function testGmagickCrop()
    {
        if (!extension_loaded('gmagick')) {
            return;
        }

        $imagine = new \Imagine\Gmagick\Imagine;

        $file       = 'test-236x315.jpg';
        $sourceFile = __DIR__ . '/' . $file;
        $targetFile = __DIR__ . '/../Temp/crop---' . $file;
        $sut        = new ImageTransform($imagine);

        if (file_exists($targetFile)) {
            unlink($targetFile);
        }
        
        $sut->crop($sourceFile, $targetFile, new Point(150, 150), new Box(45, 45));
    }

    public function testGmagickRotate()
    {
        if (!extension_loaded('gmagick')) {
            return;
        }

        $imagine = new \Imagine\Gmagick\Imagine;

        $file       = 'test-236x315.jpg';
        $sourceFile = __DIR__ . '/' . $file;
        $targetFile = __DIR__ . '/../Temp/rotate---' . $file;
        $sut        = new ImageTransform($imagine);

        if (file_exists($targetFile)) {
            unlink($targetFile);
        }
        
        $sut->rotate($sourceFile, $targetFile, 90);
    }

    public function testGmagickGreyscale()
    {
        if (!extension_loaded('gmagic')) {
            return;
        }

        $imagine = new \Imagine\Gmagick\Imagine;

        $file       = 'test-236x315.jpg';
        $sourceFile = __DIR__ . '/' . $file;
        $targetFile = __DIR__ . '/../Temp/greyscale---' . $file;
        $sut        = new ImageTransform($imagine);

        if (file_exists($targetFile)) {
            unlink($targetFile);
        }

        $sut->greyscale($sourceFile, $targetFile);
    }

    public function testGmagickFlipHorizontally()
    {
        if (!extension_loaded('gmagick')) {
            return;
        }

        $imagine = new \Imagine\Gmagick\Imagine;

        $file       = 'test-236x315.jpg';
        $sourceFile = __DIR__ . '/' . $file;
        $targetFile = __DIR__ . '/../Temp/flip-horizontally---' . $file;
        $sut        = new ImageTransform($imagine);

        if (file_exists($targetFile)) {
            unlink($targetFile);
        }

        $sut->flipHorizontally($sourceFile, $targetFile);
    }

    public function testGmagickFlipVerticaly()
    {
        if (!extension_loaded('gmagick')) {
            return;
        }

        $imagine = new \Imagine\Gmagick\Imagine;

        $file       = 'test-236x315.jpg';
        $sourceFile = __DIR__ . '/' . $file;
        $targetFile = __DIR__ . '/../Temp/flip-vertically---' . $file;
        $sut        = new ImageTransform($imagine);

        if (file_exists($targetFile)) {
            unlink($targetFile);
        }

        $sut->flipVertically($sourceFile, $targetFile);
    }
}
