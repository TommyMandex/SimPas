<?php
if(version_compare(phpversion(), '5.4.0', '<')) {
    die('Requires PHP 5.4 or higher');
}

use Application\Autoloader;
use Application\Application;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'library' . 
    DIRECTORY_SEPARATOR . 'Application' . 
    DIRECTORY_SEPARATOR . 'Autoloader.php';

new Autoloader();
new Application();