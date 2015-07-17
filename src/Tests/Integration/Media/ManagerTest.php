<?php

/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 */

namespace Derby\Tests\Integration\Media;

use Derby\Adapter\FileAdapter;
use Derby\MediaManager;
use Derby\MediaManagerFactory;
use Derby\Media;
use Gaufrette\Adapter\Local;
use Mockery;

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

        $localAdapter = new FileAdapter(new Local(__DIR__ . '/../Temp/', true));
        $manager->registerAdapter($localAdapter, 'test.local');

        // Build HTML File
        $file = $manager->buildFile('test-1.html', 'test.local', 'test1');

        $this->assertTrue($file instanceof Media\File\Html);

        $file = $manager->getMedia('test-1.html', 'test.local');
        $this->assertTrue($file instanceof Media\File\Html);

        // Build Text File
        $file = $manager->buildFile('test-2.txt', 'test.local', 'test2');
        $this->assertTrue($file instanceof Media\File\Text);

        $file = $manager->getMedia('test-2.txt', 'test.local');
        $this->assertTrue($file instanceof Media\File\Text);

        // Build Image File
        $file = $manager->buildFile(
            'test-3.jpg',
            'test.local',
            file_get_contents(__DIR__ . '/../Data/test-236x315.jpg')
        );
        $this->assertTrue($file instanceof Media\File\Image);

        $file = $manager->getMedia('test-3.jpg', 'test.local');
        $this->assertTrue($file instanceof Media\File\Image);
    }

    public function testWildcardFileRegistration()
    {
        $manager = new MediaManager();

        $manager->registerFileFactory(new \Derby\Media\File\Factory\TextFactory(['*'], ['text/*']));

        $localAdapter = new FileAdapter(new Local(__DIR__ . '/../Temp/'));
        $manager->registerAdapter($localAdapter, 'test.local');

        // Build HTML File
        $file = $manager->buildFile('test-1.html', 'test.local', 'test1');
        $this->assertTrue($file instanceof Media\File\Text);

        // Build Text File
        $file = $manager->buildFile('test-2.txt', 'test.local', 'test2');
        $this->assertTrue($file instanceof Media\File\Text);
    }

    public function testGracefulDegradation()
    {
        $manager = new MediaManager();

        $manager->registerFileFactory(new \Derby\Media\File\Factory\TextFactory(['*'], ['text/*']));

        $localAdapter = new FileAdapter(new Local(__DIR__ . '/../Temp/'));
        $manager->registerAdapter($localAdapter, 'test.local');

        // Build HTML File
        $file = $manager->buildFile('test-1.html', 'test.local', 'test1');
        $this->assertTrue($file instanceof Media\File\Text);

        // Build Text File
        $file = $manager->buildFile('test-2.txt', 'test.local', 'test2');
        $this->assertTrue($file instanceof Media\File\Text);

        // Will return Generic Local File b.c we haven't registered image media
        $file = $manager->buildFile(
            'test-3.jpg',
            'test.local',
            file_get_contents(__DIR__ . '/../Data/test-236x315.jpg')
        );
        $this->assertFalse($file instanceof Media\File\Image);
        $this->assertTrue($file instanceof Media\File);
    }
}
