<?php

/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 */

namespace Derby\Tests\Integration\Media\Local;

use Derby\Adapter\LocalFileAdapter;
use Derby\Manager;
use Derby\Media\LocalFile\Image;
use Imagine\Image\Box;
use Imagine\Image\Point;

/**
 * Derby\Tests\Integration\Media\Local\ImageTest
 *
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 */
class ImageTest extends \PHPUnit_Framework_TestCase
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

        $imagine = new \Imagine\Imagick\Imagine();

        /**
         * Based of of examples found on http://www.hundekauf.eu/thumbs.html
         */

        $images = array(
            array(
                'file' => 'test-236x315.jpg',
                'mime_type' => 'image/jpeg',
                'outbound' => array(100, 75),
                'inset' => array(56, 75),
            ),
            array(
                'file' => 'test-243x284.jpg',
                'mime_type' => 'image/jpeg',
                'outbound' => array(100, 75),
                'inset' => array(64, 75),
            ),
            array(
                'file' => 'test-420x280.jpg',
                'mime_type' => 'image/jpeg',
                'outbound' => array(100, 75),
                'inset' => array(100, 67),
            ),
            array(
                'file' => 'test-420x315.jpg',
                'mime_type' => 'image/jpeg',
                'outbound' => array(100, 75),
                'inset' => array(100, 75),
            ),
        );

        foreach ($images as $image) {
            $key = $image['file'];
            $quality = 75;
            $mimeType = $image['mime_type'];
            $outbound = $image['outbound'];
            $inset = $image['inset'];

            $mediaManager = new Manager();
            $sourceAdapter = new LocalFileAdapter(__DIR__ . '/../../Data/');
            $targetAdapter = new LocalFileAdapter(__DIR__ . '/../../Temp/');
            $sut = new \Derby\Media\LocalFile\Image($key, $sourceAdapter, $imagine);

            /**
             * RESIZE TO 100 x 75 OUTBOUND
             */

            $targetKey = 'imagick-resize-inbound-' . $key;

            if ($mediaManager->exists($targetKey, $targetAdapter)) {
                $targetAdapter->delete($targetKey);
            }

            $target = $sut->resize(
                $targetKey,
                $targetAdapter,
                100,
                75,
                \Derby\Media\LocalFile\Image::THUMBNAIL_OUTBOUND,
                $quality
            );
            $this->assertFileExists($target->getPath());
            $imageDimensions = getimagesize($target->getPath());
            $this->assertEquals($outbound[0], $imageDimensions[0]);
            $this->assertEquals($outbound[1], $imageDimensions[1]);
            $this->assertEquals($mimeType, $imageDimensions['mime']);

            /**
             * RESIZE TO 100 x 75 INSET
             */

            $targetKey = 'imagick-resize-inbound-' . $key;

            if ($mediaManager->exists($targetKey, $targetAdapter)) {
                $targetAdapter->delete($targetKey);
            }

            $target = $sut->resize(
                $targetKey,
                $targetAdapter,
                100,
                75,
                \Derby\Media\LocalFile\Image::THUMBNAIL_INSET,
                $quality
            );
            $this->assertFileExists($target->getPath());
            $imageDimensions = getimagesize($target->getPath());
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

        $key = 'test-236x315.jpg';
        $targetKey = 'imagick-crop-' . $key;

        $mediaManager = new Manager();
        $sourceAdapter = new LocalFileAdapter(__DIR__ . '/../../Data/');
        $targetAdapter = new LocalFileAdapter(__DIR__ . '/../../Temp/');
        $sut = new \Derby\Media\LocalFile\Image($key, $sourceAdapter, $imagine);

        if ($mediaManager->exists($targetKey, $targetAdapter)) {
            $targetAdapter->delete($targetKey);
        }

        $sut->crop($targetKey, $targetAdapter, new Point(150, 150), new Box(45, 45));
    }

    public function testImagickRotate()
    {
        if (!extension_loaded('imagick')) {
            return;
        }

        $imagine = new \Imagine\Imagick\Imagine;

        $key = 'test-236x315.jpg';
        $targetKey = 'imagick-rotate-' . $key;

        $mediaManager = new Manager();
        $sourceAdapter = new LocalFileAdapter(__DIR__ . '/../../Data/');
        $targetAdapter = new LocalFileAdapter(__DIR__ . '/../../Temp/');
        $sut = new \Derby\Media\LocalFile\Image($key, $sourceAdapter, $imagine);

        if ($mediaManager->exists($targetKey, $targetAdapter)) {
            $targetAdapter->delete($targetKey);
        }

        $sut->rotate($targetKey, 90, $targetAdapter);
    }

    public function testImagickGreyscale()
    {
        if (!extension_loaded('imagick')) {
            return;
        }

        $imagine = new \Imagine\Imagick\Imagine;

        $key = 'test-236x315.jpg';
        $targetKey = 'imagick-greyscale-' . $key;

        $mediaManager = new Manager();
        $sourceAdapter = new LocalFileAdapter(__DIR__ . '/../../Data/');
        $targetAdapter = new LocalFileAdapter(__DIR__ . '/../../Temp/');
        $sut = new \Derby\Media\LocalFile\Image($key, $sourceAdapter, $imagine);

        if ($mediaManager->exists($targetKey, $targetAdapter)) {
            $targetAdapter->delete($targetKey);
        }

        $sut->greyscale($targetKey, $targetAdapter);
    }

    public function testImagickFlipHorizontally()
    {
        if (!extension_loaded('imagick')) {
            return;
        }

        $imagine = new \Imagine\Imagick\Imagine;

        $key = 'test-236x315.jpg';
        $targetKey = 'imagick-flip-horizontally-' . $key;

        $mediaManager = new Manager();
        $sourceAdapter = new LocalFileAdapter(__DIR__ . '/../../Data/');
        $targetAdapter = new LocalFileAdapter(__DIR__ . '/../../Temp/');
        $sut = new \Derby\Media\LocalFile\Image($key, $sourceAdapter, $imagine);

        if ($mediaManager->exists($targetKey, $targetAdapter)) {
            $targetAdapter->delete($targetKey);
        }

        $sut->flipHorizontally($targetKey, $targetAdapter);
    }

    public function testImagickFlipVerticaly()
    {
        if (!extension_loaded('imagick')) {
            return;
        }

        $imagine = new \Imagine\Imagick\Imagine;

        $key = 'test-236x315.jpg';
        $targetKey = 'imagick-flip-vertically-' . $key;

        $mediaManager = new Manager();
        $sourceAdapter = new LocalFileAdapter(__DIR__ . '/../../Data/');
        $targetAdapter = new LocalFileAdapter(__DIR__ . '/../../Temp/');
        $sut = new \Derby\Media\LocalFile\Image($key, $sourceAdapter, $imagine);

        if ($mediaManager->exists($targetKey, $targetAdapter)) {
            $targetAdapter->delete($targetKey);
        }

        $sut->flipVertically($targetKey, $targetAdapter);
    }

    public function testGDResize()
    {
        if (!extension_loaded('gd')) {
            return;
        }

        $imagine = new \Imagine\Gd\Imagine();

        /**
         * Based of of examples found on http://www.hundekauf.eu/thumbs.html
         */

        $images = array(
            array(
                'file' => 'test-236x315.jpg',
                'mime_type' => 'image/jpeg',
                'outbound' => array(100, 75),
                'inset' => array(56, 75),
            ),
            array(
                'file' => 'test-243x284.jpg',
                'mime_type' => 'image/jpeg',
                'outbound' => array(100, 75),
                'inset' => array(64, 75),
            ),
            array(
                'file' => 'test-420x280.jpg',
                'mime_type' => 'image/jpeg',
                'outbound' => array(100, 75),
                'inset' => array(100, 67),
            ),
            array(
                'file' => 'test-420x315.jpg',
                'mime_type' => 'image/jpeg',
                'outbound' => array(100, 75),
                'inset' => array(100, 75),
            ),
        );

        foreach ($images as $image) {
            $key = $image['file'];
            $quality = 75;
            $mimeType = $image['mime_type'];
            $outbound = $image['outbound'];
            $inset = $image['inset'];

            $mediaManager = new Manager();
            $sourceAdapter = new LocalFileAdapter(__DIR__ . '/../../Data/');
            $targetAdapter = new LocalFileAdapter(__DIR__ . '/../../Temp/');
            $sut = new \Derby\Media\LocalFile\Image($key, $sourceAdapter, $imagine);

            /**
             * RESIZE TO 100 x 75 OUTBOUND
             */

            $targetKey = 'gd-resize-inbound-' . $key;

            if ($mediaManager->exists($targetKey, $targetAdapter)) {
                $targetAdapter->delete($targetKey);
            }

            $target = $sut->resize(
                $targetKey,
                $targetAdapter,
                100,
                75,
                \Derby\Media\LocalFile\Image::THUMBNAIL_OUTBOUND,
                $quality
            );
            $this->assertFileExists($target->getPath());
            $imageDimensions = getimagesize($target->getPath());
            $this->assertEquals($outbound[0], $imageDimensions[0]);
            $this->assertEquals($outbound[1], $imageDimensions[1]);
            $this->assertEquals($mimeType, $imageDimensions['mime']);

            /**
             * RESIZE TO 100 x 75 INSET
             */

            $targetKey = 'gd-resize-inbound-' . $key;

            if ($mediaManager->exists($targetKey, $targetAdapter)) {
                $targetAdapter->delete($targetKey);
            }

            $target = $sut->resize(
                $targetKey,
                $targetAdapter,
                100,
                75,
                \Derby\Media\LocalFile\Image::THUMBNAIL_INSET,
                $quality
            );
            $this->assertFileExists($target->getPath());
            $imageDimensions = getimagesize($target->getPath());
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

        $key = 'test-236x315.jpg';
        $targetKey = 'gd-crop-' . $key;

        $mediaManager = new Manager();
        $sourceAdapter = new LocalFileAdapter(__DIR__ . '/../../Data/');
        $targetAdapter = new LocalFileAdapter(__DIR__ . '/../../Temp/');
        $sut = new \Derby\Media\LocalFile\Image($key, $sourceAdapter, $imagine);

        if ($mediaManager->exists($targetKey, $targetAdapter)) {
            $targetAdapter->delete($targetKey);
        }

        $sut->crop($targetKey, $targetAdapter, new Point(150, 150), new Box(45, 45));
    }

    public function testGdRotate()
    {
        if (!extension_loaded('gd')) {
            return;
        }

        $imagine = new \Imagine\Gd\Imagine;

        $key = 'test-236x315.jpg';
        $targetKey = 'gd-rotate-' . $key;

        $mediaManager = new Manager();
        $sourceAdapter = new LocalFileAdapter(__DIR__ . '/../../Data/');
        $targetAdapter = new LocalFileAdapter(__DIR__ . '/../../Temp/');
        $sut = new \Derby\Media\LocalFile\Image($key, $sourceAdapter, $imagine);

        if ($mediaManager->exists($targetKey, $targetAdapter)) {
            $targetAdapter->delete($targetKey);
        }

        $sut->rotate($targetKey, $targetAdapter, 90);
    }

    public function testGdGreyscale()
    {
        if (!extension_loaded('gd')) {
            return;
        }

        $imagine = new \Imagine\Gd\Imagine;

        $key = 'test-236x315.jpg';
        $targetKey = 'gd-greyscale-' . $key;

        $mediaManager = new Manager();
        $sourceAdapter = new LocalFileAdapter(__DIR__ . '/../../Data/');
        $targetAdapter = new LocalFileAdapter(__DIR__ . '/../../Temp/');
        $sut = new \Derby\Media\LocalFile\Image($key, $sourceAdapter, $imagine);

        if ($mediaManager->exists($targetKey, $targetAdapter)) {
            $targetAdapter->delete($targetKey);
        }

        $sut->greyscale($targetKey, $targetAdapter);
    }

    public function testGdFlipHorizontally()
    {
        if (!extension_loaded('gd')) {
            return;
        }

        $imagine = new \Imagine\Gd\Imagine;

        $key = 'test-236x315.jpg';
        $targetKey = 'gd-flip-horizontally-' . $key;

        $mediaManager = new Manager();
        $sourceAdapter = new LocalFileAdapter(__DIR__ . '/../../Data/');
        $targetAdapter = new LocalFileAdapter(__DIR__ . '/../../Temp/');
        $sut = new \Derby\Media\LocalFile\Image($key, $sourceAdapter, $imagine);

        if ($mediaManager->exists($targetKey, $targetAdapter)) {
            $targetAdapter->delete($targetKey);
        }

        $sut->flipHorizontally($targetKey, $targetAdapter);
    }

    public function testGdFlipVerticaly()
    {
        if (!extension_loaded('gd')) {
            return;
        }

        $imagine = new \Imagine\Gd\Imagine;

        $key = 'test-236x315.jpg';
        $targetKey = 'gd-flip-vertically-' . $key;

        $mediaManager = new Manager();
        $sourceAdapter = new LocalFileAdapter(__DIR__ . '/../../Data/');
        $targetAdapter = new LocalFileAdapter(__DIR__ . '/../../Temp/');
        $sut = new \Derby\Media\LocalFile\Image($key, $sourceAdapter, $imagine);

        if ($mediaManager->exists($targetKey, $targetAdapter)) {
            $targetAdapter->delete($targetKey);
        }

        $sut->flipVertically($targetKey, $targetAdapter);
    }

    public function testGmagickResize()
    {
        if (!extension_loaded('gmagick')) {
            return;
        }

        $imagine = new \Imagine\Gmagick\Imagine();

        /**
         * Based of of examples found on http://www.hundekauf.eu/thumbs.html
         */

        $images = array(
            array(
                'file' => 'test-236x315.jpg',
                'mime_type' => 'image/jpeg',
                'outbound' => array(100, 75),
                'inset' => array(56, 75),
            ),
            array(
                'file' => 'test-243x284.jpg',
                'mime_type' => 'image/jpeg',
                'outbound' => array(100, 75),
                'inset' => array(64, 75),
            ),
            array(
                'file' => 'test-420x280.jpg',
                'mime_type' => 'image/jpeg',
                'outbound' => array(100, 75),
                'inset' => array(100, 67),
            ),
            array(
                'file' => 'test-420x315.jpg',
                'mime_type' => 'image/jpeg',
                'outbound' => array(100, 75),
                'inset' => array(100, 75),
            ),
        );

        foreach ($images as $image) {
            $key = $image['file'];
            $quality = 75;
            $mimeType = $image['mime_type'];
            $outbound = $image['outbound'];
            $inset = $image['inset'];

            $mediaManager = new Manager();
            $sourceAdapter = new LocalFileAdapter(__DIR__ . '/../../Data/');
            $targetAdapter = new LocalFileAdapter(__DIR__ . '/../../Temp/');
            $sut = new \Derby\Media\LocalFile\Image($key, $sourceAdapter, $imagine);

            /**
             * RESIZE TO 100 x 75 OUTBOUND
             */

            $targetKey = 'gmagick-resize-inbound-' . $key;

            if ($mediaManager->exists($targetKey, $targetAdapter)) {
                $targetAdapter->delete($targetKey);
            }

            $target = $sut->resize(
                $targetKey,
                $targetAdapter,
                100,
                75,
                \Derby\Media\LocalFile\Image::THUMBNAIL_OUTBOUND,
                $quality
            );
            $this->assertFileExists($target->getPath());
            $imageDimensions = getimagesize($target->getPath());
            $this->assertEquals($outbound[0], $imageDimensions[0]);
            $this->assertEquals($outbound[1], $imageDimensions[1]);
            $this->assertEquals($mimeType, $imageDimensions['mime']);

            /**
             * RESIZE TO 100 x 75 INSET
             */

            $targetKey = 'gmagick-resize-inbound-' . $key;

            if ($mediaManager->exists($targetKey, $targetAdapter)) {
                $targetAdapter->delete($targetKey);
            }

            $target = $sut->resize(
                $targetKey,
                $targetAdapter,
                100,
                75,
                \Derby\Media\LocalFile\Image::THUMBNAIL_INSET,
                $quality
            );
            $this->assertFileExists($target->getPath());
            $imageDimensions = getimagesize($target->getPath());
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

        $imagine = new \Imagine\Gd\Imagine;

        $key = 'test-236x315.jpg';
        $targetKey = 'gmagick-crop-' . $key;

        $mediaManager = new Manager();
        $sourceAdapter = new LocalFileAdapter(__DIR__ . '/../../Data/');
        $targetAdapter = new LocalFileAdapter(__DIR__ . '/../../Temp/');
        $sut = new \Derby\Media\LocalFile\Image($key, $sourceAdapter, $imagine);

        if ($mediaManager->exists($targetKey, $targetAdapter)) {
            $targetAdapter->delete($targetKey);
        }

        $sut->crop($targetKey, $targetAdapter, new Point(150, 150), new Box(45, 45));
    }

    public function testGmagickRotate()
    {
        if (!extension_loaded('gmagick')) {
            return;
        }

        $imagine = new \Imagine\Gmagick\Imagine;

        $key = 'test-236x315.jpg';
        $targetKey = 'gmagick-rotate-' . $key;

        $mediaManager = new Manager();
        $sourceAdapter = new LocalFileAdapter(__DIR__ . '/../../Data/');
        $targetAdapter = new LocalFileAdapter(__DIR__ . '/../../Temp/');
        $sut = new \Derby\Media\LocalFile\Image($key, $sourceAdapter, $imagine);

        if ($mediaManager->exists($targetKey, $targetAdapter)) {
            $targetAdapter->delete($targetKey);
        }

        $sut->rotate($targetKey, $targetAdapter, 90);
    }

    public function testGmagickGreyscale()
    {
        if (!extension_loaded('gmagick')) {
            return;
        }

        $imagine = new \Imagine\Gmagick\Imagine;

        $key = 'test-236x315.jpg';
        $targetKey = 'gmagick-greyscale-' . $key;

        $mediaManager = new Manager();
        $sourceAdapter = new LocalFileAdapter(__DIR__ . '/../../Data/');
        $targetAdapter = new LocalFileAdapter(__DIR__ . '/../../Temp/');
        $sut = new \Derby\Media\LocalFile\Image($key, $sourceAdapter, $imagine);

        if ($mediaManager->exists($targetKey, $targetAdapter)) {
            $targetAdapter->delete($targetKey);
        }

        $sut->greyscale($targetKey, $targetAdapter);
    }

    public function testGmagickFlipHorizontally()
    {
        if (!extension_loaded('gmagick')) {
            return;
        }

        $imagine = new \Imagine\Gmagick\Imagine;

        $key = 'test-236x315.jpg';
        $targetKey = 'gmagick-flip-horizontally-' . $key;

        $mediaManager = new Manager();
        $sourceAdapter = new LocalFileAdapter(__DIR__ . '/../../Data/');
        $targetAdapter = new LocalFileAdapter(__DIR__ . '/../../Temp/');
        $sut = new \Derby\Media\LocalFile\Image($key, $sourceAdapter, $imagine);

        if ($mediaManager->exists($targetKey, $targetAdapter)) {
            $targetAdapter->delete($targetKey);
        }

        $sut->flipHorizontally($targetKey, $targetAdapter);
    }

    public function testGmagickFlipVerticaly()
    {
        if (!extension_loaded('gmagick')) {
            return;
        }

        $imagine = new \Imagine\Gmagick\Imagine;

        $key = 'test-236x315.jpg';
        $targetKey = 'gmagick-flip-vertically-' . $key;

        $mediaManager = new Manager();
        $sourceAdapter = new LocalFileAdapter(__DIR__ . '/../../Data/');
        $targetAdapter = new LocalFileAdapter(__DIR__ . '/../../Temp/');
        $sut = new \Derby\Media\LocalFile\Image($key, $sourceAdapter, $imagine);

        if ($mediaManager->exists($targetKey, $targetAdapter)) {
            $targetAdapter->delete($targetKey);
        }

        $sut->flipVertically($targetKey, $targetAdapter);
    }
}
