<?php

namespace Derby;

interface ConfigInterface
{
    /**
     * @param array $config
     */
    public function setConfig(array $config);

    /**
     * @return array
     */
    public function getConfig();

    /**
     * @param array $config
     * @throws InvalidConfigException
     */
    public function validate(array $config = array());

}