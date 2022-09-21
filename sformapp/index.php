<?php
// no namespace specified for this app, so it defaults to 'app'

/**
 * Copyright Codelib Framework (https://codelibfw.com)
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

define('BASE_DIR', __DIR__);
define('CL_DIR', BASE_DIR.'/vendor/CodelibFw/codelib-fw/src'.DIRECTORY_SEPARATOR);
define('APP_NS', __NAMESPACE__);
// kick-start Code-lib
if (!file_exists(CL_DIR . 'cl/CLStart.php')) {
    die ('<h3>Please use \'composer install\' from your shell or windows console before running this sample</h3>');
}
require CL_DIR . 'cl/CLStart.php';

$form = new \cl\ui\web\CLHtmlForm('','POST','index.php');
$form->addElement(new \cl\ui\web\CLHtmlLabel('name','userdata','Please enter your name'))
    ->addElement(new \cl\ui\web\CLHtmlInput('text','userdata','','','form-control'))
    ->addElement(new \cl\ui\web\CLHtmlButton('submit', '', 'Press here','', 'btn btn-success'));

$head = new \cl\ui\web\CLHtmlHead('Hello');
$head->addElement(new \cl\ui\web\CLHtmlLink('https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'))
    ->addElement(new \cl\ui\web\CLHtmlScript('https://code.jquery.com/jquery-3.5.1.slim.min.js'))
    ->addElement(new \cl\ui\web\CLHtmlScript('https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js'))
    ->addElement(new \cl\ui\web\CLHtmlScript('https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js'));
$page = new \cl\ui\web\CLHtmlPage($head);
$page->addElement(new \cl\ui\web\CLHtmlSpan());
$page->addElement($form);
$page2 = new \cl\ui\web\CLHtmlPage($head);
$page2->addElement(new \cl\ui\web\CLHtmlCtrl('h1','','User Welcoming Page'));
$page2->addElement(new \cl\ui\web\CLHtmlSpan());
$app = new \cl\web\CLHtmlApp();
$app->addPlugin('*/*', 'WelcomePlugin') // because of the key */*, WelcomePlugin will have access to any request
    ->addPlugin('pg1', 'HappyTooPlugin') // whereas HappyTooPlugin only has access to requests with key pg1
    ->addElement('pg1', $page, true) // we start with Page pg1 as our default page
    ->addElement('pg2', $page2)
    ->run();

