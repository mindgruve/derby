<?php


namespace Derby\Tests\Unit\Media;

use Derby\Media\MetaDataInterface;
use Derby\Media\MetaData;
use Mockery;

class MetaDataTest extends \PHPUnit_Framework_TestCase
{

    protected static $metaDataClass = 'Derby\Media\MetaData';

    public function testInterface()
    {
        $label        = 'Foo';
        $status       = MetaData::STATUS_PUBLISHED;
        $parent       = null;
        $dateCreated  = new \DateTime('1/1/2000');
        $dateModified = new \DateTime('1/1/2001');
        $ext          = 'png';
        $mimeType     = 'image\png';
        $permissions  = Mockery::mock('Derby\AccessControl\Permissions');

        $sut = new MetaData($label, $status, $permissions, $parent, $dateCreated, $dateModified, $ext, $mimeType);

        $this->assertTrue($sut instanceof MetaDataInterface);
    }

    public function testConstructorSettersGetters()
    {
        $label        = 'Foo';
        $status       = MetaData::STATUS_PUBLISHED;
        $parent       = null;
        $dateCreated  = new \DateTime('1/1/2000');
        $dateModified = new \DateTime('1/1/2001');
        $ext          = 'png';
        $mimeType     = 'image\png';
        $permissions  = Mockery::mock('Derby\AccessControl\Permissions');

        $sut = new MetaData($label, $status, $permissions, $parent, $dateCreated, $dateModified, $ext, $mimeType);

        $this->assertEquals($label, $sut->getLabel());
        $this->assertEquals($parent, $sut->getParent());
        $this->assertEquals($dateCreated, $sut->getDateCreated());
        $this->assertEquals($dateModified, $sut->getDateModified());
        $this->assertEquals($ext, $sut->getFileExtension());
        $this->assertEquals($mimeType, $sut->getMimeType());

        $label2        = 'Bar';
        $status2       = MetaData::STATUS_UNPUBLISHED;
        $parent2       = Mockery::mock('Derby\Media\Media');
        $dateCreated2  = new \DateTime('1/1/2003');
        $dateModified2 = new \DateTime('1/1/2004');
        $ext2          = 'png';
        $mimeType2     = 'image\png';

        $sut->setLabel($label2)
            ->setStatus($status2)
            ->setParent($parent2)
            ->setDateCreated($dateCreated2)
            ->setDateModified($dateModified2)
            ->setFileExtension($ext2)
            ->setMimeType($mimeType2);

        $this->assertEquals($label2, $sut->getLabel());
        $this->assertEquals($parent2, $sut->getParent());
        $this->assertEquals($dateCreated2, $sut->getDateCreated());
        $this->assertEquals($dateModified2, $sut->getDateModified());
        $this->assertEquals($ext2, $sut->getFileExtension());
        $this->assertEquals($mimeType2, $sut->getMimeType());

    }
}
