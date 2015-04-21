<?php


namespace Derby\Tests\AccessControl;

use Derby\AccessControl\Permissions;
use Derby\Media\Alias;
use PHPUnit_Framework_TestCase;
use Mockery;

class PermissionsTest extends PHPUnit_Framework_TestCase
{

    public function testInterface()
    {
        $this->assertEquals(0, Permissions::PERMISSION_NONE);
        $this->assertEquals(1, Permissions::PERMISSION_EXECUTE);
        $this->assertEquals(2, Permissions::PERMISSION_WRITE);
        $this->assertEquals(3, Permissions::PERMISSION_WRITE_EXECUTE);
        $this->assertEquals(4, Permissions::PERMISSION_READ);
        $this->assertEquals(5, Permissions::PERMISSION_READ_EXECUTE);
        $this->assertEquals(6, Permissions::PERMISSION_READ_WRITE);
        $this->assertEquals(7, Permissions::PERMISSION_ALL);
    }

    public function testSetGetOwnerPermission()
    {
        $sut = new Permissions('root', 'root', 7, 7, 7);

        $sut->setOwnerPermissions(Permissions::PERMISSION_NONE);
        $this->assertEquals(Permissions::PERMISSION_NONE, $sut->getOwnerPermissions());
    }

    public function testSetGetGroupPermission()
    {
        $sut = new Permissions('root', 'root', 7, 7, 7);

        $sut->setGroupPermissions(Permissions::PERMISSION_NONE);
        $this->assertEquals(Permissions::PERMISSION_NONE, $sut->getGroupPermissions());
    }

    public function testSetGetAnonPermission()
    {
        $sut = new Permissions('root', 'root', 7, 7, 7);

        $sut->setAnonymousPermissions(Permissions::PERMISSION_NONE);
        $this->assertEquals(Permissions::PERMISSION_NONE, $sut->getAnonymousPermissions());
    }

    public function testSetGetOwner()
    {
        $sut = new Permissions('root', 'root', 7, 7, 7);
        
        $this->assertEquals('root', $sut->getOwner());
        $sut->setOwner('web');
        $this->assertEquals('web', $sut->getOwner());
    }

    public function testSetGetGroup()
    {
        $sut = new Permissions('root', 'root', 7, 7, 7);

        $this->assertEquals('root', $sut->getGroup());
        $sut->setGroup('web');
        $this->assertEquals('web', $sut->getGroup());
    }

    public function testAllowDenyOwnerPermissions()
    {
        $sut = new Permissions('root', 'root', 7, 7, 7);

        $this->assertTrue($sut->canOwnerExecute());
        $sut->denyOwnerExecute();
        $this->assertFalse($sut->canOwnerExecute());
        $sut->allowOwnerExecute();
        $this->assertTrue($sut->canOwnerExecute());

        $this->assertTrue($sut->canOwnerWrite());
        $sut->denyOwnerWrite();
        $this->assertFalse($sut->canOwnerWrite());
        $sut->allowOwnerWrite();
        $this->assertTrue($sut->canOwnerWrite());

        $this->assertTrue($sut->canOwnerRead());
        $sut->denyOwnerRead();
        $this->assertFalse($sut->canOwnerRead());
        $sut->allowOwnerRead();
        $this->assertTrue($sut->canOwnerRead());
    }

    public function testAllowDenyGroupPermissions()
    {
        $sut = new Permissions('root', 'root', 7, 7, 7);

        $this->assertTrue($sut->canGroupExecute());
        $sut->denyGroupExecute();
        $this->assertFalse($sut->canGroupExecute());
        $sut->allowGroupExecute();
        $this->assertTrue($sut->canGroupExecute());

        $this->assertTrue($sut->canGroupWrite());
        $sut->denyGroupWrite();
        $this->assertFalse($sut->canGroupWrite());
        $sut->allowGroupWrite();
        $this->assertTrue($sut->canGroupWrite());

        $this->assertTrue($sut->canGroupRead());
        $sut->denyGroupRead();
        $this->assertFalse($sut->canGroupRead());
        $sut->allowGroupRead();
        $this->assertTrue($sut->canGroupRead());
    }

    public function testAllowDenyAnonPermissions()
    {
        $sut = new Permissions('root', 'root', 7, 7, 7);

        $this->assertTrue($sut->canAnonExecute());
        $sut->denyAnonExecute();
        $this->assertFalse($sut->canAnonExecute());
        $sut->allowAnonExecute();
        $this->assertTrue($sut->canAnonExecute());

        $this->assertTrue($sut->canAnonWrite());
        $sut->denyAnonWrite();
        $this->assertFalse($sut->canAnonWrite());
        $sut->allowAnonWrite();
        $this->assertTrue($sut->canAnonWrite());

        $this->assertTrue($sut->canAnonRead());
        $sut->denyAnonRead();
        $this->assertFalse($sut->canAnonRead());
        $sut->allowAnonRead();
        $this->assertTrue($sut->canAnonRead());
    }

    public function testMode777()
    {
        $sut = new Permissions('root', 'root', 7, 7, 7);
        $this->assertTrue($sut->canOwnerRead());
        $this->assertTrue($sut->canOwnerWrite());
        $this->assertTrue($sut->canOwnerExecute());
        $this->assertTrue($sut->canGroupRead());
        $this->assertTrue($sut->canGroupWrite());
        $this->assertTrue($sut->canGroupExecute());
        $this->assertTrue($sut->canAnonRead());
        $this->assertTrue($sut->canAnonWrite());
        $this->assertTrue($sut->canAnonExecute());
    }

    public function testMode000()
    {
        $sut = new Permissions('root', 'root', 0, 0, 0);
        $this->assertFalse($sut->canOwnerRead());
        $this->assertFalse($sut->canOwnerWrite());
        $this->assertFalse($sut->canOwnerExecute());
        $this->assertFalse($sut->canGroupRead());
        $this->assertFalse($sut->canGroupWrite());
        $this->assertFalse($sut->canGroupExecute());
        $this->assertFalse($sut->canAnonRead());
        $this->assertFalse($sut->canAnonWrite());
        $this->assertFalse($sut->canAnonExecute());
    }

    public function testMode677()
    {
        $sut = new Permissions('root', 'root', 6, 7, 7);
        $this->assertTrue($sut->canOwnerRead());
        $this->assertTrue($sut->canOwnerWrite());
        $this->assertFalse($sut->canOwnerExecute());
        $this->assertTrue($sut->canGroupRead());
        $this->assertTrue($sut->canGroupWrite());
        $this->assertTrue($sut->canGroupExecute());
        $this->assertTrue($sut->canAnonRead());
        $this->assertTrue($sut->canAnonWrite());
        $this->assertTrue($sut->canAnonExecute());
    }

    public function testMode577()
    {
        $sut = new Permissions('root', 'root', 5, 7, 7);
        $this->assertTrue($sut->canOwnerRead());
        $this->assertFalse($sut->canOwnerWrite());
        $this->assertTrue($sut->canOwnerExecute());
        $this->assertTrue($sut->canGroupRead());
        $this->assertTrue($sut->canGroupWrite());
        $this->assertTrue($sut->canGroupExecute());
        $this->assertTrue($sut->canAnonRead());
        $this->assertTrue($sut->canAnonWrite());
        $this->assertTrue($sut->canAnonExecute());
    }

    public function testMode477()
    {
        $sut = new Permissions('root', 'root', 4, 7, 7);
        $this->assertTrue($sut->canOwnerRead());
        $this->assertFalse($sut->canOwnerWrite());
        $this->assertFalse($sut->canOwnerExecute());
        $this->assertTrue($sut->canGroupRead());
        $this->assertTrue($sut->canGroupWrite());
        $this->assertTrue($sut->canGroupExecute());
        $this->assertTrue($sut->canAnonRead());
        $this->assertTrue($sut->canAnonWrite());
        $this->assertTrue($sut->canAnonExecute());
    }

    public function testMode377()
    {
        $sut = new Permissions('root', 'root', 3, 7, 7);
        $this->assertFalse($sut->canOwnerRead());
        $this->assertTrue($sut->canOwnerWrite());
        $this->assertTrue($sut->canOwnerExecute());
        $this->assertTrue($sut->canGroupRead());
        $this->assertTrue($sut->canGroupWrite());
        $this->assertTrue($sut->canGroupExecute());
        $this->assertTrue($sut->canAnonRead());
        $this->assertTrue($sut->canAnonWrite());
        $this->assertTrue($sut->canAnonExecute());
    }

    public function testMode277()
    {
        $sut = new Permissions('root', 'root', 2, 7, 7);
        $this->assertFalse($sut->canOwnerRead());
        $this->assertTrue($sut->canOwnerWrite());
        $this->assertFalse($sut->canOwnerExecute());
        $this->assertTrue($sut->canGroupRead());
        $this->assertTrue($sut->canGroupWrite());
        $this->assertTrue($sut->canGroupExecute());
        $this->assertTrue($sut->canAnonRead());
        $this->assertTrue($sut->canAnonWrite());
        $this->assertTrue($sut->canAnonExecute());
    }

    public function testMode177()
    {
        $sut = new Permissions('root', 'root', 1, 7, 7);
        $this->assertFalse($sut->canOwnerRead());
        $this->assertFalse($sut->canOwnerWrite());
        $this->assertTrue($sut->canOwnerExecute());
        $this->assertTrue($sut->canGroupRead());
        $this->assertTrue($sut->canGroupWrite());
        $this->assertTrue($sut->canGroupExecute());
        $this->assertTrue($sut->canAnonRead());
        $this->assertTrue($sut->canAnonWrite());
        $this->assertTrue($sut->canAnonExecute());
    }

    public function testMode077()
    {
        $sut = new Permissions('root', 'root', 0, 7, 7);
        $this->assertFalse($sut->canOwnerRead());
        $this->assertFalse($sut->canOwnerWrite());
        $this->assertFalse($sut->canOwnerExecute());
        $this->assertTrue($sut->canGroupRead());
        $this->assertTrue($sut->canGroupWrite());
        $this->assertTrue($sut->canGroupExecute());
        $this->assertTrue($sut->canAnonRead());
        $this->assertTrue($sut->canAnonWrite());
        $this->assertTrue($sut->canAnonExecute());
    }

    public function testMode700()
    {
        $sut = new Permissions('root', 'root', 7, 0, 0);
        $this->assertTrue($sut->canOwnerRead());
        $this->assertTrue($sut->canOwnerWrite());
        $this->assertTrue($sut->canOwnerExecute());
        $this->assertFalse($sut->canGroupRead());
        $this->assertFalse($sut->canGroupWrite());
        $this->assertFalse($sut->canGroupExecute());
        $this->assertFalse($sut->canAnonRead());
        $this->assertFalse($sut->canAnonWrite());
        $this->assertFalse($sut->canAnonExecute());
    }

    public function testMode767()
    {
        $sut = new Permissions('root', 'root', 7, 6, 7);
        $this->assertTrue($sut->canOwnerRead());
        $this->assertTrue($sut->canOwnerWrite());
        $this->assertTrue($sut->canOwnerExecute());
        $this->assertTrue($sut->canGroupRead());
        $this->assertTrue($sut->canGroupWrite());
        $this->assertFalse($sut->canGroupExecute());
        $this->assertTrue($sut->canAnonRead());
        $this->assertTrue($sut->canAnonWrite());
        $this->assertTrue($sut->canAnonExecute());
    }

    public function testMode757()
    {
        $sut = new Permissions('root', 'root', 7, 5, 7);
        $this->assertTrue($sut->canOwnerRead());
        $this->assertTrue($sut->canOwnerWrite());
        $this->assertTrue($sut->canOwnerExecute());
        $this->assertTrue($sut->canGroupRead());
        $this->assertFalse($sut->canGroupWrite());
        $this->assertTrue($sut->canGroupExecute());
        $this->assertTrue($sut->canAnonRead());
        $this->assertTrue($sut->canAnonWrite());
        $this->assertTrue($sut->canAnonExecute());
    }

    public function testMode747()
    {
        $sut = new Permissions('root', 'root', 7, 4, 7);
        $this->assertTrue($sut->canOwnerRead());
        $this->assertTrue($sut->canOwnerWrite());
        $this->assertTrue($sut->canOwnerExecute());
        $this->assertTrue($sut->canGroupRead());
        $this->assertFalse($sut->canGroupWrite());
        $this->assertFalse($sut->canGroupExecute());
        $this->assertTrue($sut->canAnonRead());
        $this->assertTrue($sut->canAnonWrite());
        $this->assertTrue($sut->canAnonExecute());
    }

    public function testMode737()
    {
        $sut = new Permissions('root', 'root', 7, 3, 7);
        $this->assertTrue($sut->canOwnerRead());
        $this->assertTrue($sut->canOwnerWrite());
        $this->assertTrue($sut->canOwnerExecute());
        $this->assertFalse($sut->canGroupRead());
        $this->assertTrue($sut->canGroupWrite());
        $this->assertTrue($sut->canGroupExecute());
        $this->assertTrue($sut->canAnonRead());
        $this->assertTrue($sut->canAnonWrite());
        $this->assertTrue($sut->canAnonExecute());
    }

    public function testMode727()
    {
        $sut = new Permissions('root', 'root', 7, 2, 7);
        $this->assertTrue($sut->canOwnerRead());
        $this->assertTrue($sut->canOwnerWrite());
        $this->assertTrue($sut->canOwnerExecute());
        $this->assertFalse($sut->canGroupRead());
        $this->assertTrue($sut->canGroupWrite());
        $this->assertFalse($sut->canGroupExecute());
        $this->assertTrue($sut->canAnonRead());
        $this->assertTrue($sut->canAnonWrite());
        $this->assertTrue($sut->canAnonExecute());
    }

    public function testMode717()
    {
        $sut = new Permissions('root', 'root', 7, 1, 7);
        $this->assertTrue($sut->canOwnerRead());
        $this->assertTrue($sut->canOwnerWrite());
        $this->assertTrue($sut->canOwnerExecute());
        $this->assertFalse($sut->canGroupRead());
        $this->assertFalse($sut->canGroupWrite());
        $this->assertTrue($sut->canGroupExecute());
        $this->assertTrue($sut->canAnonRead());
        $this->assertTrue($sut->canAnonWrite());
        $this->assertTrue($sut->canAnonExecute());
    }

    public function testMode707()
    {
        $sut = new Permissions('root', 'root', 7, 0, 7);
        $this->assertTrue($sut->canOwnerRead());
        $this->assertTrue($sut->canOwnerWrite());
        $this->assertTrue($sut->canOwnerExecute());
        $this->assertFalse($sut->canGroupRead());
        $this->assertFalse($sut->canGroupWrite());
        $this->assertFalse($sut->canGroupExecute());
        $this->assertTrue($sut->canAnonRead());
        $this->assertTrue($sut->canAnonWrite());
        $this->assertTrue($sut->canAnonExecute());
    }

    public function testMode070()
    {
        $sut = new Permissions('root', 'root', 0, 7, 0);
        $this->assertFalse($sut->canOwnerRead());
        $this->assertFalse($sut->canOwnerWrite());
        $this->assertFalse($sut->canOwnerExecute());
        $this->assertTrue($sut->canGroupRead());
        $this->assertTrue($sut->canGroupWrite());
        $this->assertTrue($sut->canGroupExecute());
        $this->assertFalse($sut->canAnonRead());
        $this->assertFalse($sut->canAnonWrite());
        $this->assertFalse($sut->canAnonExecute());
    }

    public function testMode776()
    {
        $sut = new Permissions('root', 'root', 7, 7, 6);
        $this->assertTrue($sut->canOwnerRead());
        $this->assertTrue($sut->canOwnerWrite());
        $this->assertTrue($sut->canOwnerExecute());
        $this->assertTrue($sut->canGroupRead());
        $this->assertTrue($sut->canGroupWrite());
        $this->assertTrue($sut->canGroupExecute());
        $this->assertTrue($sut->canAnonRead());
        $this->assertTrue($sut->canAnonWrite());
        $this->assertFalse($sut->canAnonExecute());
    }

    public function testMode775()
    {
        $sut = new Permissions('root', 'root', 7, 7, 5);
        $this->assertTrue($sut->canOwnerRead());
        $this->assertTrue($sut->canOwnerWrite());
        $this->assertTrue($sut->canOwnerExecute());
        $this->assertTrue($sut->canGroupRead());
        $this->assertTrue($sut->canGroupWrite());
        $this->assertTrue($sut->canGroupExecute());
        $this->assertTrue($sut->canAnonRead());
        $this->assertFalse($sut->canAnonWrite());
        $this->assertTrue($sut->canAnonExecute());
    }

    public function testMode774()
    {
        $sut = new Permissions('root', 'root', 7, 7, 4);
        $this->assertTrue($sut->canOwnerRead());
        $this->assertTrue($sut->canOwnerWrite());
        $this->assertTrue($sut->canOwnerExecute());
        $this->assertTrue($sut->canGroupRead());
        $this->assertTrue($sut->canGroupWrite());
        $this->assertTrue($sut->canGroupExecute());
        $this->assertTrue($sut->canAnonRead());
        $this->assertFalse($sut->canAnonWrite());
        $this->assertFalse($sut->canAnonExecute());
    }

    public function testMode773()
    {
        $sut = new Permissions('root', 'root', 7, 7, 3);
        $this->assertTrue($sut->canOwnerRead());
        $this->assertTrue($sut->canOwnerWrite());
        $this->assertTrue($sut->canOwnerExecute());
        $this->assertTrue($sut->canGroupRead());
        $this->assertTrue($sut->canGroupWrite());
        $this->assertTrue($sut->canGroupExecute());
        $this->assertFalse($sut->canAnonRead());
        $this->assertTrue($sut->canAnonWrite());
        $this->assertTrue($sut->canAnonExecute());
    }

    public function testMode772()
    {
        $sut = new Permissions('root', 'root', 7, 7, 2);
        $this->assertTrue($sut->canOwnerRead());
        $this->assertTrue($sut->canOwnerWrite());
        $this->assertTrue($sut->canOwnerExecute());
        $this->assertTrue($sut->canGroupRead());
        $this->assertTrue($sut->canGroupWrite());
        $this->assertTrue($sut->canGroupExecute());
        $this->assertFalse($sut->canAnonRead());
        $this->assertTrue($sut->canAnonWrite());
        $this->assertFalse($sut->canAnonExecute());
    }

    public function testMode771()
    {
        $sut = new Permissions('root', 'root', 7, 7, 1);
        $this->assertTrue($sut->canOwnerRead());
        $this->assertTrue($sut->canOwnerWrite());
        $this->assertTrue($sut->canOwnerExecute());
        $this->assertTrue($sut->canGroupRead());
        $this->assertTrue($sut->canGroupWrite());
        $this->assertTrue($sut->canGroupExecute());
        $this->assertFalse($sut->canAnonRead());
        $this->assertFalse($sut->canAnonWrite());
        $this->assertTrue($sut->canAnonExecute());
    }

    public function testMode770()
    {
        $sut = new Permissions('root', 'root', 7, 7, 0);
        $this->assertTrue($sut->canOwnerRead());
        $this->assertTrue($sut->canOwnerWrite());
        $this->assertTrue($sut->canOwnerExecute());
        $this->assertTrue($sut->canGroupRead());
        $this->assertTrue($sut->canGroupWrite());
        $this->assertTrue($sut->canGroupExecute());
        $this->assertFalse($sut->canAnonRead());
        $this->assertFalse($sut->canAnonWrite());
        $this->assertFalse($sut->canAnonExecute());
    }

    public function testMode007()
    {
        $sut = new Permissions('root', 'root', 0, 0, 7);
        $this->assertFalse($sut->canOwnerRead());
        $this->assertFalse($sut->canOwnerWrite());
        $this->assertFalse($sut->canOwnerExecute());
        $this->assertFalse($sut->canGroupRead());
        $this->assertFalse($sut->canGroupWrite());
        $this->assertFalse($sut->canGroupExecute());
        $this->assertTrue($sut->canAnonRead());
        $this->assertTrue($sut->canAnonWrite());
        $this->assertTrue($sut->canAnonExecute());
    }
}
