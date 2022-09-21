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

use cl\ui\web\CLHtmlButton;
use cl\ui\web\CLHtmlCtrl;
use cl\ui\web\CLHtmlDiv;
use cl\ui\web\CLHtmlForm;
use cl\ui\web\CLHtmlHead;
use cl\ui\web\CLHtmlLabel;
use cl\ui\web\CLHtmlLink;
use cl\ui\web\CLHtmlPage;
use cl\ui\web\CLHtmlScript;
use cl\ui\web\CLHtmlSpan;
use cl\ui\web\CLHtmlTextArea;
use cl\web\CLConfig;
use cl\web\CLDeployment;
use cl\web\CLHtmlApp;

define('BASE_DIR', __DIR__);
// differently to other CL samples, here we set CL from the vendor folder, as we have added Code-lib to composer.json
define('CL_DIR', BASE_DIR.'/vendor/CodelibFw/codelib-fw/src'.DIRECTORY_SEPARATOR); // <-- you can use absolute or relative location
//define('CL_DIR', BASE_DIR.'/../../code-lib/src'.DIRECTORY_SEPARATOR);
define('APP_NS', __NAMESPACE__);
// kick-start Code-lib
if (!file_exists(CL_DIR . 'cl/CLStart.php')) {
    die ('<h3>Please use \'composer install\' from your shell or windows console before running this sample</h3>');
}
require CL_DIR . 'cl/CLStart.php';

// here we create the form programmatically
// (in previous samples, like formupload1, we added the form as part of a look and feel, so it was in a separate html file)
$form = new CLHtmlForm('','POST','index.php/pg1'); // <-- here with index.php/pg1 we tell CL
                                                                                 // what flow should handle the submitted form
$form->addElement((new CLHtmlDiv())->addElement(
    new CLHtmlLabel('name','task1','Please enter details for task 1')))
    ->addElement((new CLHtmlDiv())->addElement(new CLHtmlTextArea('task[]', 5, 50, '', '', 'form-control')))

    ->addElement((new CLHtmlDiv())->addElement(
        new CLHtmlLabel('name','task2','Please enter details for task 2')))
    ->addElement((new CLHtmlDiv())->addElement(new CLHtmlTextArea('task[]', 5, 50, '', '', 'form-control')))

    ->addElement((new CLHtmlDiv())->addElement(
        new CLHtmlLabel('name','task3','Please enter details for task 3')))
    ->addElement((new CLHtmlDiv())->addElement(new CLHtmlTextArea('task[]', 5, 50, '', '', 'form-control')))

    ->addElement(new CLHtmlButton('submit', '', 'Press here','', 'btn btn-success'));

$head = new CLHtmlHead('Hello');
$head->addElement(new CLHtmlLink('https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'))
    ->addElement(new CLHtmlScript('https://code.jquery.com/jquery-3.5.1.slim.min.js'))
    ->addElement(new CLHtmlScript('https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js'))
    ->addElement(new CLHtmlScript('https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js'));
$page = new CLHtmlPage($head);
$page->addElement(new CLHtmlCtrl('h1', '', 'Tasks emailing form'))
     ->addElement(new CLHtmlCtrl('h2', '', 'Enter 3 tasks'))
     ->addElement(new CLHtmlCtrl('h2', '', 'Each task will then be emailed to a hardcoded  
     group of users to assign the task to'));
$page->addElement(new CLHtmlSpan());
$page->addElement($form);
$page2 = new CLHtmlPage($head);
$page2->addElement(new CLHtmlCtrl('h1','','Confirmation Page'));
$page2->addElement(new CLHtmlSpan());

$clconfig = new CLConfig();
$clconfig->addAppConfig(CSRFSTATUS, false)
    ->setEmailConfig([EMAIL_LIB => 'phpmailer', MAIL_HOST => 'localhost']) // we set phpmailer as default library. Swiftmailer
                                                                           // is also configured, so you can try swapping them here,
                                                                           // just change 'phpmailer' to 'swiftmailer'.
    ->addAppConfig('adminEmail', 'manager@funnytasks.fun'); // config entry specific to this sample app (see Plugin)
                                                            // replace with valid email address if you wish to test this
$app = new CLHtmlApp();
$app->setDeployment(new CLDeployment(CLDeployment::DEV, $clconfig), true)
    ->addPlugin('pg1', 'MailTaskPlugin')
    ->addElement('pg1', $page, true) // we start with Page pg1 as our default page
    ->addElement('pg2', $page2)
    ->run();

