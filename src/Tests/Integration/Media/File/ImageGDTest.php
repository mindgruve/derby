<?php

/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 */

namespace Derby\Tests\Integration\Media\Local;

use Derby\Adapter\FileAdapter;
use Derby\Event\ImagePostSave;
use Derby\Event\ImagePreSave;
use Derby\Media\File\Image;
use Gaufrette\Adapter\Local;
use Imagine\Image\Point;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Derby\Events;

/**
 * Derby\Tests\Integration\Media\Local\ImageTest
 *
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 */
class ImageGDTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \Derby\Media\File\Image
     */
    protected $sourceFile;

    /**
     * @var \Derby\Media\File\Image
     */
    protected $targetFile;

    /**
     * @var \Derby\Media\File\Image
     */
    protected $secondaryTargetFile;

    /**
     * @param $sourceKey
     * @param $targetKey
     * @param null $secondaryTargetKey
     */
    public function setUpImages($sourceKey, $targetKey, $secondaryTargetKey = null, $dispatcher = null)
    {
        $imagine = new \Imagine\Gd\Imagine();
        $sourceAdapter = new FileAdapter(new Local(__DIR__ . '/../../Data/'));
        $targetAdapter = new FileAdapter(new Local(__DIR__ . '/../../Temp/'));

        $this->sourceFile = new \Derby\Media\File\Image($sourceKey, $sourceAdapter, $imagine, $dispatcher);
        $this->targetFile = new \Derby\Media\File\Image($targetKey, $targetAdapter, $imagine, $dispatcher);


        if ($targetAdapter->exists($targetKey)) {
            $targetAdapter->delete($targetKey);
        }

        if ($secondaryTargetKey) {
            $secondaryTargetAdapter = new FileAdapter(new Local(__DIR__ . '/../../Temp/'));
            $this->secondaryTargetFile = new \Derby\Media\File\Image($secondaryTargetKey, $secondaryTargetAdapter, $imagine, $dispatcher);
            if ($secondaryTargetAdapter->exists($secondaryTargetKey)) {
                $secondaryTargetAdapter->delete($secondaryTargetKey);
            }
        }
    }

    public function testGetImage()
    {
        if (!extension_loaded('gd')) {
            return;
        }
        $this->setUpImages('test-236x315.jpg', 'testGetImage.jpg');

        $this->assertTrue($this->sourceFile->getImageData() instanceof \Imagine\Image\AbstractImage);
        $this->assertTrue($this->sourceFile->getImageData() instanceof \Imagine\Gd\Image);

    }

    public function testSave()
    {
        if (!extension_loaded('gd')) {
            return;
        }
        $this->setUpImages('test-236x315.jpg', 'testImageSave.jpg');
        $this->targetFile->write($this->sourceFile->read());

        $this->assertEquals(md5($this->sourceFile->read()), md5($this->targetFile->read()));

        $this->targetFile->greyscale()->save();

        $this->assertNotEquals(md5($this->sourceFile->read()), md5($this->targetFile->read()));
    }

    public function testSaveAs()
    {
        if (!extension_loaded('gd')) {
            return;
        }
        $this->setUpImages('test-236x315.jpg', 'testSaveAs.jpg', 'testSaveAs2.jpg');
        $this->targetFile->write($this->sourceFile->read());

        $this->assertEquals(md5($this->sourceFile->read()), md5($this->targetFile->read()));

        $this->targetFile->greyscale();

        $this->assertEquals(md5($this->sourceFile->read()), md5($this->targetFile->read()));

        $this->targetFile->save($this->secondaryTargetFile);

        $this->assertNotEquals(md5($this->targetFile->read()), md5($this->secondaryTargetFile->read()));
    }

    public function testPreSaveEventDispatched()
    {
        if (!extension_loaded('gd')) {
            return;
        }

        $eventDispatched = false;
        $dispatcher = new EventDispatcher();
        $dispatcher->addListener(
            Events::IMAGE_PRE_SAVE,
            function(ImagePreSave $e) use (&$eventDispatched){
                $e->getImage()->greyscale();
                $eventDispatched = true;
            }
        );

        $this->setUpImages('test-236x315.jpg', 'testSaveAs.jpg', 'testPreSaveEventDispatched.jpg', $dispatcher);
        $this->targetFile->write($this->sourceFile->read());
        $this->targetFile->save($this->secondaryTargetFile);

        $this->assertTrue($eventDispatched);
    }

    public function testPostSaveEventDispatched()
    {
        if (!extension_loaded('gd')) {
            return;
        }

        $eventDispatched = false;
        $dispatcher = new EventDispatcher();
        $dispatcher->addListener(
            Events::IMAGE_POST_SAVE,
            function(ImagePostSave $e) use (&$eventDispatched){
                $eventDispatched = true;
            }
        );

        $this->setUpImages('test-236x315.jpg', 'testSaveAs.jpg', 'testPostSaveEventDispatched.jpg', $dispatcher);
        $this->targetFile->write($this->sourceFile->read());
        $this->targetFile->save($this->secondaryTargetFile);

        $this->assertTrue($eventDispatched);
    }

    public function testNoChangesUntilSave()
    {
        if (!extension_loaded('gd')) {
            return;
        }
        $this->setUpImages('test-236x315.jpg', 'testNoChangesUntilSave.jpg');
        $this->targetFile->write($this->sourceFile->read());

        $this->assertEquals(md5($this->sourceFile->read()), md5($this->targetFile->read()));

        $this->targetFile
            ->greyscale()
            ->crop(150, 150, 50, 50)
            ->resize(150, 150)
            ->rotate(60)
            ->flipHorizontally()
            ->flipVertically();

        $this->assertEquals(md5($this->sourceFile->read()), md5($this->targetFile->read()));

        /** Save causes all the changes to be written to disk */
        $this->targetFile->save();

        $this->assertNotEquals(md5($this->sourceFile->read()), md5($this->targetFile->read()));
    }


    public function testGDResize()
    {
        if (!extension_loaded('gd')) {
            return;
        }


        /**
         * Based of of examples found on http://www.hundekauf.eu/thumbs.html
         */

        $images = array(
            array(
                'file' => 'test-236x315.jpg',
                'outbound' => array(100, 75),
                'inset' => array(56, 75),
                'fixedWidth' => array(100, 0),
                'fixedHeight' => array(0, 100),
            ),
            array(
                'file' => 'test-243x284.jpg',
                'outbound' => array(100, 75),
                'inset' => array(64, 75),
                'fixedWidth' => array(100, 0),
                'fixedHeight' => array(0, 100),
            ),
            array(
                'file' => 'test-420x280.jpg',
                'outbound' => array(100, 75),
                'inset' => array(100, 67),
                'fixedWidth' => array(100, 0),
                'fixedHeight' => array(0, 100),
            ),
            array(
                'file' => 'test-420x315.jpg',
                'outbound' => array(100, 75),
                'inset' => array(100, 75),
                'fixedWidth' => array(100, 0),
                'fixedHeight' => array(0, 100),
            ),
        );

        foreach ($images as $image) {
            $sourceKey = $image['file'];
            $targetKey = 'gd-resize-outbound-' . $sourceKey;
            $outbound = $image['outbound'];
            $inset = $image['inset'];
            $fixedWidth = $image['fixedWidth'];
            $fixedHeight = $image['fixedHeight'];

            $this->setUpImages($sourceKey, $targetKey);
            $sourceDimensions = getimagesize($this->sourceFile->copyToLocal()->getPath());

            /**
             * RESIZE TO 100 x 75 OUTBOUND
             */

            $this->sourceFile->resize(
                $outbound[0],
                $outbound[1],
                Image::THUMBNAIL_OUTBOUND
            )->save($this->targetFile);

            $this->assertNotNull($this->targetFile->read());
            $tmpFile = $this->targetFile->copyToLocal();

            $imageDimensions = getimagesize($tmpFile->getPath());
            $this->assertEquals($outbound[0], $imageDimensions[0]);
            $this->assertEquals($outbound[1], $imageDimensions[1]);

            /**
             * RESIZE TO 100 x 75 INSET
             */

            $targetKey = 'gd-resize-inset-' . $sourceKey;
            $this->setUpImages($sourceKey, $targetKey);

            $this->sourceFile->resize(
                $inset[0],
                $inset[1],
                Image::THUMBNAIL_INSET
            )->save($this->targetFile);

            $this->assertNotNull($this->targetFile->read());
            $tmpFile = $this->targetFile->copyToLocal();

            $this->assertFileExists($tmpFile->getPath());
            $imageDimensions = getimagesize($tmpFile->getPath());
            $this->assertEquals($inset[0], $imageDimensions[0]);
            $this->assertEquals($inset[1], $imageDimensions[1]);

            /**
             * RESIZE TO 100 Width
             */

            $targetKey = 'gd-resize-fixedWidth-' . $sourceKey;
            $this->setUpImages($sourceKey, $targetKey);

            $this->sourceFile->resize(
                $fixedWidth[0],
                $fixedWidth[1],
                Image::THUMBNAIL_OUTBOUND
            )->save($this->targetFile);

            $this->assertNotNull($this->targetFile->read());
            $tmpFile = $this->targetFile->copyToLocal();

            $this->assertFileExists($tmpFile->getPath());
            $imageDimensions = getimagesize($tmpFile->getPath());
            $this->assertEquals($fixedWidth[0], $imageDimensions[0]);

            // should be within 1 unit
            $this->assertLessThan(1, abs(floor($sourceDimensions[1] / $sourceDimensions[0] * 100)) - $imageDimensions[1]);


            /**
             * RESIZE TO 100 Height
             */

            $targetKey = 'gd-resize-fixedHeight-' . $sourceKey;
            $this->setUpImages($sourceKey, $targetKey);

            $this->sourceFile->resize(
                $fixedHeight[0],
                $fixedHeight[1],
                Image::THUMBNAIL_OUTBOUND
            )->save($this->targetFile);

            $this->assertNotNull($this->targetFile->read());
            $tmpFile = $this->targetFile->copyToLocal();

            $this->assertFileExists($tmpFile->getPath());
            $imageDimensions = getimagesize($tmpFile->getPath());

            $this->assertEquals($fixedHeight[1], $imageDimensions[1]);

            // should be within rounding error
            $this->assertLessThan(1, abs(floor($sourceDimensions[0] / $sourceDimensions[1] * 100)) - $imageDimensions[0]);
        }
    }

    public function testGdCrop()
    {
        if (!extension_loaded('gd')) {
            return;
        }

        $sourceKey = 'test-236x315.jpg';
        $targetKey = 'gd-crop-' . $sourceKey;
        $this->setUpImages($sourceKey, $targetKey);

        $this->sourceFile->crop(150, 150, 45, 45)->save($this->targetFile);
    }

    public function testGdRotate()
    {
        if (!extension_loaded('gd')) {
            return;
        }

        $sourceKey = 'test-236x315.jpg';
        $targetKey = 'gd-rotate-' . $sourceKey;
        $this->setUpImages($sourceKey, $targetKey);

        $this->sourceFile->rotate(90)->save($this->targetFile);
    }

    public function testGdGreyscale()
    {
        if (!extension_loaded('gd')) {
            return;
        }

        $sourceKey = 'test-236x315.jpg';
        $targetKey = 'gd-greyscale-' . $sourceKey;
        $this->setUpImages($sourceKey, $targetKey);

        $this->sourceFile->greyscale()->save($this->targetFile);
    }

    public function testGdFlipHorizontally()
    {
        if (!extension_loaded('gd')) {
            return;
        }

        $sourceKey = 'test-236x315.jpg';
        $targetKey = 'gd-flip-horizontally-' . $sourceKey;
        $this->setUpImages($sourceKey, $targetKey);


        $this->sourceFile->flipHorizontally($this->targetFile);
    }

    public function testGdFlipVerticaly()
    {
        if (!extension_loaded('gd')) {
            return;
        }

        $sourceKey = 'test-236x315.jpg';
        $targetKey = 'gd-flip-vertically-' . $sourceKey;
        $this->setUpImages($sourceKey, $targetKey);

        $this->sourceFile->flipVertically()->save($this->targetFile);
    }
}
