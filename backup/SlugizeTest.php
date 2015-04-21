<?php

namespace Derby\Tests\Utility;

use Derby\Utility\Slugize;
use PHPUnit_Framework_TestCase;

class SlugizeTest extends PHPUnit_Framework_TestCase
{

    public function testSlugize()
    {
        $this->assertEquals('foo-bar', Slugize::slugize('foo bar'));
        $this->assertEquals('foo-bar', Slugize::slugize('FOO BAR'));
        $this->assertEquals('foobar', Slugize::slugize('/foo/bar/'));
        
        $this->assertEquals('foobar', Slugize::slugize('foo!bar'));
        $this->assertEquals('foo-bar', Slugize::slugize('foo@bar'));
        $this->assertEquals('foo-bar', Slugize::slugize('foo#bar'));
        $this->assertEquals('foo-bar', Slugize::slugize('foo$bar'));
        $this->assertEquals('foo-bar', Slugize::slugize('foo%bar'));
        $this->assertEquals('foo-bar', Slugize::slugize('foo^bar'));
        $this->assertEquals('foo-bar', Slugize::slugize('foo&bar'));
        $this->assertEquals('foo-bar', Slugize::slugize('foo*bar'));
        $this->assertEquals('foo-bar', Slugize::slugize('foo(bar'));
        $this->assertEquals('foo-bar', Slugize::slugize('foo)bar'));
        $this->assertEquals('foo-bar', Slugize::slugize('foo{bar'));
        $this->assertEquals('foo-bar', Slugize::slugize('foo}bar'));
        $this->assertEquals('foobar', Slugize::slugize('foo:bar'));
        $this->assertEquals('foo-bar', Slugize::slugize('foo"bar'));
        $this->assertEquals('foo-bar', Slugize::slugize('foo+bar'));
        $this->assertEquals('foo-bar', Slugize::slugize('foo-bar'));
        
        $this->assertEquals('lueckenbuesser', Slugize::slugize('Lückenbüßer'));
        $this->assertEquals('-bergroesse', Slugize::slugize('Übergröße'));
        $this->assertEquals('ausserplanmaessig', Slugize::slugize('außerplanmäßig'));
        $this->assertEquals('vaelkommen', Slugize::slugize('välkommen!'));
    }
}
