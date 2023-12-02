<?php
// prevent direct internet access to this file
!defined('CL_DIR') ? die(':-)') : '';

use cl\web\CLConfig;
use cl\web\CLDeployment;
include_once 'configData.php';

$env = CLDeployment::DEV; // change to CLDeployment::PROD; for your Live or production deployment
$clconfig = new CLConfig();
// specify your domain (optional) if your code needs to access this later
$clconfig->addAppConfig('domain', 'codelibfw.com')
    ->addAppConfig('httpclient', 'guzzle')
    // Let's add CSRF protection (see a hidden field generated in the openai request form).
    ->setCSRFStyle(CLREQUEST)
    // we can change the Codelib request key/flow key for this app. By default it is 'clkey'
    //->setClKey('mykey')
    // let's configure our openai related code
    ->addAppConfig(AI_API_PROVIDER, '#1')
    ->addAppConfig(AI_API_URL, 'https://api.openai.com/v1/')
    ->addAppConfig(AI_API_KEY, openaikey) // set value for this variable in configData.php
    // set deployment type (dev or prod)
    ->setDeploymentType($env);
