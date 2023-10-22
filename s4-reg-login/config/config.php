<?php
// prevent direct internet access to this file
!defined('CL_DIR') ? die(':-)') : '';

use cl\web\CLConfig;
use cl\web\CLDeployment;
include_once 'configData.php';

$env = CLDeployment::DEV; // change to CLDeployment::PROD; for your Live or production deployment
$clconfig = new CLConfig();
$clconfig->setRepoConnDetails(CLMYSQL, array('server' => db[$env]['server'], 'user' => db[$env]['user'],
    'password' => db[$env]['pass'], 'dbname' => db[$env]['dbname']))
    ->addAppConfig('domain', 'codelibfw.com')
    // Let's add CSRF protection (see a hidden field generated in the registration and login form). As a simple test,
    // try refreshing thepage after just submitting either form. Without this field you can, with the field it should fail.
    ->setCSRFStyle(CLREQUEST)
    // we can change the Codelib request key/flow key for this app. By default it is 'clkey'
    //->setClKey('mykey')
    // set deployment type (dev or prod)
    ->setDeploymentType($env);
