<?php

/**
 * @package mindgruve/derby
 * @copyright (c) 2015 Mindgruve
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 */

namespace Derby\Tests\Integration\Media;

use Derby\Adapter\LocalFileAdapter;
use Derby\Config;
use Derby\Manager;
use Derby\ManagerFactory;
use Derby\Media;
use Imagine\Gd\Imagine;
use Mockery;

/**
 * Derby\Tests\Integration\Media\ManagerTest
 *
 * @author Kevin Simpson <ksimpson@mindgruve.com>
 * @author John Pancoast <jpancoast@mindgruve.com>
 */
class ManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testRegisterFile()
    {
        $manager = new Manager();
        $imagine = new Imagine();

        $manager->registerFileFactory(new Media\LocalFileFactory\TextFactory(['txt'],['text/plain']));
        $manager->registerFileFactory(new Media\LocalFileFactory\HtmlFactory(['html'],['text/html', 'text/plain']));
        $manager->registerFileFactory(new Media\LocalFileFactory\ImageFactory(['jpg', 'jpeg', 'gif', 'bmp', 'png'],['image/jpeg', 'image/gif', 'image/bmp', 'image/x-bmp', 'image/png']));

        $localAdapter = new LocalFileAdapter(__DIR__ . '/../Temp/', true);

        // Build HTML File
        $file = $manager->buildFile('test-1.html', $localAdapter, 'test1');

        $this->assertTrue($file instanceof Media\LocalFile\Html);

        $file = $manager->getMedia('test-1.html', $localAdapter);
        $this->assertTrue($file instanceof Media\LocalFile\Html);

        // Build Text File
        $file = $manager->buildFile('test-2.txt', $localAdapter, 'test2');
        $this->assertTrue($file instanceof Media\LocalFile\Text);

        $file = $manager->getMedia('test-2.txt', $localAdapter);
        $this->assertTrue($file instanceof Media\LocalFile\Text);

        // Build Image File
        $file = $manager->buildFile(
            'test-3.jpg',
            $localAdapter,
            file_get_contents(__DIR__ . '/../Data/test-236x315.jpg')
        );
        $this->assertTrue($file instanceof Media\LocalFile\Image);

        $file = $manager->getMedia('test-3.jpg', $localAdapter);
        $this->assertTrue($file instanceof Media\LocalFile\Image);
    }

    public function testWildcardFileRegistration()
    {
        $config  = mockery::mock('Derby\Config');
        $manager = new Manager($config);

        $manager->registerFileFactory(new Media\LocalFileFactory\TextFactory(['*'],['text/*']));

        $localAdapter = new LocalFileAdapter(__DIR__ . '/../Temp/', true);

        // Build HTML File
        $file = $manager->buildFile('test-1.html', $localAdapter, 'test1');
        $this->assertTrue($file instanceof Media\LocalFile\Text);

        // Build Text File
        $file = $manager->buildFile('test-2.txt', $localAdapter, 'test2');
        $this->assertTrue($file instanceof Media\LocalFile\Text);
    }

    public function testGracefulDegradation()
    {
        $config  = mockery::mock('Derby\Config');
        $manager = new Manager($config);

        $manager->registerFileFactory(new Media\LocalFileFactory\TextFactory(['*'],['text/*']));

        $localAdapter = new LocalFileAdapter(__DIR__ . '/../Temp/', true);

        // Build HTML File
        $file = $manager->buildFile('test-1.html', $localAdapter, 'test1');
        $this->assertTrue($file instanceof Media\LocalFile\Text);

        // Build Text File
        $file = $manager->buildFile('test-2.txt', $localAdapter, 'test2');
        $this->assertTrue($file instanceof Media\LocalFile\Text);

        // Will return Generic Local File b.c we haven't registered image media
        $file = $manager->buildFile(
            'test-3.jpg',
            $localAdapter,
            file_get_contents(__DIR__ . '/../Data/test-236x315.jpg')
        );
        $this->assertFalse($file instanceof Media\LocalFile\Image);
        $this->assertTrue($file instanceof Media\LocalFile);
    }


}
