<?php

/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 */

namespace Derby\Tests\Integration;

use Derby\Adapter\FileAdapter;
use Derby\MediaManager;
use Derby\MediaManagerFactory;
use Gaufrette\Adapter\Local;
use Mockery;
use Derby\Media\File\Html;

/**
 * Derby\Tests\Integration\Media\ManagerTest
 *
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 */
class MediaManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testRegisterFile()
    {
        $manager = MediaManagerFactory::build();

        $localAdapter = new FileAdapter('file.tmp', new Local(__DIR__.'/Temp/', true));
        $manager->registerAdapter($localAdapter);

        // Build HTML File
        $file = $manager->getMedia('test-1.html', 'file.tmp');
        $file->write('test1');

        $this->assertTrue($file instanceof Html);

        $file = $manager->getMedia('test-1.html', 'file.tmp');
        $this->assertTrue($file instanceof \Derby\Media\File\Html);

        // Build Text File
        $file = $manager->getMedia('test-2.txt', 'file.tmp');
        $file->write('test2');
        $this->assertTrue($file instanceof \Derby\Media\File\Text);

        $file = $manager->getMedia('test-2.txt', 'file.tmp');
        $this->assertTrue($file instanceof \Derby\Media\File\Text);

        // Build Image File
        $file = $manager->getMedia('test-3.jpg', 'file.tmp');
        $file->write(
            file_get_contents(__DIR__.'/Data/test-236x315.jpg')
        );
        $this->assertTrue($file instanceof \Derby\Media\File\Image);

        $file = $manager->getMedia('test-3.jpg', 'file.tmp');
        $this->assertTrue($file instanceof \Derby\Media\File\Image);
    }

    public function testWildcardFileRegistration()
    {
        $manager = new MediaManager();

        $manager->registerFileFactory(new \Derby\Media\Factory\TextFactory(['*'], ['text/*']));

        $localAdapter = new FileAdapter('file.tmp', new Local(__DIR__.'/Temp/'));
        $manager->registerAdapter($localAdapter);

        // Build HTML File
        $file = $manager->getMedia('test-1.html', 'file.tmp');
        $file->write('test1');
        $this->assertTrue($file instanceof \Derby\Media\File\Text);

        // Build Text File
        $file = $manager->getMedia('test-2.txt', 'file.tmp');
        $file->write('test2');
        $this->assertTrue($file instanceof \Derby\Media\File\Text);
    }

    public function testGracefulDegradation()
    {
        $manager = new MediaManager();

        $manager->registerFileFactory(new \Derby\Media\Factory\TextFactory(['*'], ['text/*']));

        $localAdapter = new FileAdapter('file.tmp', new Local(__DIR__.'/Temp/'));
        $manager->registerAdapter($localAdapter);

        // Build HTML File
        $file = $manager->getMedia('test-1.html', 'file.tmp');
        $file->write('test1');
        $this->assertTrue($file instanceof \Derby\Media\File\Text);

        // Build Text File
        $file = $manager->getMedia('test-2.txt', 'file.tmp');
        $file->write('test2');
        $this->assertTrue($file instanceof \Derby\Media\File\Text);

        // Will return Generic Local File b.c we haven't registered image media
        $file = $manager->getMedia('test-3.jpg', 'file.tmp');
        $file->write(
            file_get_contents(__DIR__.'/Data/test-236x315.jpg')
        );
        $this->assertFalse($file instanceof \Derby\Media\File\Image);
        $this->assertTrue($file instanceof \Derby\Media\File);
    }
}
