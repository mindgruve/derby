<?php

namespace Derby\Tests\Unit\Media;

use Derby\Config;
use Derby\Config\YamlConfig;

class ConfigTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor(){
        $config = new YamlConfig();
    }


}