<?php

namespace Derby;

interface ConfigInterface
{

    public function setConfig(array $config);

    public function getConfig();

    public function isValid();

}