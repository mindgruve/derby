#!/bin/bash
mkdir -p tests/Integration/Temp
mkdir -p /tmp
php bin/phpunit --bootstrap vendor/autoload.php --colors --stop-on-error tests


