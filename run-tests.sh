#!/bin/bash
mkdir -p tests/Integration/Temp
php bin/phpunit --bootstrap vendor/autoload.php --colors --stop-on-error tests


