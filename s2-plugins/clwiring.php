<?php
define('BASE_DIR', __DIR__);
define('CL_DIR', BASE_DIR . '/vendor/codelibfw/codelib-fw/src' . DIRECTORY_SEPARATOR);
define('APP_NS', __NAMESPACE__);
// kick-start Code-lib
if (!file_exists(CL_DIR . 'cl/CLStart.php')) {
    die('<h3>Please use \'composer install\' from your shell or windows console before running this Application</h3>');
}

require CL_DIR . 'cl/CLStart.php';

