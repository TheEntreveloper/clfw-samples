<?php
// prevent direct internet access to this file
!defined('CL_DIR') ? die(':-)') : '';

use cl\web\CLConfig;
use cl\web\CLDeployment;
include_once 'configData.php';

$env = CLDeployment::DEV; // change to CLDeployment::PROD; for your Live or production deployment
$clconfig = new CLConfig();
if ($env === CLDeployment::DEV) {
    // Development specific config settings
} else {
    // Live/Production specific config settings
}
// here we can config settings common for Dev and Prod
    $clconfig
    // we can change the Codelib request key/flow key for this app. By default it is 'clkey'
    //->setClKey('mykey')
    // set deployment type (dev or prod)
    ->setDeploymentType($env);
