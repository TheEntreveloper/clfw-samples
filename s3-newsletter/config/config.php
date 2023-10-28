<?php
// prevent direct internet access to this file
!defined('CL_DIR') ? die(':-)') : '';

use cl\web\CLConfig;
use cl\web\CLDeployment;
include_once 'configData.php';

$env = CLDeployment::DEV; // change to CLDeployment::PROD; for your Live or production deployment
$clconfig = new CLConfig();
// set MySql connection details
$clconfig->setRepoConnDetails(CLMYSQL, array('server' => db[$env]['server'], 'user' => db[$env]['user'],
    'password' => db[$env]['pass'], 'dbname' => db[$env]['dbname']))
    // configure stmp details, using data from configData.php
    ->setEmailConfig([EMAIL_LIB => emailLib, MAIL_HOST => emailHost, 'username' => emailUser,
        'password' => emailPass, 'port' => emailPort])
    ->addAppConfig('domain', 'codelibfw.com')
    // uncomment next line and replace email address with yours to fix the configuration error you will get if you
    // run the app (see the logs/applog_error for details)
    //->addAppConfig('supportemail', 'youremail@domain.com')
    // we can change the Codelib request key/flow key for this app. By default it is 'clkey'
    //->setClKey('mykey')
    // set deployment type (dev or prod)
    ->setDeploymentType($env);
